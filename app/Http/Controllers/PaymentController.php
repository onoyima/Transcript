<?php
namespace App\Http\Controllers;

use App\Models\Remita;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Payment;
use App\Models\FeeType;
use App\Models\StudentAcademic;
use App\Models\StudentTrans;
use App\Models\PaymentTransaction;

class PaymentController extends Controller
{
    // Show Payment Form
    public function showPaymentForm($transId)
    {
        $student = Student::findOrFail($transId);
        $feeTypes = FeeType::where('status', 1)->get();
        return view('student.payment_form', compact('student', 'feeTypes'));
    }

    // Process Payment
    public function processPayment(Request $request, $transId)
    {
        // Validate the data from the form
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'fee_type_id' => 'required|exists:fee_types,id',
            'amount' => 'required|numeric',
        ]);

        try {
            // Retrieve the student and fee type
            $student = Student::findOrFail($request->student_id);
            $feeType = FeeType::findOrFail($request->fee_type_id);
            $amount = $request->amount;

            // Generate a unique order ID
            $orderId = uniqid('order_');

            // Create the payer's name
            $payerName = $student->first_name;
            if ($student->middle_name) {
                $payerName .= ' ' . $student->middle_name;
            }
            $payerName .= ' ' . $student->surname;

            // Create a payment record
            $payment = Payment::create([
                'student_id' => $student->id,
                'fee_type_id' => $feeType->id,
                'amount' => $amount,
                'status' => 'pending',
                'order_id' => $orderId,
                'payer_name' => $payerName,
                'payer_email' => $student->email,
                'payer_phone' => $student->phone,
                'service_type_id' => $feeType->provider_code,
                'description' => $feeType->descriptions,
            ]);

            // Initiate the payment with Remita
            $remita = new Remita();
            $response = $remita->generateRRR($payment, $feeType->id);

            // Check if the payment initiation was successful
            if (isset($response['status']) && $response['status'] == "01") {
                // Update payment status to 'approved'
                $payment->status = 'approved';
                $payment->transaction_id = $response['transaction_id'];
                $payment->save();

                return redirect()->route('student.payment.success', ['payment' => $payment->id])
                                 ->with('success', 'Payment successfully initiated');
            } else {
                return back()->with('error', 'Payment initiation failed. Please try again later.');
            }
        } catch (\Exception $e) {
            \Log::error('Payment processing error:', ['error' => $e->getMessage()]);
            return back()->with('error', 'An error occurred while processing the payment.');
        }
    }

    // Verify Payment
    public function verifyPayment($rrr)
    {
        $remita = Remita::where('rrr', $rrr)->first();
        if (!$remita) {
            return back()->with('error', 'Payment record not found.');
        }

        $response = $remita->verifyRRR();
        if ($response->status == '01') {
            return view('student.payment_success');
        } else {
            return view('student.payment_failed');
        }
    }

    // Payment Success
    public function success($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        return view('student.payment_success', compact('payment'));
    }

    // Show Transcript Payment Form
    public function showTranscriptPaymentForm($transcriptId)
    {
        $transcriptApplication = StudentTrans::findOrFail($transcriptId);
        $student = $transcriptApplication->student;
        
        // Check if payment already exists for this transcript
        $existingPayment = PaymentTransaction::where('student_trans_id', $transcriptId)
            ->where('transaction_status', '!=', 'Failed')
            ->first();
            
        if ($existingPayment && $existingPayment->transaction_status === 'Success') {
            return redirect()->route('student.transcript.history')
                ->with('info', 'Payment has already been completed for this application.');
        }
        
        return view('student.transcript.payment', compact('transcriptApplication', 'student', 'existingPayment'));
    }

    // Process Transcript Payment and Generate RRR
    public function processTranscriptPayment(Request $request, $transcriptId)
    {
        $request->validate([
            'transcript_id' => 'required|exists:student_trans,id',
        ]);

        try {
            $transcriptApplication = StudentTrans::findOrFail($transcriptId);
            $student = $transcriptApplication->student;

            // Generate a unique order ID
            $orderId = 'TRANS_' . time() . '_' . $transcriptId;

            // Create the payer's name
            $payerName = $student->first_name;
            if ($student->middle_name) {
                $payerName .= ' ' . $student->middle_name;
            }
            $payerName .= ' ' . $student->surname;

            // Create a payment transaction record
            $paymentTransaction = PaymentTransaction::create([
                'student_trans_id' => $transcriptId,
                'amount' => $transcriptApplication->total_amount,
                'transaction_status' => 'Pending',
                'order_id' => $orderId,
                'payer_name' => $payerName,
                'payer_email' => $transcriptApplication->email,
                'payer_phone' => $transcriptApplication->phone,
            ]);

            // Create a payment record for Remita integration
            $payment = Payment::create([
                'student_id' => $student->id,
                'fee_type_id' => 1, // Transcript fee type (you may need to create this)
                'amount' => $transcriptApplication->total_amount,
                'status' => 'pending',
                'order_id' => $orderId,
                'payer_name' => $payerName,
                'payer_email' => $transcriptApplication->email,
                'payer_phone' => $transcriptApplication->phone,
                'service_type_id' => config('app.REMITA_SERVICE_TYPE_ID', '8422574399'), // Transcript service type
                'description' => 'Transcript Application Payment - ' . $transcriptApplication->application_type,
            ]);

            // Generate RRR with Remita
            $remita = new Remita();
            $response = $remita->generateRRR($payment, $transcriptId);

            // Check if the RRR generation was successful
            if (isset($response['status']) && $response['status'] == "01") {
                // Update payment status and store RRR
                $payment->status = 'approved';
                $payment->transaction_id = $response['RRR'] ?? $response['transaction_id'];
                $payment->save();

                // Update payment transaction with RRR
                $paymentTransaction->rrr = $response['RRR'] ?? $response['transaction_id'];
                $paymentTransaction->transaction_status = 'RRR_Generated';
                $paymentTransaction->save();

                // Store RRR in Remita table for tracking
                Remita::create([
                    'student_id' => $student->id,
                    'rrr' => $response['RRR'] ?? $response['transaction_id'],
                    'order_id' => $orderId,
                    'fee_type' => 'Transcript',
                    'fee_type_id' => 1,
                    'service_type_id' => config('app.REMITA_SERVICE_TYPE_ID', '8422574399'),
                    'amount' => $transcriptApplication->total_amount,
                    'status_code' => '25', // Reference Generated
                    'status' => 'Reference Generated',
                ]);

                return redirect()->route('student.transcript.payment.success', ['transcriptId' => $transcriptId])
                    ->with('success', 'RRR generated successfully! Please proceed to make payment.');
            } else {
                $paymentTransaction->transaction_status = 'Failed';
                $paymentTransaction->save();
                
                return back()->with('error', 'RRR generation failed. Please try again later.');
            }
        } catch (\Exception $e) {
            \Log::error('Transcript payment processing error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while processing the payment. Please try again.');
        }
    }

    // Show Transcript Payment Success
    public function transcriptPaymentSuccess($transcriptId)
    {
        $transcriptApplication = StudentTrans::findOrFail($transcriptId);
        $paymentTransaction = PaymentTransaction::where('student_trans_id', $transcriptId)
            ->where('transaction_status', 'RRR_Generated')
            ->first();
            
        if (!$paymentTransaction) {
            return redirect()->route('student.transcript.history')
                ->with('error', 'Payment information not found.');
        }
        
        return view('student.transcript.payment_success', compact('transcriptApplication', 'paymentTransaction'));
    }

    // Show Transcript Payment Failure
    public function transcriptPaymentFailure($transcriptId)
    {
        $transcriptApplication = StudentTrans::findOrFail($transcriptId);
        $paymentTransaction = PaymentTransaction::where('student_trans_id', $transcriptId)
            ->orderBy('created_at', 'desc')
            ->first();
            
        return view('student.transcript.payment_failure', compact('transcriptApplication', 'paymentTransaction'));
    }

    // Verify Transcript Payment
    public function verifyTranscriptPayment($rrr)
    {
        $remita = Remita::where('rrr', $rrr)->first();
        if (!$remita) {
            return back()->with('error', 'Payment record not found.');
        }

        $response = $remita->verifyRRR($rrr);
        
        if (isset($response['status']) && $response['status'] == '01') {
            // Update payment status
            $remita->status_code = '01';
            $remita->status = 'Transaction Approved';
            $remita->save();
            
            // Update payment transaction
            $paymentTransaction = PaymentTransaction::where('rrr', $rrr)->first();
            if ($paymentTransaction) {
                $paymentTransaction->transaction_status = 'Success';
                $paymentTransaction->save();
                
                // Update transcript application payment status
                $transcriptApplication = $paymentTransaction->studentTrans;
                $transcriptApplication->payment_status = 'Paid';
                $transcriptApplication->application_status = 'Processing';
                $transcriptApplication->save();
            }
            
            return redirect()->route('student.transcript.history')
                ->with('success', 'Payment verified successfully! Your transcript application is now being processed.');
        } else {
            return back()->with('error', 'Payment verification failed. Please contact support if you have made the payment.');
        }
    }
}
