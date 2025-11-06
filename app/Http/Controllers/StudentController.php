<?php
// app/Http/Controllers/StudentController.php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentAcademic;
use App\Models\StudentTrans;
use App\Models\PaymentTransaction;
use App\Services\SecurityAuditService;
use App\Services\RateLimitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Program;

class StudentController extends Controller
{
    // 1. Show Home Page
    public function showHome()
    {
        return view('student.home');
    }

    // 2. Show Matric Number Form
    public function showMatricForm()
    {
        return view('student.matric_form');
    }

    // 3. Process Matric Number
    public function processMatric(Request $request)
    {
        // Check rate limiting for verification attempts
        $rateLimitCheck = RateLimitService::checkVerificationLimit($request->matric_number);
        if (!$rateLimitCheck['allowed']) {
            SecurityAuditService::logSuspiciousActivity('Rate limit exceeded for matric verification', [
                'matric_number' => $request->matric_number,
                'ip_address' => $request->ip()
            ]);
            return back()->with('error', 'Too many verification attempts. Please try again in 15 minutes.');
        }

        // Check request frequency to prevent rapid automated requests
        if (!RateLimitService::checkRequestFrequency('matric_verification')) {
            return back()->with('error', 'Please slow down your requests and try again.');
        }

        // Validate the matric number
        $request->validate([
            'matric_number' => 'required|string|max:20',
        ]);

        // Fetch student academic data by matric number
        $studentAcademic = StudentAcademic::where('matric_no', $request->matric_number)->first();

        // Check if the student academic record is found
        if (!$studentAcademic) {
            return back()->with('error', 'Matric number not found!');
        }

        // Retrieve the student associated with the academic record
        $student = $studentAcademic->student;

        // Check if student exists
        if (!$student) {
            // Record failed verification attempt for rate limiting
            RateLimitService::recordVerificationAttempt($request->matric_number, false);
            
            SecurityAuditService::logVerificationAttempt(
                'matric_number', 
                $request->matric_number, 
                false, 
                null, 
                ['error' => 'Student not found']
            );
            return back()->with('error', 'No student found for this matric number.');
        }

        // Note: Duplicate applications are now allowed as students can pay for multiple transcripts

        // Record successful verification for rate limiting
        RateLimitService::recordVerificationAttempt($request->matric_number, true);

        // Log successful verification
        SecurityAuditService::logVerificationAttempt(
            'matric_number', 
            $request->matric_number, 
            true, 
            $student->id
        );

        // Store student ID in session for security tracking with additional security data
        Session::put('verified_student_id', $student->id);
        Session::put('verification_method', 'matric_number');
        Session::put('verification_time', now());
        Session::put('verification_ip', $request->ip());
        Session::put('verification_user_agent', $request->userAgent());

        SecurityAuditService::logSessionEvent('created', $student->id, [
            'verification_method' => 'matric_number',
            'ip_address' => $request->ip()
        ]);

        // Check if student needs to set up password
        if (!$student->password || $student->password === '') {
            Session::put('force_password_reset', true);
            return redirect()->route('student.password.setup');
        }

        // If student is found, show profile
        return view('student.profile', compact('student'));
    }

    // 4. Show Profile
    public function showProfile()
    {
        $student = Auth::guard('student')->user();
        
        // Load all related data
        $student->load([
            'studentAcademic.program',
            'studentContact',
            'studentMedical'
        ]);
        
        // Get academic information with program details
        $academicInfo = $student->studentAcademic;
        
        // Get contact information
        $contactInfo = $student->studentContact;
        
        // Get medical information
        $medicalInfo = $student->studentMedical;
        
        return view('student.profile', compact('student', 'academicInfo', 'contactInfo', 'medicalInfo'));
    }

    // 5. Show the Edit Details Form (Email and Phone only)
    public function showEditDetails(Request $request)
    {
        $matricNumber = $request->matric_number;

        if (!$matricNumber) {
            return redirect()->back()->with('error', 'Matric number is required to edit profile.');
        }

        $student = Student::where('matric_number', $matricNumber)->first();

        if (!$student) {
            return redirect()->back()->with('error', 'No student found with this matric number.');
        }

        return view('student.edit_details', compact('student'));
    }

    // 6. Update Student Details and Redirect to Payment
    public function updateDetails(Request $request)
    {
        // **SECURITY CHECK: Validate session**
        $verifiedStudentId = Session::get('verified_student_id');
        $verificationTime = Session::get('verification_time');
        
        if (!$verifiedStudentId || !$verificationTime) {
            return redirect()->route('student.home')->with('error', 'Session expired. Please verify your identity again.');
        }
        
        // Check if verification is still valid (30 minutes)
        if (now()->diffInMinutes($verificationTime) > 30) {
            Session::forget(['verified_student_id', 'verification_method', 'verification_time']);
            return redirect()->route('student.home')->with('error', 'Session expired. Please verify your identity again.');
        }

        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|max:20',
            'matric_number' => 'required'
        ], [
            'email.required' => 'Email is required.',
            'phone.required' => 'Phone number is required.',
            'phone.max' => 'Phone number is too long.',
        ]);

        try {
            $matricNumber = $request->matric_number;

            $student = Student::where('id', $matricNumber)->first();

            if (!$student || $student->id != $verifiedStudentId) {
                return back()->with('error', 'Security validation failed. Please start over.');
            }

            $student->update([
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            // Create student transaction record
            $studentTrans = StudentTrans::create([
                'student_id' => $student->id,
                'email' => $request->email,
                'phone' => $request->phone,
                'application_type' => 'Transcript Request',
                'payment_status' => 'Pending',
                'application_status' => 'Started'
            ]);

            return redirect()->route('student.payment.form', ['transId' => $studentTrans->id])
                             ->with('success', 'Details updated successfully!');

        } catch (\Exception $e) {
            \Log::error('Error updating student details: ' . $e->getMessage());
            return view('student.edit_details')->with('error', 'An error occurred while updating your details. Please try again.');
        }
    }

    // 7. Show Security Questions Form (For students who forgot their matric number)
    public function showSecurityQuestionsForm()
    {
        $programs = Program::where('status', 1)->get();
        return view('student.security_questions', compact('programs'));
    }

    // 8. Verify Security Questions
    public function verifySecurityQuestions(Request $request)
    {
        $request->validate([
            'surname' => 'required',
            'dob' => 'required|date',
            'program_id' => 'required|exists:programs,id',
        ], [
            'surname.required' => 'Surname is required.',
            'dob.required' => 'Date of birth is required.',
            'program_id.exists' => 'The selected program is invalid.',
        ]);

        // DB column is 'lname' (last name)
        $student = Student::where('lname', $request->surname)
            ->where('dob', $request->dob)
            ->first();

        if (!$student) {
            return back()->with('error', 'No student found with the provided details.');
        }

        $studentAcademic = StudentAcademic::where('student_id', $student->id)
            ->where('program_id', $request->program_id)
            ->first();

        if (!$studentAcademic) {
            return back()->with('error', 'Program ID does not match the student\'s record.');
        }

        // Note: Duplicate applications are now allowed as students can pay for multiple transcripts

        // Store student ID in session for security tracking
        Session::put('verified_student_id', $student->id);
        Session::put('verification_method', 'security_questions');
        Session::put('verification_time', now());

        // Check if student needs to set up password
        if (!$student->password || $student->password === '') {
            Session::put('force_password_reset', true);
            return redirect()->route('student.password.setup');
        }

        return view('student.profile', compact('student', 'studentAcademic'));
    }

    // 9. Show Payment Form Based on Application Type
    public function showPaymentForm($transId)
    {
        $transaction = Student::findOrFail($transId);
        return view('student.payment_form', compact('transaction'));
    }

    // 10. Process Payment and Update Transaction Status
    public function processPayment(Request $request, $transId)
    {
        $request->validate([
            'payment_method' => 'required',
            'amount' => 'required|numeric'
        ], [
            'payment_method.required' => 'Payment method is required.',
            'amount.required' => 'Amount is required.',
            'amount.numeric' => 'Amount must be a valid number.'
        ]);

        $existingTransaction = PaymentTransaction::where('student_trans_id', $transId)->first();
        if ($existingTransaction) {
            return back()->with('error', 'Payment has already been processed for this transaction.');
        }

        try {
            $paymentTransaction = PaymentTransaction::create([
                'student_trans_id' => $transId,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'transaction_status' => 'Success',
            ]);

            $studentTrans = StudentTrans::find($transId);
            $studentTrans->update([
                'payment_status' => 'Completed',
                'application_status' => 'Completed'
            ]);

            return redirect()->route('student.dashboard')->with('success', 'Payment successful!');
        } catch (\Exception $e) {
            \Log::error('Payment processing error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while processing your payment. Please try again.');
        }
    }

    // 11. Show the Student Dashboard with Application Status
    public function showDashboard()
    {
        $student = Auth::guard('student')->user();
        
        // Load student with academic information and program details
        $student->load(['studentAcademic.program']);
        
        $studentTrans = StudentTrans::where('student_id', $student->id)->get(); // Get all transactions for multiple applications
        
        // Get academic information
        $academicInfo = $student->studentAcademic;
        
        // Calculate dashboard statistics
        $stats = [
            'total_applications' => $studentTrans->count(),
            'pending_applications' => $studentTrans->where('application_status', 'Started')->count(),
            'completed_applications' => $studentTrans->where('application_status', 'Completed')->count(),
            'processing_applications' => $studentTrans->where('application_status', 'In Progress')->count(),
            'total_paid' => $studentTrans->where('payment_status', 'completed')->sum('amount'),
            'pending_payments' => $studentTrans->where('payment_status', 'pending')->count(),
        ];
        
        return view('student.dashboard', compact('studentTrans', 'student', 'academicInfo', 'stats'));
    }

    // 12. Show Transcript Application Form
    public function showTranscriptForm()
    {
        $student = Auth::guard('student')->user();
        return view('student.transcript.create', compact('student'));
    }

    // 12a. Get Pricing Information (AJAX)
    public function getPricingInfo(Request $request)
    {
        try {
            $pricingService = new \App\Services\TranscriptPricingService();
            
            if ($request->has('structure')) {
                // Return full pricing structure
                return response()->json([
                    'success' => true,
                    'pricing' => $pricingService->getPricingStructure()
                ]);
            }

            if ($request->has('payment_methods')) {
                // Return available payment methods
                return response()->json([
                    'success' => true,
                    'payment_methods' => $pricingService->getPaymentMethods()
                ]);
            }
            
            // Calculate pricing for specific request
            $breakdown = $pricingService->getFormattedBreakdown($request->all());
            
            return response()->json([
                'success' => true,
                'breakdown' => $breakdown
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error calculating pricing: ' . $e->getMessage()
            ], 500);
        }
    }

    // 13. Create New Transcript Application
    public function createTranscriptApplication(Request $request)
    {
        // Comprehensive validation for new 3-step form structure
        $rules = [
            // Step 1: Category (Undergraduate/Postgraduate)
            'application_type' => 'required|in:undergraduate,postgraduate',
            
            // Step 2: Request Type (Self/Institutional)
            'request_type' => 'required|in:self,institutional',
            
            // Common fields
            'purpose' => 'required|string|max:500',
        ];

        // Step 3: Conditional validation based on request type and delivery options
        if ($request->request_type === 'self') {
            // Self request validation
            $rules['delivery_option'] = 'required|in:self_physical,self_ecopy';
            
            if ($request->delivery_option === 'self_ecopy') {
                $rules['self_email'] = 'required|email';
            }
            // For self physical delivery, we might need delivery address
            if ($request->delivery_option === 'self_physical') {
                $rules['delivery_address'] = 'nullable|string|max:500';
            }
        } elseif ($request->request_type === 'institutional') {
            // Institutional request validation
            $rules['delivery_option'] = 'required|in:institutional_physical,institutional_ecopy';
            $rules['institution_name'] = 'required|string|max:255';
            $rules['institution_email'] = 'required|email';
            
            if ($request->delivery_option === 'institutional_physical') {
                // Only require phone for physical delivery
                $rules['institutional_phone'] = 'required|string|max:20';
                $rules['delivery_address'] = 'required|string|max:500';
                $rules['institutional_location'] = 'required|in:local_institutional,international_institutional';
                $rules['courier'] = 'required|in:dhl,zcarex,couples';
            } elseif ($request->delivery_option === 'institutional_ecopy') {
                // Only require delivery address for e-copy
                $rules['delivery_address'] = 'required|string|max:500';
            }
        }
        
        // Add number of copies validation
        $rules['number_of_copies'] = 'nullable|integer|min:1|max:10';

        $messages = [
            'application_type.required' => 'Please select a category (Undergraduate/Postgraduate).',
            'application_type.in' => 'Please select a valid category.',
            'request_type.required' => 'Please select a request type (Self/Institutional).',
            'request_type.in' => 'Please select a valid request type.',
            'delivery_option.required' => 'Please select a delivery option.',
            'delivery_option.in' => 'Please select a valid delivery option.',
            'purpose.required' => 'Please specify the purpose of your request.',
            'self_email.required' => 'Email is required for self e-copy delivery.',
            'self_email.email' => 'Please enter a valid email address.',
            'institution_name.required' => 'Institution name is required for institutional requests.',
            'institution_email.required' => 'Institution email is required for institutional requests.',
            'institution_email.email' => 'Please enter a valid institutional email address.',
            'institutional_phone.required' => 'Institution phone number is required for physical delivery.',
            'delivery_address.required' => 'Delivery address is required for institutional requests.',
            'institutional_location.required' => 'Please select institutional location (Local/International).',
            'courier.required' => 'Please select a courier service for physical delivery.',
        ];

        $request->validate($rules, $messages);

        try {
            $student = Auth::guard('student')->user();
            
            // Use pricing service to calculate total amount
            $pricingService = new \App\Services\TranscriptPricingService();
            $pricingBreakdown = $pricingService->calculateTotal($request->all());
            
            // Map new form fields to database fields
            $deliveryType = null;
            $destination = null;
            $email = $student->email;
            
            // Determine delivery type and destination based on delivery option
            if ($request->delivery_option === 'self_physical') {
                $deliveryType = 'physical';
                $destination = 'self';
                $email = $student->email;
            } elseif ($request->delivery_option === 'self_ecopy') {
                $deliveryType = 'ecopy';
                $destination = 'self';
                $email = $request->self_email;
            } elseif ($request->delivery_option === 'institutional_physical') {
                $deliveryType = 'physical';
                $destination = $request->institutional_location === 'local_institutional' ? 'local' : 'international';
                $email = $request->institution_email;
            } elseif ($request->delivery_option === 'institutional_ecopy') {
                $deliveryType = 'ecopy';
                $destination = 'institutional';
                $email = $request->institution_email;
            }

            $studentTrans = StudentTrans::create([
                'student_id' => $student->id,
                'application_type' => $request->application_type, // undergraduate/postgraduate
                'category' => $request->request_type, // self/institutional
                'type' => $deliveryType, // physical/ecopy
                'destination' => $destination, // self/local/international/institutional
                'courier' => $request->courier ?? null,
                'institution_name' => $request->institution_name ?? null,
                'ref_no' => 'TR' . time() . rand(100, 999), // Generate unique reference
                'institutional_phone' => $request->institutional_phone ?? null,
                'institutional_email' => $request->institution_email ?? null,
                'delivery_address' => $request->delivery_address ?? null,
                'purpose' => $request->purpose ?? 'Academic',
                'number_of_copies' => $request->number_of_copies ?? 1,
                'total_amount' => $pricingBreakdown['total'],
                'email' => $email,
                'phone' => $student->phone,
                'payment_status' => 'Pending',
                'application_status' => 'Started'
            ]);

            return redirect()->route('student.transcript.paystack.payment.form', $studentTrans->id)
                ->with('success', 'Application submitted successfully! Please proceed to payment.');
        } catch (\Exception $e) {
            \Log::error('Transcript application error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'An error occurred while submitting your application. Please try again.');
        }
    }

    // 14. Show Transcript Application History
    public function showTranscriptHistory()
    {
        $student = Auth::guard('student')->user();
        $applications = StudentTrans::where('student_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('student.transcript.history', compact('applications'));
    }

    // 15. Show Transcript Application Details
    public function showTranscriptDetails($id)
    {
        $student = Auth::guard('student')->user();
        $application = StudentTrans::where('student_id', $student->id)
            ->where('id', $id)
            ->firstOrFail();
        
        return view('student.transcript.show', compact('application'));
    }

    // 15a. Show Transcript Application Progress
    public function showTranscriptProgress($id)
    {
        $student = Auth::guard('student')->user();
        $transcriptApplication = StudentTrans::where('student_id', $student->id)
            ->where('id', $id)
            ->with(['paymentTransactions' => function($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->firstOrFail();
        
        return view('student.transcript.progress', compact('transcriptApplication'));
    }

    // 16. Show Payment History
    public function showPaymentHistory()
    {
        $student = Auth::guard('student')->user();
        $payments = PaymentTransaction::whereHas('studentTrans', function($query) use ($student) {
            $query->where('student_id', $student->id);
        })->with('studentTrans')->orderBy('created_at', 'desc')->get();
        
        return view('student.payments', compact('payments'));
    }

    // 17. Show Payment Details
    public function showPaymentDetails($id)
    {
        $student = Auth::guard('student')->user();
        $payment = PaymentTransaction::whereHas('studentTrans', function($query) use ($student) {
            $query->where('student_id', $student->id);
        })->with(['studentTrans.student'])->findOrFail($id);
        
        return view('student.payment_details', compact('payment'));
    }
}
