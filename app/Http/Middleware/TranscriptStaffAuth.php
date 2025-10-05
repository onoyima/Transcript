<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TranscriptStaffAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('transcript_staff')->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            return redirect()->route('transcript.staff.login');
        }

        $staff = Auth::guard('transcript_staff')->user();
        
        // Check if staff is active (status = 1 means active)
        if ($staff->status != 1) {
            Auth::guard('transcript_staff')->logout();
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Account is inactive'], 403);
            }
            return redirect()->route('transcript.staff.login')
                ->withErrors(['email' => 'Your account has been deactivated.']);
        }

        return $next($request);
    }
}