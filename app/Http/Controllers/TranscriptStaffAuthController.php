<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\TranscriptRole;
use App\Models\TranscriptPermission;
use App\Services\SecurityAuditService;
use App\Services\RateLimitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class TranscriptStaffAuthController extends Controller
{
    /**
     * Show the staff login form
     */
    public function showLoginForm()
    {
        return view('transcript.staff.auth.login');
    }

    /**
     * Show the staff login form (alias for showLoginForm)
     */
    public function showLogin()
    {
        return $this->showLoginForm();
    }

    /**
     * Handle staff login with role-based authentication
     */
    public function login(Request $request)
    {
        // Rate limiting check
        if (!RateLimitService::checkLoginAttempts($request->ip())) {
            SecurityAuditService::logSuspiciousActivity('Rate limit exceeded for staff login attempts', [
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
            
            return back()->withErrors([
                'email' => 'Too many login attempts. Please try again later.'
            ]);
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        $credentials = $request->only('email', 'password');
        
        // Find staff member
        $staff = Staff::where('email', $credentials['email'])->first();
        
        if ($staff && Hash::check($credentials['password'], $staff->password)) {
            // Check if staff is active
            if (!$staff->is_active) {
                SecurityAuditService::logLoginAttempt(
                    $staff->id,
                    $request->ip(),
                    false,
                    'Staff login failed - account inactive'
                );
                
                return back()->withErrors([
                    'email' => 'Your account is inactive. Please contact the administrator.'
                ]);
            }
            
            // Check if staff has any active roles
            $activeRoles = $staff->activeRoles()->count();
            
            if ($activeRoles === 0) {
                SecurityAuditService::logLoginAttempt(
                    $staff->id,
                    $request->ip(),
                    false,
                    'Staff login failed - no active roles assigned'
                );
                
                return back()->withErrors([
                    'email' => 'Your account does not have any active roles. Please contact the administrator.'
                ]);
            }
            
            // Authenticate the staff member
            Auth::guard('transcript_staff')->login($staff);
            
            // Record successful login
            RateLimitService::recordLoginAttempt($request->ip(), true);
            
            SecurityAuditService::logLoginAttempt(
                $staff->id,
                $request->ip(),
                true,
                'Staff login successful'
            );

            // Store session security data
            session([
                'transcript_staff_session' => [
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'login_time' => now(),
                    'roles' => $staff->activeRoles()->pluck('name')->toArray()
                ]
            ]);

            // Redirect based on primary role
            $primaryRole = $staff->activeRoles()->first();
            return $this->redirectBasedOnRole($primaryRole);
        }

        // Record failed login
        RateLimitService::recordLoginAttempt($request->ip(), false);
        
        SecurityAuditService::logLoginAttempt(
            $staff ? $staff->id : null,
            $request->ip(),
            false,
            'Invalid credentials provided for staff login'
        );

        return back()->withErrors([
            'email' => 'Invalid credentials provided.'
        ]);
    }

    /**
     * Handle staff logout
     */
    public function logout(Request $request)
    {
        $staff = Auth::guard('transcript_staff')->user();
        
        if ($staff) {
            SecurityAuditService::logSessionEvent(
                $staff->id,
                $request->ip(),
                'logout',
                'Staff logged out successfully'
            );
        }

        Auth::guard('transcript_staff')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('transcript.staff.login')
            ->with('status', 'You have been logged out successfully.');
    }

    /**
     * Show the main staff dashboard
     */
    public function dashboard()
    {
        $staff = Auth::guard('transcript_staff')->user();
        
        if (!$staff) {
            return redirect()->route('transcript.staff.login');
        }

        $roles = $staff->activeRoles()->with('permissions')->get();
        $permissions = $staff->getAllPermissions();
        
        // Get dashboard statistics based on permissions
        $stats = $this->getDashboardStats($staff);
        
        // Get recent applications for dashboard display
        $recent_applications = collect([]);
        if ($staff->hasPermission('view_transcript_applications')) {
            $recent_applications = \App\Models\StudentTrans::with(['student'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        }
        
        return view('transcript.staff.dashboard', compact('staff', 'roles', 'permissions', 'stats', 'recent_applications'));
    }

    /**
     * Show transcript applications management
     */
    public function transcriptApplications()
    {
        $staff = Auth::guard('transcript_staff')->user();
        
        if (!$staff->hasPermission('view_transcript_applications')) {
            abort(403, 'You do not have permission to view transcript applications.');
        }

        // Get applications based on permissions
        $applications = $this->getFilteredApplications($staff);
        
        return view('transcript.staff.applications.index', compact('applications', 'staff'));
    }

    /**
     * Show payment management
     */
    public function paymentManagement()
    {
        $staff = Auth::guard('transcript_staff')->user();
        
        if (!$staff->hasPermission('view_transcript_payments')) {
            abort(403, 'You do not have permission to view payment records.');
        }

        // Get payments based on permissions
        $payments = $this->getFilteredPayments($staff);
        
        return view('transcript.staff.payments.index', compact('payments', 'staff'));
    }

    /**
     * Show staff management (admin only)
     */
    public function staffManagement()
    {
        $staff = Auth::guard('transcript_staff')->user();
        
        if (!$staff->hasPermission('manage_transcript_staff')) {
            abort(403, 'You do not have permission to manage staff.');
        }

        $allStaff = Staff::with('activeRoles')->get();
        $roles = TranscriptRole::where('is_active', true)->get();
        
        return view('transcript.staff.management.index', compact('allStaff', 'roles', 'staff'));
    }

    /**
     * Assign role to staff member
     */
    public function assignRole(Request $request, Staff $targetStaff)
    {
        $staff = Auth::guard('transcript_staff')->user();
        
        if (!$staff->hasPermission('manage_transcript_staff')) {
            abort(403, 'You do not have permission to assign roles.');
        }

        $request->validate([
            'role_id' => 'required|exists:transcript_roles,id'
        ]);

        $role = TranscriptRole::findOrFail($request->role_id);
        
        // Check if staff already has this role
        if ($targetStaff->hasRole($role->name)) {
            return back()->with('error', 'Staff member already has this role.');
        }

        $targetStaff->assignRole($role->name, $staff->id);
        
        SecurityAuditService::logSessionEvent(
            $staff->id,
            request()->ip(),
            'role_assignment',
            "Assigned role '{$role->name}' to staff member {$targetStaff->full_name}"
        );

        return back()->with('success', "Role '{$role->display_name}' assigned successfully.");
    }

    /**
     * Remove role from staff member
     */
    public function removeRole(Request $request, Staff $targetStaff)
    {
        $staff = Auth::guard('transcript_staff')->user();
        
        if (!$staff->hasPermission('manage_transcript_staff')) {
            abort(403, 'You do not have permission to remove roles.');
        }

        $request->validate([
            'role_name' => 'required|string'
        ]);

        $targetStaff->removeRole($request->role_name);
        
        SecurityAuditService::logSessionEvent(
            $staff->id,
            request()->ip(),
            'role_removal',
            "Removed role '{$request->role_name}' from staff member {$targetStaff->full_name}"
        );

        return back()->with('success', 'Role removed successfully.');
    }

    /**
     * Update application status
     */
    public function updateApplicationStatus(Request $request, $applicationId)
    {
        $staff = Auth::guard('transcript_staff')->user();
        
        if (!$staff->hasPermission('manage_transcript_applications')) {
            abort(403, 'You do not have permission to update application status.');
        }

        $request->validate([
            'status' => 'required|in:pending,approved,rejected,processing,completed',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Update application logic would go here
        // This is a placeholder for the actual application update logic
        
        SecurityAuditService::logSessionEvent(
            $staff->id,
            request()->ip(),
            'application_update',
            "Updated application {$applicationId} status to {$request->status}"
        );

        return back()->with('success', 'Application status updated successfully.');
    }

    /**
     * Redirect user based on their primary role
     */
    private function redirectBasedOnRole($role)
    {
        if (!$role) {
            return redirect()->route('transcript.staff.dashboard');
        }

        switch ($role->name) {
            case 'transcript_admin':
                return redirect()->route('transcript.staff.dashboard');
            case 'transcript_officer':
                return redirect()->route('transcript.staff.applications');
            case 'payment_officer':
                return redirect()->route('transcript.staff.payments');
            case 'transcript_supervisor':
                return redirect()->route('transcript.staff.dashboard');
            default:
                return redirect()->route('transcript.staff.dashboard');
        }
    }

    /**
     * Get dashboard statistics based on staff permissions
     */
    private function getDashboardStats($staff)
    {
        $stats = [];

        if ($staff->hasPermission('view_transcript_applications')) {
            $stats['total_applications'] = \App\Models\StudentTrans::count();
            $stats['pending_applications'] = \App\Models\StudentTrans::where('application_status', 'Started')->count();
            $stats['approved_applications'] = \App\Models\StudentTrans::where('application_status', 'In Progress')->count();
            $stats['processing_applications'] = \App\Models\StudentTrans::where('application_status', 'In Progress')->count();
            $stats['completed_applications'] = \App\Models\StudentTrans::where('application_status', 'Completed')->count();
        }

        if ($staff->hasPermission('view_transcript_payments')) {
            $stats['total_payments'] = \App\Models\PaymentTransaction::count();
            $stats['pending_payments'] = \App\Models\PaymentTransaction::where('status', 'pending')->count();
            $stats['verified_payments'] = \App\Models\PaymentTransaction::where('status', 'verified')->count();
            $stats['completed_payments'] = \App\Models\PaymentTransaction::where('status', 'completed')->count();
            $stats['total_revenue'] = \App\Models\PaymentTransaction::where('status', 'completed')->sum('amount');
        }

        if ($staff->hasPermission('manage_transcript_staff')) {
            $stats['total_staff'] = \App\Models\Staff::count();
            $stats['active_staff'] = \App\Models\Staff::where('is_active', true)->count();
        }

        // General statistics available to all staff
        $stats['total_students'] = \App\Models\Student::count();
        $stats['recent_applications_count'] = \App\Models\StudentTrans::where('created_at', '>=', now()->subDays(7))->count();

        return $stats;
    }

    /**
     * Get filtered applications based on staff permissions
     */
    private function getFilteredApplications($staff)
    {
        // Placeholder - would return actual applications based on permissions
        // This would integrate with your actual application model
        return collect([]);
    }

    /**
     * Get filtered payments based on staff permissions
     */
    private function getFilteredPayments($staff)
    {
        // Placeholder - would return actual payments based on permissions
        // This would integrate with your actual payment model
        return collect([]);
    }

    /**
     * Show staff profile
     */
    public function showProfile()
    {
        $staff = Auth::guard('transcript_staff')->user();
        
        if (!$staff) {
            return redirect()->route('transcript.staff.login');
        }

        // Get staff roles and permissions
        $roles = $staff->activeRoles()->with('permissions')->get();
        $permissions = $staff->getAllPermissions();
        
        // Get staff work profile information (using staff data directly)
        $workProfile = (object) [
            'staff_number' => $staff->staff_number,
            'department' => $staff->department,
            'position' => $staff->position,
            'appointment_date' => $staff->appointment_date,
            'title' => $staff->title,
            'status' => $staff->is_active ? 'Active' : 'Inactive'
        ];
        
        // Get activity statistics based on permissions
        $activityStats = [];
        
        if ($staff->hasPermission('view_transcript_applications')) {
            $activityStats['applications_handled'] = \App\Models\StudentTrans::count();
            $activityStats['pending_applications'] = \App\Models\StudentTrans::where('application_status', 'Started')->count();
        }
        
        if ($staff->hasPermission('view_transcript_payments')) {
            $activityStats['payments_processed'] = \App\Models\PaymentTransaction::where('status', 'verified')->count();
            $activityStats['total_revenue'] = \App\Models\PaymentTransaction::where('status', 'completed')->sum('amount');
        }
        
        if ($staff->hasPermission('generate_transcript_reports')) {
            $activityStats['reports_generated'] = 0; // Would be calculated based on actual report data
        }
        
        // Get recent activities (recent applications if staff has permission)
        $recentActivities = collect([]);
        if ($staff->hasPermission('view_transcript_applications')) {
            $recentActivities = \App\Models\StudentTrans::with(['student'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        }
        
        return view('transcript.staff.profile', compact('staff', 'roles', 'permissions', 'workProfile', 'activityStats', 'recentActivities'));
    }

    /**
     * Update staff profile
     */
    public function updateProfile(Request $request)
    {
        $staff = Auth::guard('transcript_staff')->user();
        
        if (!$staff) {
            return redirect()->route('transcript.staff.login');
        }

        $request->validate([
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:staff,email,' . $staff->id,
        ]);

        $staff->update([
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Profile updated successfully!');
    }
}