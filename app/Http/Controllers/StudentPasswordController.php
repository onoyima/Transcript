<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Mail\StudentPasswordSetupMail;

class StudentPasswordController extends Controller
{
    /**
     * Show the password setup form
     */
    public function showPasswordSetup()
    {
        $verifiedStudentId = Session::get('verified_student_id');
        
        if (!$verifiedStudentId) {
            return redirect()->route('student.home')->with('error', 'Session expired. Please verify your identity again.');
        }
        
        $student = Student::find($verifiedStudentId);
        
        if (!$student) {
            return redirect()->route('student.home')->with('error', 'Student not found.');
        }
        
        return view('student.password_setup', compact('student'));
    }
    
    /**
     * Show email form for password reset link
     */
    public function showEmailForm()
    {
        $verifiedStudentId = Session::get('verified_student_id');
        
        if (!$verifiedStudentId) {
            return redirect()->route('student.home')->with('error', 'Session expired. Please verify your identity again.');
        }
        
        $student = Student::find($verifiedStudentId);
        
        if (!$student) {
            return redirect()->route('student.home')->with('error', 'Student not found.');
        }
        
        return view('student.password_email_form', compact('student'));
    }
    
    /**
     * Send password reset email
     */
    public function sendPasswordResetEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        
        $verifiedStudentId = Session::get('verified_student_id');
        
        if (!$verifiedStudentId) {
            return redirect()->route('student.home')->with('error', 'Session expired. Please verify your identity again.');
        }
        
        $student = Student::find($verifiedStudentId);
        
        if (!$student) {
            return redirect()->route('student.home')->with('error', 'Student not found.');
        }
        
        // Update student email if provided
        $student->update(['email' => $request->email]);
        
        // Generate password reset token
        $token = Str::random(64);
        
        // Store token in password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );
        
        // Send email with password reset link
        try {
            Mail::to($request->email)->send(new StudentPasswordSetupMail($student, $token));
            
            return redirect()->route('student.home')->with('success', 
                'A password setup link has been sent to your email address. Please check your email and follow the instructions to set up your password.');
        } catch (\Exception $e) {
            \Log::error('Failed to send password reset email: ' . $e->getMessage());
            return back()->with('error', 'Failed to send email. Please try again later.');
        }
    }
    
    /**
     * Store the new password
     */
    public function storePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required'
        ], [
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.'
        ]);
        
        $verifiedStudentId = Session::get('verified_student_id');
        
        if (!$verifiedStudentId) {
            return redirect()->route('student.home')->with('error', 'Session expired. Please verify your identity again.');
        }
        
        $student = Student::find($verifiedStudentId);
        
        if (!$student) {
            return redirect()->route('student.home')->with('error', 'Student not found.');
        }
        
        // Update student password
        $student->update([
            'password' => Hash::make($request->password),
            'username' => $student->username ?: $student->email // Set username if not exists
        ]);
        
        // Clear the force password reset flag
        Session::forget('force_password_reset');
        
        // Log the student in
        auth('student')->login($student);
        
        return redirect()->route('student.profile')->with('success', 'Password set successfully! You are now logged in.');
    }
    
    /**
     * Show password reset form (from email link)
     */
    public function showResetForm($token)
    {
        return view('student.password_reset', compact('token'));
    }
    
    /**
     * Reset password from email link
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
        
        // Find the password reset token
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();
        
        if (!$passwordReset || !Hash::check($request->token, $passwordReset->token)) {
            return back()->with('error', 'Invalid or expired password reset token.');
        }
        
        // Check if token is not expired (24 hours)
        if (now()->diffInHours($passwordReset->created_at) > 24) {
            return back()->with('error', 'Password reset token has expired.');
        }
        
        // Find student by email
        $student = Student::where('email', $request->email)->first();
        
        if (!$student) {
            return back()->with('error', 'Student not found.');
        }
        
        // Update password
        $student->update([
            'password' => Hash::make($request->password),
            'username' => $student->username ?: $student->email
        ]);
        
        // Delete the password reset token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        
        // Log the student in
        auth('student')->login($student);
        
        return redirect()->route('student.profile')->with('success', 'Password reset successfully! You are now logged in.');
    }

    /**
     * Show force-change password form for logged-in students using default password
     */
    public function showForceChangeForm()
    {
        $student = auth('student')->user();
        if (!$student) {
            return redirect()->route('student.login');
        }
        return view('student.force_password_change', compact('student'));
    }

    /**
     * Update password from force-change form
     */
    public function forceChange(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed'
        ]);

        $student = auth('student')->user();
        if (!$student) {
            return redirect()->route('student.login');
        }

        $student->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('student.dashboard')->with('success', 'Password changed successfully.');
    }
}