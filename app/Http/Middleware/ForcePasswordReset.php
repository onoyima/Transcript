<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Student;

class ForcePasswordReset
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if student is verified through matric or security questions
        $verifiedStudentId = Session::get('verified_student_id');
        $verificationMethod = Session::get('verification_method');
        
        if ($verifiedStudentId && $verificationMethod) {
            $student = Student::find($verifiedStudentId);
            
            // Check if student needs to set up password (first time or forgotten)
            if ($student && (!$student->password || $student->password === '' || Session::get('force_password_reset'))) {
                // Don't redirect if already on password setup pages
                if (!$request->routeIs('student.password.setup') && 
                    !$request->routeIs('student.password.store') &&
                    !$request->routeIs('student.password.email.form') &&
                    !$request->routeIs('student.password.email.send')) {
                    return redirect()->route('student.password.setup');
                }
            }
        }

        return $next($request);
    }
}