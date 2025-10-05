<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaystackService;
use App\Models\StudentTrans;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaystackController extends Controller
{
    protected $paystackService;

    public function __construct(PaystackService $paystackService)
    {
        $this->paystackService = $paystackService;
    }

    /**
     * Show Paystack payment form
     */
    public function showPaymentForm($transcriptId)
    {
        try {
            $transcriptApplication = StudentTrans::findOrFail($transcriptId);
            $student = $transcriptApplication->student;
            
            // Check if user is authenticated and owns this transcript
            if (!Auth::guard('student')->check() || Auth::guard('student')->id() !== $student->id) {
                return redirect()->route('student.home')->with('error', 'Unauthorized access.');
            }
            
            // Check if payment already exists and is successful
            $existingPayment = PaymentTransaction::where('student_trans_id', $transcriptId)
                ->where('transaction_status', 'Success')
                ->first();
                
            if ($existingPayment) {
                return redirect()->route('student.transcript.history')
                    ->with('info', 'Payment has already been completed for this application.');
            }
            
            // Get Paystack public key for frontend
            $paystackPublicKey = $this->paystackService->getPublicKey();
            
            return view('student.transcript.paystack_payment', compact(
                'transcriptApplication', 
                'student', 
                'paystackPublicKey'
            ));
            
        } catch (\Exception $e) {
            Log::error('Error showing Paystack payment form: ' . $e->getMessage());
            return redirect()->route('student.transcript.history')
                ->with('error', 'Unable to load payment form. Please try again.');
        }
    }

    /**
     * Initialize Paystack payment
     */
    public function initializePayment(Request $request, $transcriptId)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $transcriptApplication = StudentTrans::findOrFail($transcriptId);
            $student = $transcriptApplication->student;
            
            // Check if user is authenticated and owns this transcript
            if (!Auth::guard('student')->check() || Auth::guard('student')->id() !== $student->id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }
            
            // Check if payment already exists and is successful
            $existingPayment = PaymentTransaction::where('student_trans_id', $transcriptId)
                ->where('transaction_status', 'Success')
                ->first();
                
            if ($existingPayment) {
                return response()->json([
                    'status' => false,
                    'message' => 'Payment has already been completed for this application'
                ], 400);
            }

            $email = $request->email;
            $amount = $transcriptApplication->total_amount;
            $callbackUrl = route('student.transcript.paystack.callback');

            $result = $this->paystackService->initializePayment($transcriptId, $email, $amount, $callbackUrl);

            if ($result['status']) {
                return response()->json([
                    'status' => true,
                    'message' => 'Payment initialized successfully',
                    'data' => [
                        'authorization_url' => $result['authorization_url'],
                        'access_code' => $result['access_code'],
                        'reference' => $result['reference']
                    ]
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => $result['message'] ?? 'Failed to initialize payment'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Paystack payment initialization error: ' . $e->getMessage(), [
                'transcript_id' => $transcriptId,
                'request_data' => $request->all()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Payment initialization failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Handle Paystack payment callback
     */
    public function handleCallback(Request $request)
    {
        try {
            $reference = $request->query('reference');
            
            if (!$reference) {
                return redirect()->route('student.transcript.history')
                    ->with('error', 'Invalid payment reference.');
            }

            $result = $this->paystackService->verifyPayment($reference);

            if ($result['status']) {
                $transcriptApplication = $result['transcript_application'];
                
                return redirect()->route('student.transcript.payment.success', $transcriptApplication->id)
                    ->with('success', 'Payment completed successfully! Your transcript application is now being processed.');
            }

            return redirect()->route('student.transcript.history')
                ->with('error', $result['message'] ?? 'Payment verification failed.');

        } catch (\Exception $e) {
            Log::error('Paystack callback error: ' . $e->getMessage(), [
                'request_data' => $request->all()
            ]);

            return redirect()->route('student.transcript.history')
                ->with('error', 'Payment processing failed. Please contact support if you made a payment.');
        }
    }

    /**
     * Verify payment manually
     */
    public function verifyPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reference' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $reference = $request->reference;
            $result = $this->paystackService->verifyPayment($reference);

            return response()->json($result);

        } catch (\Exception $e) {
            Log::error('Manual payment verification error: ' . $e->getMessage(), [
                'reference' => $request->reference
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Payment verification failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Show payment success page
     */
    public function paymentSuccess($transcriptId)
    {
        try {
            $transcriptApplication = StudentTrans::findOrFail($transcriptId);
            $student = $transcriptApplication->student;
            
            // Check if user is authenticated and owns this transcript
            if (!Auth::guard('student')->check() || Auth::guard('student')->id() !== $student->id) {
                return redirect()->route('student.home')->with('error', 'Unauthorized access.');
            }
            
            $paymentTransaction = PaymentTransaction::where('student_trans_id', $transcriptId)
                ->where('transaction_status', 'Success')
                ->first();
                
            if (!$paymentTransaction) {
                return redirect()->route('student.transcript.history')
                    ->with('error', 'Payment information not found.');
            }
            
            return view('student.transcript.paystack_success', compact(
                'transcriptApplication', 
                'paymentTransaction'
            ));
            
        } catch (\Exception $e) {
            Log::error('Error showing payment success page: ' . $e->getMessage());
            return redirect()->route('student.transcript.history')
                ->with('error', 'Unable to load payment details.');
        }
    }

    /**
     * Get payment status
     */
    public function getPaymentStatus($transcriptId)
    {
        try {
            $transcriptApplication = StudentTrans::findOrFail($transcriptId);
            $student = $transcriptApplication->student;
            
            // Check if user is authenticated and owns this transcript
            if (!Auth::guard('student')->check() || Auth::guard('student')->id() !== $student->id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }
            
            $paymentTransaction = PaymentTransaction::where('student_trans_id', $transcriptId)->first();
            
            return response()->json([
                'status' => true,
                'data' => [
                    'payment_status' => $transcriptApplication->payment_status,
                    'application_status' => $transcriptApplication->application_status,
                    'transaction_status' => $paymentTransaction->transaction_status ?? 'Not Found',
                    'amount' => $transcriptApplication->total_amount,
                    'payment_date' => $paymentTransaction->payment_date ?? null
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error getting payment status: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Unable to get payment status'
            ], 500);
        }
    }
}