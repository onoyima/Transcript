<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\TranscriptRole;
use App\Models\TranscriptPermission;
use App\Services\SecurityAuditService;
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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        $credentials = $request->only('email', 'password');
        
        // Debug logging
        \Log::info('Login attempt', ['email' => $credentials['email']]);
        
        // Find staff member
        $staff = Staff::where('email', $credentials['email'])->first();
        
        if (!$staff) {
            \Log::info('Staff not found', ['email' => $credentials['email']]);
            return back()->withErrors([
                'email' => 'These credentials do not match our records.'
            ]);
        }
        
        \Log::info('Staff found', ['id' => $staff->id, 'email' => $staff->email, 'status' => $staff->status]);
        
        if (!Hash::check($credentials['password'], $staff->password)) {
            \Log::info('Password check failed', ['staff_id' => $staff->id]);
            return back()->withErrors([
                'email' => 'These credentials do not match our records.'
            ]);
        }
        
        \Log::info('Password check passed', ['staff_id' => $staff->id]);
        
        // Check if staff is active (status = 1 means active)
        if ($staff->status != 1) {
            \Log::info('Status check failed', ['staff_id' => $staff->id, 'status' => $staff->status]);
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
        \Log::info('Active roles check', ['staff_id' => $staff->id, 'active_roles_count' => $activeRoles]);
        
        if ($activeRoles === 0) {
            \Log::info('Active roles check failed', ['staff_id' => $staff->id]);
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
        \Log::info('Authentication successful', ['staff_id' => $staff->id, 'email' => $staff->email]);
        
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
     * Show transcript applications (alias for transcriptApplications)
     */
    public function applications()
    {
        return $this->transcriptApplications();
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
     * Show payments index (alias for paymentManagement)
     */
    public function payments()
    {
        return $this->paymentManagement();
    }

    /**
     * Show individual payment details
     */
    public function showPayment($id)
    {
        $staff = Auth::guard('transcript_staff')->user();
        
        if (!$staff->hasPermission('view_transcript_payments')) {
            abort(403, 'You do not have permission to view payment records.');
        }

        $payment = \App\Models\PaymentTransaction::with(['studentTrans.student'])
            ->findOrFail($id);
        
        return view('transcript.staff.payments.show', compact('payment', 'staff'));
    }

    /**
     * Show staff management (admin only)
     */
    public function staffManagement(Request $request)
    {
        $staff = Auth::guard('transcript_staff')->user();
        
        if (!$staff->hasPermission('manage_transcript_staff')) {
            abort(403, 'You do not have permission to manage staff.');
        }

        // Build query to fetch only staff with roles
        $query = Staff::with('activeRoles')
            ->whereHas('activeRoles'); // Only fetch staff that have at least one active role

        // Apply search filter if provided
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('fname', 'like', "%{$search}%")
                  ->orWhere('lname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%");
            });
        }

        // Apply role filter if provided
        if ($request->filled('role_filter')) {
            $roleFilter = $request->get('role_filter');
            $query->whereHas('activeRoles', function($q) use ($roleFilter) {
                $q->where('name', $roleFilter);
            });
        }

        $allStaff = $query->orderBy('fname')->orderBy('lname')->get();
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
            $stats['pending_payments'] = \App\Models\PaymentTransaction::where('transaction_status', 'Pending')->count();
            $stats['verified_payments'] = \App\Models\PaymentTransaction::where('transaction_status', 'Success')->count();
            $stats['completed_payments'] = \App\Models\PaymentTransaction::where('transaction_status', 'Success')->count();
            $stats['total_revenue'] = \App\Models\PaymentTransaction::where('transaction_status', 'Success')->sum('amount');
        }

        if ($staff->hasPermission('manage_transcript_staff')) {
            $stats['total_staff'] = \App\Models\Staff::count();
            $stats['active_staff'] = \App\Models\Staff::where('status', 1)->count();
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
        // Get applications based on staff permissions
        $query = \App\Models\StudentTrans::with(['student', 'paymentTransactions'])
            ->orderBy('created_at', 'desc');
        
        // If staff has limited permissions, they might only see certain applications
        // For now, all staff with application viewing permissions can see all applications
        // This can be customized based on specific business rules
        
        return $query->get();
    }

    /**
     * Get filtered payments based on staff permissions
     */
    private function getFilteredPayments($staff)
    {
        // Get payments based on staff permissions
        $query = \App\Models\PaymentTransaction::with(['studentTrans.student'])
            ->orderBy('created_at', 'desc');
        
        // If staff has limited permissions, they might only see certain payments
        // For now, all staff with payment viewing permissions can see all payments
        // This can be customized based on specific business rules
        
        return $query->get();
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
            'status' => $staff->status == 1 ? 'Active' : 'Inactive'
        ];
        
        // Get activity statistics based on permissions
        $activityStats = [];
        
        if ($staff->hasPermission('view_transcript_applications')) {
            $activityStats['applications_handled'] = \App\Models\StudentTrans::count();
            $activityStats['pending_applications'] = \App\Models\StudentTrans::where('application_status', 'Started')->count();
        }
        
        if ($staff->hasPermission('view_transcript_payments')) {
            $activityStats['payments_processed'] = \App\Models\PaymentTransaction::where('transaction_status', 'Success')->count();
            $activityStats['total_revenue'] = \App\Models\PaymentTransaction::where('transaction_status', 'Success')->sum('amount');
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

    /**
     * Admin Dashboard - Shows all applications for management
     * Requires transcript_admin or transcript_supervisor role
     */
    public function adminDashboard()
    {
        $staff = Auth::guard('transcript_staff')->user();
        
        // Check if staff has admin permissions
        if (!$staff->hasAnyRole(['transcript_admin', 'transcript_supervisor'])) {
            abort(403, 'You do not have permission to access the admin dashboard.');
        }

        // Get all applications with student information
        $applications = \App\Models\StudentTrans::with(['student'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get summary statistics
        $stats = [
            'total_applications' => $applications->count(),
            'pending_applications' => $applications->where('application_status', 'Started')->count(),
            'in_progress_applications' => $applications->where('application_status', 'In Progress')->count(),
            'completed_applications' => $applications->where('application_status', 'Completed')->count(),
            'pending_payments' => $applications->where('payment_status', 'Pending')->count(),
            'completed_payments' => $applications->where('payment_status', 'Completed')->count(),
        ];
        
        return view('transcript.staff.admin.dashboard', compact('applications', 'stats', 'staff'));
    }

    /**
     * Update Application Status - Admin function
     */
    public function updateApplicationStatus(Request $request, $id)
    {
        $staff = Auth::guard('transcript_staff')->user();
        
        // Check if staff has admin permissions
        if (!$staff->hasAnyRole(['transcript_admin', 'transcript_supervisor'])) {
            abort(403, 'You do not have permission to update application status.');
        }

        $request->validate([
            'application_status' => 'required|in:Started,In Progress,Completed',
            'payment_status' => 'required|in:Pending,Completed,Failed'
        ]);

        $application = \App\Models\StudentTrans::findOrFail($id);
        
        $oldApplicationStatus = $application->application_status;
        $oldPaymentStatus = $application->payment_status;
        
        $application->update([
            'application_status' => $request->application_status,
            'payment_status' => $request->payment_status
        ]);

        // Log the status update
        SecurityAuditService::logSessionEvent(
            $staff->id,
            request()->ip(),
            'application_status_update',
            "Updated application {$application->id} status from '{$oldApplicationStatus}' to '{$request->application_status}' and payment status from '{$oldPaymentStatus}' to '{$request->payment_status}'"
        );

        return back()->with('success', 'Application status updated successfully.');
    }

    /**
     * Show reports dashboard
     */
    public function reports()
    {
        $staff = Auth::guard('transcript_staff')->user();
        
        if (!$staff->hasPermission('generate_transcript_reports')) {
            abort(403, 'You do not have permission to generate reports.');
        }

        // Get report statistics
        $stats = $this->getReportStats($staff);
        
        return view('transcript.staff.reports.index', compact('staff', 'stats'));
    }

    /**
     * Generate specific report
     */
    public function generateReport(Request $request)
    {
        $staff = Auth::guard('transcript_staff')->user();
        
        if (!$staff->hasPermission('generate_transcript_reports')) {
            abort(403, 'You do not have permission to generate reports.');
        }

        $request->validate([
            'report_type' => 'required|in:applications,payments,staff,summary',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from'
        ]);

        $reportData = $this->generateReportData($request->report_type, $request->date_from, $request->date_to);
        
        return response()->json($reportData);
    }

    /**
     * Get report statistics
     */
    private function getReportStats($staff)
    {
        $stats = [];

        if ($staff->hasPermission('view_transcript_applications')) {
            $stats['applications'] = [
                'total' => \App\Models\StudentTrans::count(),
                'this_month' => \App\Models\StudentTrans::whereMonth('created_at', now()->month)->count(),
                'pending' => \App\Models\StudentTrans::where('application_status', 'Started')->count(),
                'completed' => \App\Models\StudentTrans::where('application_status', 'Completed')->count()
            ];
        }

        if ($staff->hasPermission('view_transcript_payments')) {
            $stats['payments'] = [
                'total' => \App\Models\PaymentTransaction::count(),
                'this_month' => \App\Models\PaymentTransaction::whereMonth('created_at', now()->month)->count(),
                'total_revenue' => \App\Models\PaymentTransaction::where('transaction_status', 'Success')->sum('amount'),
                'pending' => \App\Models\PaymentTransaction::where('transaction_status', 'Pending')->count()
            ];
        }

        if ($staff->hasPermission('manage_transcript_staff')) {
            $stats['staff'] = [
                'total' => \App\Models\Staff::count(),
                'active' => \App\Models\Staff::where('status', 1)->count(),
                'with_roles' => \App\Models\Staff::whereHas('activeRoles')->count()
            ];
        }

        return $stats;
    }

    /**
     * Generate report data based on type and date range
     */
    private function generateReportData($type, $dateFrom = null, $dateTo = null)
    {
        $query = null;
        $data = [];

        switch ($type) {
            case 'applications':
                $query = \App\Models\StudentTrans::with(['student']);
                break;
            case 'payments':
                $query = \App\Models\PaymentTransaction::with(['studentTrans.student']);
                break;
            case 'staff':
                $query = \App\Models\Staff::with(['activeRoles']);
                break;
            case 'summary':
                return $this->generateSummaryReport($dateFrom, $dateTo);
        }

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $data = $query->get();

        return [
            'type' => $type,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'data' => $data,
            'count' => $data->count()
        ];
    }

    /**
     * Generate summary report
     */
    private function generateSummaryReport($dateFrom = null, $dateTo = null)
    {
        $summary = [
            'applications' => [
                'total' => \App\Models\StudentTrans::count(),
                'pending' => \App\Models\StudentTrans::where('application_status', 'Started')->count(),
                'in_progress' => \App\Models\StudentTrans::where('application_status', 'In Progress')->count(),
                'completed' => \App\Models\StudentTrans::where('application_status', 'Completed')->count()
            ],
            'payments' => [
                'total' => \App\Models\PaymentTransaction::count(),
                'pending' => \App\Models\PaymentTransaction::where('transaction_status', 'Pending')->count(),
                'success' => \App\Models\PaymentTransaction::where('transaction_status', 'Success')->count(),
                'total_revenue' => \App\Models\PaymentTransaction::where('transaction_status', 'Success')->sum('amount')
            ],
            'staff' => [
                'total' => \App\Models\Staff::count(),
                'active' => \App\Models\Staff::where('status', 1)->count()
            ]
        ];

        if ($dateFrom || $dateTo) {
            // Apply date filters to summary
            $applicationsQuery = \App\Models\StudentTrans::query();
            $paymentsQuery = \App\Models\PaymentTransaction::query();

            if ($dateFrom) {
                $applicationsQuery->whereDate('created_at', '>=', $dateFrom);
                $paymentsQuery->whereDate('created_at', '>=', $dateFrom);
            }
            if ($dateTo) {
                $applicationsQuery->whereDate('created_at', '<=', $dateTo);
                $paymentsQuery->whereDate('created_at', '<=', $dateTo);
            }

            $summary['filtered_applications'] = $applicationsQuery->count();
            $summary['filtered_payments'] = $paymentsQuery->count();
            $summary['filtered_revenue'] = $paymentsQuery->where('transaction_status', 'Success')->sum('amount');
        }

        return [
            'type' => 'summary',
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'summary' => $summary
        ];
    }
}