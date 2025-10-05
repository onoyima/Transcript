<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Services\SecurityAuditService;

class ValidateStudentSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $student = Auth::guard('student')->user();

        if (!$student) {
            return redirect()->route('student.login')
                ->with('error', 'Please log in to continue.');
        }

        // Get or initialize session security data
        $sessionStudentId = Session::get('student_session_id');
        $sessionIp = Session::get('student_session_ip');
        $sessionUserAgent = Session::get('student_session_user_agent');
        $sessionTime = Session::get('student_session_time');

        // Initialize session security data if not present
        if (!$sessionStudentId || $sessionStudentId !== $student->id) {
            Session::put('student_session_id', $student->id);
            Session::put('student_session_ip', $request->ip());
            Session::put('student_session_user_agent', $request->userAgent());
            Session::put('student_session_time', now());

            SecurityAuditService::logSessionEvent('session_initialized', $student->id);
            return $next($request);
        }

        // Check session timeout (48 hours for authenticated sessions)
        if ($sessionTime && now()->diffInMinutes($sessionTime) > config('session.lifetime', 2880)) {
            SecurityAuditService::logSessionEvent('expired', $student->id);
            Auth::guard('student')->logout();
            Session::flush();
            return redirect()->route('student.login')
                ->with('error', 'Your session has expired. Please log in again.');
        }

        // Enhanced security: Check IP consistency
        if ($sessionIp && $sessionIp !== $request->ip()) {
            SecurityAuditService::logSuspiciousActivity('IP address mismatch during session', [
                'student_id' => $student->id,
                'original_ip' => $sessionIp,
                'current_ip' => $request->ip()
            ]);
            Auth::guard('student')->logout();
            Session::flush();
            return redirect()->route('student.login')
                ->with('error', 'Security violation detected. Please log in again.');
        }

        // Check User Agent consistency
        if ($sessionUserAgent && $sessionUserAgent !== $request->userAgent()) {
            SecurityAuditService::logSuspiciousActivity('User agent mismatch during session', [
                'student_id' => $student->id,
                'original_user_agent' => $sessionUserAgent,
                'current_user_agent' => $request->userAgent()
            ]);
            Auth::guard('student')->logout();
            Session::flush();
            return redirect()->route('student.login')
                ->with('error', 'Security violation detected. Please log in again.');
        }

        // Refresh session timestamp for active users
        Session::put('student_session_time', now());

        return $next($request);
    }
}
