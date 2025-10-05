<?php $__env->startSection('title', 'Payment Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Payment Details</h1>
                    <p class="text-gray-600 mt-1">Transaction ID: <?php echo e($payment->transaction_id ?? $payment->id); ?></p>
                </div>
                <div class="flex space-x-3">
                    <?php if($payment->transaction_status === 'Success'): ?>
                    <button class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-download mr-2"></i>
                        Download Receipt
                    </button>
                    <?php endif; ?>
                    <a href="<?php echo e(route('student.payments')); ?>" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-900 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Payments
                    </a>
                </div>
            </div>
        </div>

        <!-- Payment Status Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <?php if($payment->transaction_status === 'Success'): ?>
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-green-600"></i>
                            </div>
                        <?php elseif($payment->transaction_status === 'Pending'): ?>
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-clock text-yellow-600"></i>
                            </div>
                        <?php elseif($payment->transaction_status === 'Failed'): ?>
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-times text-red-600"></i>
                            </div>
                        <?php else: ?>
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-info text-blue-600"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Payment Status</h3>
                        <p class="text-sm text-gray-600">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                <?php if($payment->transaction_status === 'Success'): ?> bg-green-100 text-green-800
                                <?php elseif($payment->transaction_status === 'Pending'): ?> bg-yellow-100 text-yellow-800
                                <?php elseif($payment->transaction_status === 'Failed'): ?> bg-red-100 text-red-800
                                <?php else: ?> bg-blue-100 text-blue-800
                                <?php endif; ?>">
                                <?php echo e($payment->transaction_status); ?>

                            </span>
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-gray-900">₦<?php echo e(number_format($payment->amount, 2)); ?></p>
                    <p class="text-sm text-gray-600"><?php echo e(ucfirst($payment->payment_method)); ?></p>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Transaction Details -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Transaction Details</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Transaction ID</dt>
                        <dd class="text-sm text-gray-900 font-mono"><?php echo e($payment->transaction_id ?? $payment->id); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Order ID</dt>
                        <dd class="text-sm text-gray-900 font-mono"><?php echo e($payment->order_id ?? 'N/A'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Reference Number</dt>
                        <dd class="text-sm text-gray-900 font-mono"><?php echo e($payment->reference ?? 'N/A'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Payment Method</dt>
                        <dd class="text-sm text-gray-900"><?php echo e(ucfirst($payment->payment_method)); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Amount</dt>
                        <dd class="text-sm text-gray-900 font-semibold">₦<?php echo e(number_format($payment->amount, 2)); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Status</dt>
                        <dd class="text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                <?php if($payment->transaction_status === 'Success'): ?> bg-green-100 text-green-800
                                <?php elseif($payment->transaction_status === 'Pending'): ?> bg-yellow-100 text-yellow-800
                                <?php elseif($payment->transaction_status === 'Failed'): ?> bg-red-100 text-red-800
                                <?php else: ?> bg-blue-100 text-blue-800
                                <?php endif; ?>">
                                <?php echo e($payment->transaction_status); ?>

                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Application Details -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Application Details</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Application Type</dt>
                        <dd class="text-sm text-gray-900"><?php echo e($payment->studentTrans->application_type ?? 'N/A'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Reference Number</dt>
                        <dd class="text-sm text-gray-900 font-mono"><?php echo e($payment->studentTrans->ref_no ?? 'N/A'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Application Status</dt>
                        <dd class="text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                <?php if($payment->studentTrans->application_status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                <?php elseif($payment->studentTrans->application_status === 'processing'): ?> bg-blue-100 text-blue-800
                                <?php elseif($payment->studentTrans->application_status === 'ready'): ?> bg-green-100 text-green-800
                                <?php elseif($payment->studentTrans->application_status === 'delivered'): ?> bg-green-100 text-green-800
                                <?php else: ?> bg-gray-100 text-gray-800
                                <?php endif; ?>">
                                <?php echo e(ucfirst($payment->studentTrans->application_status ?? 'N/A')); ?>

                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Category</dt>
                        <dd class="text-sm text-gray-900"><?php echo e(ucfirst($payment->studentTrans->category ?? 'N/A')); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Type</dt>
                        <dd class="text-sm text-gray-900"><?php echo e(ucfirst($payment->studentTrans->type ?? 'N/A')); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Destination</dt>
                        <dd class="text-sm text-gray-900"><?php echo e(ucfirst($payment->studentTrans->destination ?? 'N/A')); ?></dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Timeline -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Timeline</h3>
            <div class="flow-root">
                <ul class="-mb-8">
                    <li>
                        <div class="relative pb-8">
                            <div class="relative flex space-x-3">
                                <div>
                                    <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                        <i class="fas fa-plus text-white text-xs"></i>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-gray-900">Payment initiated</p>
                                    </div>
                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                        <?php echo e($payment->created_at->format('M d, Y g:i A')); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php if($payment->updated_at != $payment->created_at): ?>
                    <li>
                        <div class="relative pb-8">
                            <div class="relative flex space-x-3">
                                <div>
                                    <span class="h-8 w-8 rounded-full 
                                        <?php if($payment->transaction_status === 'Success'): ?> bg-green-500
                                        <?php elseif($payment->transaction_status === 'Failed'): ?> bg-red-500
                                        <?php else: ?> bg-yellow-500
                                        <?php endif; ?> 
                                        flex items-center justify-center ring-8 ring-white">
                                        <?php if($payment->transaction_status === 'Success'): ?>
                                            <i class="fas fa-check text-white text-xs"></i>
                                        <?php elseif($payment->transaction_status === 'Failed'): ?>
                                            <i class="fas fa-times text-white text-xs"></i>
                                        <?php else: ?>
                                            <i class="fas fa-clock text-white text-xs"></i>
                                        <?php endif; ?>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-gray-900">Payment <?php echo e(strtolower($payment->transaction_status)); ?></p>
                                    </div>
                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                        <?php echo e($payment->updated_at->format('M d, Y g:i A')); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
            <div class="flex space-x-3">
                <?php if($payment->transaction_status === 'Success'): ?>
                    <button class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-download mr-2"></i>
                        Download Receipt
                    </button>
                <?php endif; ?>
                <?php if($payment->studentTrans): ?>
                    <a href="<?php echo e(route('student.transcript.show', $payment->studentTrans->id)); ?>" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-900 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-file-alt mr-2"></i>
                        View Application
                    </a>
                <?php endif; ?>
                <?php if($payment->transaction_status === 'Failed'): ?>
                    <a href="<?php echo e(route('student.transcript.paystack.payment.form', $payment->studentTrans->id)); ?>" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-redo mr-2"></i>
                        Retry Payment
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Veritas ICT\Downloads\trans\transcript-system\resources\views/student/payment_details.blade.php ENDPATH**/ ?>