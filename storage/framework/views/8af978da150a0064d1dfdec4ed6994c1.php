<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-green-400 to-green-600 dark:from-green-600 dark:to-green-800 bg-gray-50 dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6 relative overflow-hidden">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    Welcome back, <?php echo e(auth('transcript_staff')->user()->fname); ?>! 👋
                </h1>
                <p class="text-gray-900 dark:text-gray-100 mb-4">
                    Here's an overview of your staff portal and system management activities.
                </p>
                <div class="flex flex-wrap gap-4 text-sm text-gray-600 dark:text-primary-400">
                    <div class="flex items-center">
                        <i class="fas fa-envelope mr-2 text-primary-600"></i>
                        <span class="font-medium"><?php echo e(auth('transcript_staff')->user()->email); ?></span>
                    </div>
                    <?php if(auth('transcript_staff')->user()->phone): ?>
                    <div class="flex items-center">
                        <i class="fas fa-phone mr-2 text-primary-600"></i>
                        <span><?php echo e(auth('transcript_staff')->user()->phone); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="flex items-center">
                        <i class="fas fa-user mr-2 text-primary-600"></i>
                        <span><?php echo e(auth('transcript_staff')->user()->username); ?></span>
                    </div>
                    <?php if(auth('transcript_staff')->user()->department): ?>
                    <div class="flex items-center">
                        <i class="fas fa-building mr-2 text-primary-600"></i>
                        <span><?php echo e(auth('transcript_staff')->user()->department); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="hidden md:block ml-6">
                <div class="w-20 h-20 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-tie text-3xl text-primary-600 dark:text-primary-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_transcript_applications', $staff)): ?>
        <!-- Total Applications -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Total Applications</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($stats['total_applications'] ?? 0); ?></p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-alt text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
        </div>

        <!-- Pending Applications -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Pending Applications</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($stats['pending_applications'] ?? 0); ?></p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 dark:text-yellow-400"></i>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_transcript_payments', $staff)): ?>
        <!-- Completed Payments -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Completed</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($stats['completed_applications'] ?? 0); ?></p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Total Payments</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">₦<?php echo e(number_format($stats['total_payments'] ?? 0, 2)); ?></p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-naira-sign text-purple-600 dark:text-purple-400"></i>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_transcript_applications', auth('transcript_staff')->user())): ?>
            <a href="<?php echo e(route('transcript.staff.applications.index')); ?>"
               class="flex items-center p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-200/50 dark:border-gray-700/50 hover:shadow-md transition-all duration-200 group">
                <div class="w-10 h-10 bg-primary-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                <i class="fas fa-file-alt text-gray-600 dark:text-white"></i>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900 dark:text-white">View Applications</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-100">Review and process transcript applications</p>
                </div>
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_transcript_payments', auth('transcript_staff')->user())): ?>
            <a href="<?php echo e(route('transcript.staff.payments.index')); ?>"
               class="flex items-center p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-200/50 dark:border-gray-700/50 hover:shadow-md transition-all duration-200 group">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                <i class="fas fa-credit-card text-gray-600 dark:text-white"></i>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900 dark:text-white">Manage Payments</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-100">Process payment records</p>
                </div>
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('generate_transcript_reports', auth('transcript_staff')->user())): ?>
            <a href="<?php echo e(route('transcript.staff.reports.index')); ?>"
               class="flex items-center p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-200/50 dark:border-gray-700/50 hover:shadow-md transition-all duration-200 group">
                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                <i class="fas fa-chart-bar text-gray-600 dark:text-white"></i>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900 dark:text-white">Generate Reports</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-100">View system analytics</p>
                </div>
            </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Applications -->
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_transcript_applications', auth('transcript_staff')->user())): ?>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200/50 dark:border-gray-700/50">
        <div class="p-6 border-b border-gray-200/50 dark:border-gray-700/50">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Applications</h2>
                <a href="<?php echo e(route('transcript.staff.applications.index')); ?>"
                   class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 text-sm font-medium">
                    View All
                </a>
            </div>
        </div>

        <div class="p-6">
            <?php if(isset($recent_applications) && $recent_applications->count() > 0): ?>
                <div class="space-y-4">
                    <?php $__currentLoopData = $recent_applications->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $application): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center
                                    <?php if($application->status == 'approved'): ?> bg-green-100 dark:bg-green-900/20
                                    <?php elseif($application->status == 'processing'): ?> bg-blue-100 dark:bg-blue-900/20
                                    <?php elseif($application->status == 'pending'): ?> bg-yellow-100 dark:bg-yellow-900/20
                                    <?php else: ?> bg-gray-100 dark:bg-gray-900/20
                                    <?php endif; ?>">
                                    <i class="fas fa-file-alt
                                        <?php if($application->status == 'approved'): ?> text-green-600 dark:text-green-400
                                        <?php elseif($application->status == 'processing'): ?> text-blue-600 dark:text-blue-400
                                        <?php elseif($application->status == 'pending'): ?> text-yellow-600 dark:text-yellow-400
                                        <?php else: ?> text-gray-800 dark:text-gray-300
                                        <?php endif; ?>"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900 dark:text-white"><?php echo e($application->student->full_name ?? 'N/A'); ?></h3>
                                    <p class="text-sm text-gray-900 dark:text-gray-100">Applied on <?php echo e($application->created_at->format('M d, Y')); ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    <?php if($application->status == 'approved'): ?> bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400
                                    <?php elseif($application->status == 'processing'): ?> bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400
                                    <?php elseif($application->status == 'pending'): ?> bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400
                                    <?php else: ?> bg-gray-100 text-gray-900 dark:bg-gray-900/20 dark:text-gray-100
                                    <?php endif; ?>">
                                    <?php echo e(ucfirst($application->status)); ?>

                                </span>
                                <p class="text-sm text-gray-900 dark:text-gray-100 mt-1">ID: #<?php echo e($application->id); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-file-alt text-gray-800 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Recent Applications</h3>
                    <p class="text-gray-900 dark:text-gray-100 mb-6">There are no recent applications to display at this time.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.staff', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Veritas ICT\Downloads\trans\transcript-system\resources\views/transcript/staff/dashboard.blade.php ENDPATH**/ ?>