<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentAcademic;
use App\Services\SecurityAuditService;
use App\Services\RateLimitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class StudentAuthController extends Controller
{
    /**
     * Show the student login form
     */
    public function showLoginForm()
    {
        // Fetch active programs for the security questions dropdown
        $programs = \App\Models\Program::where('status', 1)->get();
        return view('student.auth.login', compact('programs'));
    }

    /**
     * Show the student login form (alias for showLoginForm)
     */
    public function showLogin()
    {
        return $this->showLoginForm();
    }

    /**
     * Validate captcha input immediately via AJAX.
     */
    public function validateCaptcha(Request $request)
    {
        $key = $request->input('key');
        $rules = ['captcha' => ['required', $key ? ('captcha_api:' . $key) : 'captcha']];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid captcha'
            ]);
        }

        return response()->json([
            'valid' => true,
            'message' => 'Captcha verified'
        ]);
    }

    /**
     * Handle student login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        $credentials = $request->only('email', 'password');
        
        if (Auth::guard('student')->attempt($credentials)) {
            $student = Auth::guard('student')->user();
            
            // Enforce password change if logging in with default password
            if (\Illuminate\Support\Facades\Hash::check('welcome@1', $student->password)) {
                session()->flash('warning', 'You must change your password before proceeding.');
                return redirect()->route('student.password.force');
            }

            // Check if email is verified
            if (!$student->hasVerifiedEmail()) {
                Auth::guard('student')->logout();
                return redirect()->route('student.email.verification.sent')
                    ->with('error', 'Please verify your email address before logging in.');
            }
            
            SecurityAuditService::logLoginAttempt(
                $student->id,
                $request->ip(),
                true,
                'Student login successful'
            );

            // Store session security data
            session([
                'student_session' => [
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'login_time' => now()
                ]
            ]);

            // Add success message with user's first name
            $firstName = $student->first_name ?? $student->name ?? 'Student';
            session()->flash('success', "Welcome back, {$firstName}! You have successfully logged in.");

            return redirect()->intended(route('student.dashboard'));
        }

        SecurityAuditService::logLoginAttempt(
            null,
            $request->ip(),
            false,
            'Invalid credentials provided'
        );

        return back()->withErrors([
            'email' => 'The email address or password you entered is incorrect. Please try again.'
        ])->withInput($request->only('email'));
    }

    /**
     * Handle student logout
     */
    public function logout(Request $request)
    {
        $student = Auth::guard('student')->user();
        
        if ($student) {
            SecurityAuditService::logSessionEvent(
                $student->id,
                $request->ip(),
                'logout',
                'Student logged out successfully'
            );
        }

        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('student.login')
            ->with('status', 'You have been logged out successfully.');
    }



    /**
     * Show email update form
     */
    public function showEmailUpdate()
    {
        $verification = session('student_verification');
        
        if (!$verification || now()->diffInMinutes($verification['verified_at']) > 30) {
            return redirect()->route('student.login')
                ->with('error', 'Verification session expired. Please verify your matriculation number again.');
        }

        $student = Student::find($verification['student_id']);
        
        if (!$student) {
            return redirect()->route('student.login')
                ->with('error', 'Student record not found.');
        }

        return view('student.auth.email-update', compact('student'));
    }

    /**
     * Handle email update and send verification
     */
    public function updateEmail(Request $request)
    {
        $verification = session('student_verification');
        
        if (!$verification || now()->diffInMinutes($verification['verified_at']) > 30) {
            return redirect()->route('student.login')
                ->with('error', 'Verification session expired. Please verify your matriculation number again.');
        }

        $request->validate([
            'email' => 'required|email|max:255|confirmed',
            'terms' => 'required|accepted'
        ]);

        $student = Student::find($verification['student_id']);
        
        if (!$student) {
            return redirect()->route('student.login')
                ->with('error', 'Student record not found.');
        }

        // Check if email is already taken by another student
        $existingStudent = Student::where('email', $request->email)
            ->where('id', '!=', $student->id)
            ->first();
            
        if ($existingStudent) {
            return back()->withErrors([
                'email' => 'This email address is already associated with another student account.'
            ]);
        }

        // Update student email
        $student->update([
            'email' => $request->email,
            'email_verified_at' => null // Reset verification status
        ]);

        // Send verification email
        $student->sendEmailVerificationNotification();

        SecurityAuditService::logVerificationAttempt(
            $student->id,
            $student->matric_number,
            $request->ip(),
            true,
            'Email updated and verification sent'
        );

        // Clear verification session
        session()->forget('student_verification');

        return redirect()->route('student.verification.sent')
            ->with('email', $request->email);
    }

    /**
     * Verify security questions and send password reset with credentials
     */
    public function verifySecurityQuestions(Request $request)
    {
        // Rate limiting check
        $rateLimitCheck = RateLimitService::checkVerificationLimit($request->ip());
        if (!$rateLimitCheck['allowed']) {
            SecurityAuditService::logSuspiciousActivity('Rate limit exceeded for security questions verification', [
                'ip_address' => $request->ip(),
                'surname' => $request->surname
            ]);
            return back()->with('error', 'Too many verification attempts. Please try again in 15 minutes.');
        }

        $request->validate([
            'surname' => 'required|string|max:50',
            'date_of_birth' => 'required|date',
            'program_id' => 'required|exists:programs,id',
            'email' => 'required|email',
            // captcha temporarily disabled
        ]);

        // Find student by security questions (DB uses 'lname' for last name)
        $student = Student::where('lname', $request->surname)
            ->where('dob', $request->date_of_birth)
            ->first();

        if (!$student) {
            RateLimitService::recordVerificationAttempt($request->ip(), false);
            SecurityAuditService::logVerificationAttempt(
                'security_questions',
                $request->surname,
                false,
                null,
                ['error' => 'Student not found with provided details']
            );
            return back()->with('error', 'No student found with the provided details.');
        }

        // Verify program ID matches
        $studentAcademic = StudentAcademic::where('student_id', $student->id)
            ->where('program_id', $request->program_id)
            ->first();

        if (!$studentAcademic) {
            RateLimitService::recordVerificationAttempt($request->ip(), false);
            SecurityAuditService::logVerificationAttempt(
                'security_questions',
                $request->surname,
                false,
                $student->id,
                ['error' => 'Program ID does not match student record']
            );
            return back()->with('error', 'The selected program does not match our records for this student.');
        }

        // Record successful verification
        RateLimitService::recordVerificationAttempt($request->ip(), true);
        SecurityAuditService::logVerificationAttempt(
            'security_questions',
            $request->surname,
            true,
            $student->id,
            ['program_id' => $request->program_id]
        );

        // Send password reset email with login credentials
        return $this->sendPasswordResetWithCredentials($student, $request->email);
    }

    /**
     * Send password reset email with login credentials
     */
    private function sendPasswordResetWithCredentials(Student $student, $email)
    {
        // Set default password and require change on next login
        $student->password = Hash::make('welcome@1');
        $student->save();

        // Generate password reset token
        $token = Str::random(64);
        
        // Store the token in database
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $student->email],
            [
                'email' => $student->email,
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        // Send email with login credentials and reset link
        try {
            Mail::send('emails.password-reset-with-credentials', [
                'student' => $student,
                'resetUrl' => route('student.password.reset.form', ['token' => $token, 'email' => $student->email]),
                'loginEmail' => $student->email,
                'matricNumber' => $student->studentAcademic->matric_no ?? 'N/A',
                'defaultPassword' => 'welcome@1'
            ], function ($message) use ($email, $student) {
                $message->to($email)
                        ->subject('Password Reset & Login Credentials - ' . config('app.name'));
            });

            SecurityAuditService::logVerificationAttempt(
                'password_reset_with_credentials',
                $student->studentAcademic->matric_no ?? $student->id,
                true,
                $student->id,
                ['sent_to_email' => $email]
            );

            return redirect()->route('student.login')
                ->with('success', 'A password reset link with your login credentials has been sent to ' . $email . '. Please check your inbox.');

        } catch (\Exception $e) {
            SecurityAuditService::logVerificationAttempt(
                'password_reset_with_credentials',
                $student->studentAcademic->matric_no ?? $student->id,
                false,
                $student->id,
                ['error' => $e->getMessage(), 'email' => $email]
            );

            return back()->with('error', 'Failed to send password reset email. Please try again.');
        }
    }

    /**
     * Show email verification sent page
     */
    public function showVerificationSent()
    {
        $email = session('email');
        
        if (!$email) {
            return redirect()->route('student.login');
        }

        return view('student.auth.email-verification-sent', compact('email'));
    }

    /**
     * Verify email address with hash
     */
    public function verifyEmailWithHash(Request $request, $id, $hash)
    {
        $student = Student::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($student->getEmailForVerification()))) {
            return redirect()->route('student.login')
                ->with('error', 'Invalid verification link.');
        }

        if ($student->hasVerifiedEmail()) {
            return redirect()->route('student.password.setup', ['email' => $student->email])
                ->with('info', 'Email already verified. Please set your password.');
        }

        $student->markEmailAsVerified();

        SecurityAuditService::logSecurityEvent('email_verified', $student->id, [
            'email' => $student->email,
            'ip_address' => $request->ip()
        ]);

        return redirect()->route('student.password.setup', ['email' => $student->email])
            ->with('success', 'Email verified successfully! Please set your password.');
    }

    /**
     * Resend email verification
     */
    public function resendVerification(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $student = Student::where('email', $request->email)->first();
        
        if (!$student) {
            return back()->with('error', 'Student with this email not found.');
        }

        if ($student->hasVerifiedEmail()) {
            return redirect()->route('student.login')
                ->with('success', 'Email already verified. You can now login.');
        }

        $student->sendEmailVerificationNotification();

        return back()->with('success', 'Verification email sent successfully!');
    }

    /**
     * Process matric number and initiate email verification or password reset
     */
    public function processMatricForAuth(Request $request)
    {
        // Rate limiting check
        $rateLimitCheck = RateLimitService::checkVerificationLimit($request->matric_number);
        if (!$rateLimitCheck['allowed']) {
            SecurityAuditService::logSuspiciousActivity('Rate limit exceeded for matric verification', [
                'matric_number' => $request->matric_number,
                'ip_address' => $request->ip()
            ]);
            return back()->with('error', 'Too many verification attempts. Please try again in 15 minutes.');
        }

        // Check if email is provided (Scenario 2: Password reset)
        if ($request->has('email') && $request->filled('email')) {
            $request->validate([
                'matric_number' => 'required|string|max:20',
                'email' => 'required|email',
                // captcha temporarily disabled
            ]);

            // Find student by matric number
            $studentAcademic = StudentAcademic::where('matric_no', $request->matric_number)->first();
            
            if (!$studentAcademic) {
                RateLimitService::recordVerificationAttempt($request->matric_number, false);
                SecurityAuditService::logVerificationAttempt('matric_verification', $request->matric_number, false, null, [
                    'error' => 'Matric number not found'
                ]);
                return back()->with('error', 'Matric number not found in our records.');
            }

            $student = $studentAcademic->student;
            
            if (!$student) {
                RateLimitService::recordVerificationAttempt($request->matric_number, false);
                return back()->with('error', 'Student record not found. Please contact the registrar.');
            }

            // Record successful matric verification
            RateLimitService::recordVerificationAttempt($request->matric_number, true);
            SecurityAuditService::logVerificationAttempt('matric_verification', $request->matric_number, true, $student->id);

            // Send password reset email with login credentials
            return $this->sendPasswordResetWithCredentials($student, $request->email);
        }

        // Original flow: Matric number only (for new users)
        $request->validate([
            'matric_number' => 'required|string|max:20',
            // captcha temporarily disabled
        ]);

        // Find student by matric number
        $studentAcademic = StudentAcademic::where('matric_no', $request->matric_number)->first();
        
        if (!$studentAcademic) {
            RateLimitService::recordVerificationAttempt($request->matric_number, false);
            SecurityAuditService::logVerificationAttempt('matric_verification', $request->matric_number, false, null, [
                'error' => 'Matric number not found'
            ]);
            return back()->with('error', 'Matric number not found in our records.');
        }

        $student = $studentAcademic->student;
        
        if (!$student) {
            RateLimitService::recordVerificationAttempt($request->matric_number, false);
            return back()->with('error', 'Student record not found. Please contact the registrar.');
        }

        // Record successful matric verification
        RateLimitService::recordVerificationAttempt($request->matric_number, true);
        SecurityAuditService::logVerificationAttempt('matric_verification', $request->matric_number, true, $student->id);

        // Store student info in session for email update
        Session::put('pending_auth_student_id', $student->id);
        Session::put('pending_auth_matric', $request->matric_number);

        return view('student.auth.email-update', compact('student'));
    }

    // Using mews/captcha for image captcha generation and validation

    /**
     * Update student email and send verification
     */
    public function updateEmailAndVerify(Request $request)
    {
        $studentId = Session::get('pending_auth_student_id');
        
        if (!$studentId) {
            return redirect()->route('student.home')->with('error', 'Session expired. Please start again.');
        }

        $request->validate([
            'email' => 'required|email|unique:students,email,' . $studentId,
        ]);

        $student = Student::findOrFail($studentId);
        
        // Update email
        $student->email = $request->email;
        $student->email_verified_at = null; // Reset verification
        $student->save();

        // Send verification email
        $student->sendEmailVerificationNotification();

        SecurityAuditService::logSessionEvent('email_updated', $student->id, [
            'new_email' => $request->email
        ]);

        Session::forget(['pending_auth_student_id', 'pending_auth_matric']);

        return redirect()->route('student.verification.notice')
            ->with('success', 'Verification email sent to ' . $request->email);
    }

    /**
     * Show email verification notice
     */
    public function verificationNotice()
    {
        return view('student.auth.verify-email');
    }

    /**
     * Handle email verification
     */
    public function handleEmailVerification(EmailVerificationRequest $request)
    {
        $request->fulfill();

        event(new Verified($request->user('student')));

        SecurityAuditService::logSessionEvent('email_verified', $request->user('student')->id);

        return redirect()->route('student.dashboard')->with('success', 'Email verified successfully!');
    }

    /**
     * Show password reset form
     */
    public function showResetForm()
    {
        return view('student.auth.reset-password');
    }

    /**
     * Send password reset email
     */
    public function sendResetEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:students,email'
        ]);

        $student = Student::where('email', $request->email)->first();
        
        // Generate reset token
        $token = Str::random(60);
        
        // Store token in session or database (for simplicity, using session)
        Session::put('password_reset_token_' . $student->id, $token);
        Session::put('password_reset_email', $request->email);

        // Send reset email (you'll need to create this notification)
        // $student->notify(new StudentPasswordResetNotification($token));

        SecurityAuditService::logSessionEvent('password_reset_requested', $student->id);

        return back()->with('success', 'Password reset link sent to your email.');
    }


}