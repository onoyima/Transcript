<?php

namespace App\Services;

use Yabacon\Paystack;
use Illuminate\Support\Facades\Log;
use App\Models\PaymentTransaction;
use App\Models\StudentTrans;

class PaystackService
{
    protected $paystack;
    protected $secretKey;
    protected $publicKey;

    public function __construct()
    {
        $this->secretKey = config('services.paystack.secret_key', env('PAYSTACK_SECRET_KEY'));
        $this->publicKey = config('services.paystack.public_key', env('PAYSTACK_PUBLIC_KEY'));
        $this->paystack = new Paystack($this->secretKey);
    }

    /**
     * Initialize a payment transaction
     */
    public function initializePayment($transcriptId, $email, $amount, $callbackUrl = null)
    {
        try {
            $transcriptApplication = StudentTrans::findOrFail($transcriptId);
            $student = $transcriptApplication->student;

            // Generate unique reference
            $reference = 'TRANS_' . time() . '_' . $transcriptId . '_' . uniqid();

            // Prepare payment data
            $paymentData = [
                'amount' => $amount * 100, // Paystack expects amount in kobo (multiply by 100)
                'email' => $email,
                'reference' => $reference,
                'callback_url' => $callbackUrl ?: route('student.transcript.payment.callback'),
                'metadata' => [
                    'transcript_id' => $transcriptId,
                    'student_id' => $student->id,
                    'application_type' => $transcriptApplication->application_type,
                    'category' => $transcriptApplication->category,
                    'type' => $transcriptApplication->type,
                    'destination' => $transcriptApplication->destination,
                ]
            ];

            // Initialize payment with Paystack
            $tranx = $this->paystack->transaction->initialize($paymentData);

            if ($tranx->status) {
                // Create or update payment transaction record
                $paymentTransaction = PaymentTransaction::updateOrCreate(
                    ['student_trans_id' => $transcriptId],
                    [
                        'amount' => $amount,
                        'transaction_status' => 'Pending',
                        'payment_method' => 'paystack',
                        'transaction_reference' => $reference,
                        'payment_response' => $tranx->data,
                        'notes' => 'Payment initialized with Paystack'
                    ]
                );

                return [
                    'status' => true,
                    'data' => $tranx->data,
                    'payment_transaction' => $paymentTransaction,
                    'authorization_url' => $tranx->data->authorization_url,
                    'access_code' => $tranx->data->access_code,
                    'reference' => $reference
                ];
            }

            return [
                'status' => false,
                'message' => 'Failed to initialize payment',
                'data' => $tranx
            ];

        } catch (\Exception $e) {
            Log::error('Paystack payment initialization error: ' . $e->getMessage(), [
                'transcript_id' => $transcriptId,
                'email' => $email,
                'amount' => $amount
            ]);

            return [
                'status' => false,
                'message' => 'Payment initialization failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Verify a payment transaction
     */
    public function verifyPayment($reference)
    {
        try {
            $tranx = $this->paystack->transaction->verify([
                'reference' => $reference
            ]);

            if ($tranx->status && $tranx->data->status === 'success') {
                // Find the payment transaction
                $paymentTransaction = PaymentTransaction::where('transaction_reference', $reference)->first();

                if ($paymentTransaction) {
                    // Update payment transaction
                    $paymentTransaction->update([
                        'transaction_status' => 'Success',
                        'payment_date' => now(),
                        'payment_response' => $tranx->data,
                        'notes' => 'Payment verified successfully'
                    ]);

                    // Update transcript application
                    $transcriptApplication = $paymentTransaction->studentTrans;
                    $transcriptApplication->update([
                        'payment_status' => 'Paid',
                        'application_status' => 'Processing'
                    ]);

                    return [
                        'status' => true,
                        'message' => 'Payment verified successfully',
                        'data' => $tranx->data,
                        'payment_transaction' => $paymentTransaction,
                        'transcript_application' => $transcriptApplication
                    ];
                }

                return [
                    'status' => false,
                    'message' => 'Payment transaction not found in database'
                ];
            }

            return [
                'status' => false,
                'message' => 'Payment verification failed',
                'data' => $tranx->data ?? null
            ];

        } catch (\Exception $e) {
            Log::error('Paystack payment verification error: ' . $e->getMessage(), [
                'reference' => $reference
            ]);

            return [
                'status' => false,
                'message' => 'Payment verification failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get payment details by reference
     */
    public function getPaymentDetails($reference)
    {
        try {
            $tranx = $this->paystack->transaction->verify([
                'reference' => $reference
            ]);

            return [
                'status' => $tranx->status,
                'data' => $tranx->data ?? null,
                'message' => $tranx->message ?? 'Unknown error'
            ];

        } catch (\Exception $e) {
            Log::error('Paystack get payment details error: ' . $e->getMessage(), [
                'reference' => $reference
            ]);

            return [
                'status' => false,
                'message' => 'Failed to get payment details: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get all transactions for a customer
     */
    public function getCustomerTransactions($email)
    {
        try {
            $tranx = $this->paystack->transaction->getList([
                'customer' => $email
            ]);

            return [
                'status' => $tranx->status,
                'data' => $tranx->data ?? [],
                'message' => $tranx->message ?? 'Success'
            ];

        } catch (\Exception $e) {
            Log::error('Paystack get customer transactions error: ' . $e->getMessage(), [
                'email' => $email
            ]);

            return [
                'status' => false,
                'message' => 'Failed to get customer transactions: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get public key for frontend integration
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }
}