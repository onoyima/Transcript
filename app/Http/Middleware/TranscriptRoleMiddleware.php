<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TranscriptRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is authenticated
        if (!Auth::guard('staff')->check()) {
            return redirect()->route('transcript.staff.login')
                ->with('error', 'Please login to access this page.');
        }

        $staff = Auth::guard('staff')->user();

        // If no roles specified, just check if authenticated
        if (empty($roles)) {
            return $next($request);
        }

        // Check if staff has any of the required roles
        $hasRequiredRole = false;
        foreach ($roles as $role) {
            if ($staff->hasRole($role)) {
                $hasRequiredRole = true;
                break;
            }
        }

        if (!$hasRequiredRole) {
            // Log unauthorized access attempt
            \Log::warning('Unauthorized access attempt', [
                'staff_id' => $staff->id,
                'staff_email' => $staff->email,
                'required_roles' => $roles,
                'staff_roles' => $staff->activeRoles->pluck('name')->toArray(),
                'route' => $request->route()->getName(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return redirect()->route('transcript.staff.dashboard')
                ->with('error', 'You do not have permission to access this page. Required roles: ' . implode(', ', $roles));
        }

        return $next($request);
    }
}