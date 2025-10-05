<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentAcademic;
use App\Models\StudentTrans;
use App\Models\PaymentTransaction;
use App\Models\SecurityQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function showLoginForm()
    {
        return view('student.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        $student = Student::where('username', $credentials['username'])->first();

        if ($student && Hash::check($credentials['password'], $student->password)) {
            Auth::login($student);
            return redirect()->route('student.dashboard');
        }

        return back()->withErrors(['login_failed' => 'Invalid username or password']);
    }

    public function showDashboard()
    {
        return view('student.dashboard');
    }

    public function verifyMatric(Request $request)
    {
        $student = Student::where('id', $request->matric_number)->first();
        if ($student) {
            return view('student.updateDetails', compact('student'));
        }

        return back()->withErrors(['matric_not_found' => 'Matric number not found']);
    }

    public function updateDetails(Request $request)
    {
        $student = Auth::user();
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->save();

        $studentTrans = StudentTrans::create([
            'student_id' => $student->id,
            'email' => $request->email,
            'phone' => $request->phone,
            'application_type' => $request->application_type,
        ]);

        return redirect()->route('student.payment', ['student_trans_id' => $studentTrans->id]);
    }

    public function showPaymentPage($studentTransId)
    {
        return view('student.payment', ['studentTransId' => $studentTransId]);
    }

    public function makePayment(Request $request)
    {
        $payment = PaymentTransaction::create([
            'student_trans_id' => $request->student_trans_id,
            'amount' => $request->amount,
            'transaction_status' => 'Pending',
        ]);

        // Process payment here (e.g., Paystack or other gateway)
        // Update payment status to success or failed
        $payment->transaction_status = 'Success'; // for demo
        $payment->save();

        return redirect()->route('student.applicationProgress');
    }

    public function applicationProgress()
    {
        return view('student.progress');
    }



    
}
