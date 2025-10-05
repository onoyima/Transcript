<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TranscriptStaffPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        if (!Auth::guard('transcript_staff')->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            return redirect()->route('transcript.staff.login');
        }

        $staff = Auth::guard('transcript_staff')->user();
        
        // Check if staff is active
        if (!$staff->is_active) {
            Auth::guard('transcript_staff')->logout();
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Account is inactive'], 403);
            }
            return redirect()->route('transcript.staff.login')
                ->withErrors(['email' => 'Your account has been deactivated.']);
        }

        // Check if staff has any of the required permissions
        if (!empty($permissions)) {
            $hasPermission = false;
            foreach ($permissions as $permission) {
                if ($staff->hasPermission($permission)) {
                    $hasPermission = true;
                    break;
                }
            }
            
            if (!$hasPermission) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Insufficient permissions'], 403);
                }
                return redirect()->route('transcript.staff.dashboard')
                    ->withErrors(['access' => 'You do not have permission to access this resource.']);
            }
        }

        return $next($request);
    }
}