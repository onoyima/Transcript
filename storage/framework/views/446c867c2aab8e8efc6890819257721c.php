<?php $__env->startSection('title', 'Transcript Application Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Application Details</h1>
                    <p class="text-gray-600 mt-1">Reference: <?php echo e($application->ref_no ?? 'N/A'); ?></p>
                </div>
                <div class="flex space-x-3">
                    <a href="<?php echo e(route('student.transcript.progress', $application->id)); ?>" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-chart-line mr-2"></i>
                        Track Progress
                    </a>
                    <a href="<?php echo e(route('student.transcript.history')); ?>" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-900 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to History
                    </a>
                </div>
            </div>
        </div>

        <!-- Status Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <?php if($application->application_status === 'pending'): ?>
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-clock text-yellow-600"></i>
                            </div>
                        <?php elseif($application->application_status === 'processing'): ?>
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-cog fa-spin text-blue-600"></i>
                            </div>
                        <?php elseif($application->application_status === 'ready'): ?>
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-green-600"></i>
                            </div>
                        <?php elseif($application->application_status === 'delivered'): ?>
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check-double text-green-600"></i>
                            </div>
                        <?php else: ?>
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-times text-red-600"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Application Status</h3>
                        <p class="text-sm text-gray-600">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                <?php if($application->application_status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                <?php elseif($application->application_status === 'processing'): ?> bg-blue-100 text-blue-800
                                <?php elseif($application->application_status === 'ready'): ?> bg-green-100 text-green-800
                                <?php elseif($application->application_status === 'delivered'): ?> bg-green-100 text-green-800
                                <?php else: ?> bg-red-100 text-red-800
                                <?php endif; ?>">
                                <?php echo e(ucfirst($application->application_status)); ?>

                            </span>
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Payment Status</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        <?php if($application->payment_status === 'paid'): ?> bg-green-100 text-green-800
                        <?php elseif($application->payment_status === 'pending'): ?> bg-yellow-100 text-yellow-800
                        <?php else: ?> bg-red-100 text-red-800
                        <?php endif; ?>">
                        <?php echo e(ucfirst($application->payment_status)); ?>

                    </span>
                </div>
            </div>
        </div>

        <!-- Application Details -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Application Type</dt>
                        <dd class="text-sm text-gray-900"><?php echo e(ucfirst($application->application_type)); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Category</dt>
                        <dd class="text-sm text-gray-900"><?php echo e(ucfirst($application->category)); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Type</dt>
                        <dd class="text-sm text-gray-900"><?php echo e(ucfirst($application->type)); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Number of Copies</dt>
                        <dd class="text-sm text-gray-900"><?php echo e($application->number_of_copies); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Purpose</dt>
                        <dd class="text-sm text-gray-900"><?php echo e($application->purpose ?? 'N/A'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Total Amount</dt>
                        <dd class="text-sm text-gray-900 font-semibold">₦<?php echo e(number_format($application->total_amount, 2)); ?></dd>
                    </div>
                </dl>
            </div>

            <!-- Destination Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Destination Information</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Destination</dt>
                        <dd class="text-sm text-gray-900"><?php echo e(ucfirst($application->destination)); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Institution Name</dt>
                        <dd class="text-sm text-gray-900"><?php echo e($application->institution_name ?? 'N/A'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Institution Phone</dt>
                        <dd class="text-sm text-gray-900"><?php echo e($application->institutional_phone ?? 'N/A'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Institution Email</dt>
                        <dd class="text-sm text-gray-900"><?php echo e($application->institutional_email ?? 'N/A'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Courier</dt>
                        <dd class="text-sm text-gray-900"><?php echo e(ucfirst($application->courier)); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Delivery Address</dt>
                        <dd class="text-sm text-gray-900"><?php echo e($application->delivery_address ?? 'N/A'); ?></dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Email</dt>
                        <dd class="text-sm text-gray-900"><?php echo e($application->email); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Phone</dt>
                        <dd class="text-sm text-gray-900"><?php echo e($application->phone); ?></dd>
                    </div>
                </dl>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Application Date</dt>
                        <dd class="text-sm text-gray-900"><?php echo e($application->created_at->format('M d, Y')); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Last Updated</dt>
                        <dd class="text-sm text-gray-900"><?php echo e($application->updated_at->format('M d, Y')); ?></dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Actions -->
        <?php if($application->payment_status !== 'paid'): ?>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
            <div class="flex space-x-3">
                <a href="<?php echo e(route('student.transcript.payment.form', $application->id)); ?>" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <i class="fas fa-credit-card mr-2"></i>
                    Make Payment
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Veritas ICT\Downloads\trans\transcript-system\resources\views/student/transcript/show.blade.php ENDPATH**/ ?>