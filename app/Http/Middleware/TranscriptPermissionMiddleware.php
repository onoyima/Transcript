<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TranscriptPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        // Check if user is authenticated
        if (!Auth::guard('staff')->check()) {
            return redirect()->route('transcript.staff.login')
                ->with('error', 'Please login to access this page.');
        }

        $staff = Auth::guard('staff')->user();

        // If no permissions specified, just check if authenticated
        if (empty($permissions)) {
            return $next($request);
        }

        // Check if staff has any of the required permissions
        $hasRequiredPermission = false;
        foreach ($permissions as $permission) {
            if ($staff->hasPermission($permission)) {
                $hasRequiredPermission = true;
                break;
            }
        }

        if (!$hasRequiredPermission) {
            // Log unauthorized access attempt
            \Log::warning('Unauthorized permission access attempt', [
                'staff_id' => $staff->id,
                'staff_email' => $staff->email,
                'required_permissions' => $permissions,
                'staff_permissions' => $staff->getAllPermissions()->pluck('name')->toArray(),
                'route' => $request->route()->getName(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return redirect()->route('transcript.staff.dashboard')
                ->with('error', 'You do not have permission to perform this action. Required permissions: ' . implode(', ', $permissions));
        }

        return $next($request);
    }
}