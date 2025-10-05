<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAuth
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
        // Check if student is authenticated using the 'student' guard
        if (!Auth::guard('student')->check()) {
            return redirect()->route('student.login')
                ->with('error', 'Please login to access this page.');
        }

        // Check if student's email is verified
        $student = Auth::guard('student')->user();
        if (!$student->hasVerifiedEmail()) {
            return redirect()->route('student.email.verification.sent')
                ->with('error', 'Please verify your email address to continue.');
        }

        return $next($request);
    }
}