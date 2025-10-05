<!-- Staff Sidebar -->
<div id="staff-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-900 to-blue-800 transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0">
    <div class="flex items-center justify-center h-20 shadow-md bg-blue-900">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <img class="h-10 w-10" src="<?php echo e(asset('images/logo/logo.png')); ?>" alt="Logo">
            </div>
            <div class="ml-3">
                <h1 class="text-xl font-bold text-white">Staff Portal</h1>
            </div>
        </div>
    </div>

    <nav class="mt-5 flex-1 px-2 bg-transparent space-y-1">
        <!-- Dashboard -->
        <a href="<?php echo e(route('transcript.staff.dashboard')); ?>"
           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md <?php echo e(request()->routeIs('transcript.staff.dashboard') ? 'bg-blue-700 text-white' : 'text-blue-100 hover:bg-blue-700 hover:text-white'); ?> transition-colors duration-150">
            <i class="fas fa-tachometer-alt mr-3 flex-shrink-0 h-5 w-5"></i>
            Dashboard
        </a>

        <!-- Applications Management -->
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_transcript_applications')): ?>
        <div class="mt-6">
            <h3 class="px-3 text-xs font-semibold text-blue-200 uppercase tracking-wider">Applications</h3>
            <div class="mt-1 space-y-1">
                <a href="<?php echo e(route('transcript.staff.applications')); ?>"
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-blue-100 hover:bg-blue-700 hover:text-white transition-colors duration-150">
                    <i class="fas fa-file-alt mr-3 flex-shrink-0 h-5 w-5"></i>
                    All Applications
                </a>
                <a href="#"
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-blue-100 hover:bg-blue-700 hover:text-white transition-colors duration-150">
                    <i class="fas fa-clock mr-3 flex-shrink-0 h-5 w-5"></i>
                    Pending Review
                </a>
                <a href="#"
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-blue-100 hover:bg-blue-700 hover:text-white transition-colors duration-150">
                    <i class="fas fa-check-circle mr-3 flex-shrink-0 h-5 w-5"></i>
                    Approved
                </a>
            </div>
        </div>
        <?php endif; ?>

        <!-- Payments Management -->
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_transcript_payments')): ?>
        <div class="mt-6">
            <h3 class="px-3 text-xs font-semibold text-blue-200 uppercase tracking-wider">Payments</h3>
            <div class="mt-1 space-y-1">
                <a href="<?php echo e(route('transcript.staff.payments')); ?>"
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-blue-100 hover:bg-blue-700 hover:text-white transition-colors duration-150">
                    <i class="fas fa-credit-card mr-3 flex-shrink-0 h-5 w-5"></i>
                    All Payments
                </a>
                <a href="#"
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-blue-100 hover:bg-blue-700 hover:text-white transition-colors duration-150">
                    <i class="fas fa-chart-line mr-3 flex-shrink-0 h-5 w-5"></i>
                    Payment Reports
                </a>
            </div>
        </div>
        <?php endif; ?>

        <!-- Student Management -->
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_transcript_students')): ?>
        <div class="mt-6">
            <h3 class="px-3 text-xs font-semibold text-blue-200 uppercase tracking-wider">Students</h3>
            <div class="mt-1 space-y-1">
                <a href="#"
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-blue-100 hover:bg-blue-700 hover:text-white transition-colors duration-150">
                    <i class="fas fa-graduation-cap mr-3 flex-shrink-0 h-5 w-5"></i>
                    All Students
                </a>
                <a href="#"
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-blue-100 hover:bg-blue-700 hover:text-white transition-colors duration-150">
                    <i class="fas fa-user-plus mr-3 flex-shrink-0 h-5 w-5"></i>
                    Add Student
                </a>
            </div>
        </div>
        <?php endif; ?>

        <!-- Staff Management -->
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_transcript_staff')): ?>
        <div class="mt-6">
            <h3 class="px-3 text-xs font-semibold text-blue-200 uppercase tracking-wider">Staff</h3>
            <div class="mt-1 space-y-1">
                <a href="<?php echo e(route('transcript.staff.manage')); ?>"
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-blue-100 hover:bg-blue-700 hover:text-white transition-colors duration-150">
                    <i class="fas fa-users mr-3 flex-shrink-0 h-5 w-5"></i>
                    All Staff
                </a>
                <a href="#"
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-blue-100 hover:bg-blue-700 hover:text-white transition-colors duration-150">
                    <i class="fas fa-user-tag mr-3 flex-shrink-0 h-5 w-5"></i>
                    Roles & Permissions
                </a>
            </div>
        </div>
        <?php endif; ?>

        <!-- System Settings -->
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_transcript_settings')): ?>
        <div class="mt-6">
            <h3 class="px-3 text-xs font-semibold text-blue-200 uppercase tracking-wider">System</h3>
            <div class="mt-1 space-y-1">
                <a href="#"
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-blue-100 hover:bg-blue-700 hover:text-white transition-colors duration-150">
                    <i class="fas fa-cog mr-3 flex-shrink-0 h-5 w-5"></i>
                    Settings
                </a>
                <a href="#"
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-blue-100 hover:bg-blue-700 hover:text-white transition-colors duration-150">
                    <i class="fas fa-dollar-sign mr-3 flex-shrink-0 h-5 w-5"></i>
                    Pricing
                </a>
                <a href="#"
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-blue-100 hover:bg-blue-700 hover:text-white transition-colors duration-150">
                    <i class="fas fa-shield-alt mr-3 flex-shrink-0 h-5 w-5"></i>
                    Audit Logs
                </a>
            </div>
        </div>
        <?php endif; ?>

        <!-- Reports -->
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('generate_transcript_reports')): ?>
        <div class="mt-6">
            <h3 class="px-3 text-xs font-semibold text-blue-200 uppercase tracking-wider">Reports</h3>
            <div class="mt-1 space-y-1">
                <a href="<?php echo e(route('transcript.staff.reports')); ?>"
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-blue-100 hover:bg-blue-700 hover:text-white transition-colors duration-150">
                    <i class="fas fa-file-alt mr-3 flex-shrink-0 h-5 w-5"></i>
                    Application Reports
                </a>
                <a href="#"
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-blue-100 hover:bg-blue-700 hover:text-white transition-colors duration-150">
                    <i class="fas fa-chart-bar mr-3 flex-shrink-0 h-5 w-5"></i>
                    Revenue Reports
                </a>
            </div>
        </div>
        <?php endif; ?>
    </nav>

    <!-- User Info at Bottom -->
    <div class="flex-shrink-0 flex bg-blue-900 p-4">
        <div class="flex-shrink-0 w-full group block">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="inline-block h-9 w-9 rounded-full bg-blue-600 flex items-center justify-center">
                        <span class="text-sm font-medium text-white">
                            <?php echo e(substr(auth('transcript_staff')->user()->first_name, 0, 1)); ?><?php echo e(substr(auth('transcript_staff')->user()->last_name, 0, 1)); ?>

                        </span>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">
                        <?php echo e(auth('transcript_staff')->user()->first_name); ?> <?php echo e(auth('transcript_staff')->user()->last_name); ?>

                    </p>
                    <p class="text-xs text-gray-500">
                        <?php echo e(auth('transcript_staff')->user()->roles->pluck('name')->join(', ')); ?>

                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile sidebar overlay -->
<div id="staff-sidebar-overlay" class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 lg:hidden hidden"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('staff-sidebar');
    const overlay = document.getElementById('staff-sidebar-overlay');
    const toggleButton = document.getElementById('staff-sidebar-toggle');

    function toggleSidebar() {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }

    if (toggleButton) {
        toggleButton.addEventListener('click', toggleSidebar);
    }

    if (overlay) {
        overlay.addEventListener('click', toggleSidebar);
    }

    // Close sidebar on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
            toggleSidebar();
        }
    });
});
</script>
<?php /**PATH C:\Users\Veritas ICT\Downloads\trans\transcript-system\resources\views/spartials/sidebar.blade.php ENDPATH**/ ?>