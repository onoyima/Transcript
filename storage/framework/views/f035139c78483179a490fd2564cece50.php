<?php $__env->startSection('title', 'Application Progress - Transcript Request'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Application Progress</h1>
                    <p class="text-gray-600 mt-1">Track your transcript application status</p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500">Application ID</div>
                    <div class="text-lg font-semibold text-gray-900">#<?php echo e($transcriptApplication->id); ?></div>
                </div>
            </div>
        </div>

        <!-- Progress Timeline -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Application Timeline</h2>
            
            <div class="relative">
                <!-- Progress Line -->
                <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                
                <!-- Progress Steps -->
                <div class="space-y-8">
                    <!-- Step 1: Application Submitted -->
                    <div class="relative flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-16 h-16 rounded-full <?php echo e($transcriptApplication->created_at ? 'bg-green-100 border-2 border-green-500' : 'bg-gray-100 border-2 border-gray-300'); ?>">
                                <?php if($transcriptApplication->created_at): ?>
                                <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <?php else: ?>
                                <div class="w-4 h-4 bg-gray-400 rounded-full"></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="ml-6 flex-1">
                            <h3 class="text-lg font-medium <?php echo e($transcriptApplication->created_at ? 'text-green-800' : 'text-gray-500'); ?>">
                                Application Submitted
                            </h3>
                            <p class="text-sm <?php echo e($transcriptApplication->created_at ? 'text-green-600' : 'text-gray-400'); ?>">
                                Your transcript application has been successfully submitted
                            </p>
                            <?php if($transcriptApplication->created_at): ?>
                            <p class="text-xs text-gray-500 mt-1">
                                <?php echo e($transcriptApplication->created_at->format('M d, Y \a\t H:i A')); ?>

                            </p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Step 2: Payment Completed -->
                    <?php
                        $paymentCompleted = $transcriptApplication->payment_status === 'Paid' || $transcriptApplication->payment_status === 'Completed';
                        $paymentTransaction = $transcriptApplication->paymentTransactions()->where('transaction_status', 'Success')->first();
                    ?>
                    <div class="relative flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-16 h-16 rounded-full <?php echo e($paymentCompleted ? 'bg-green-100 border-2 border-green-500' : ($transcriptApplication->payment_status === 'Pending' ? 'bg-yellow-100 border-2 border-yellow-500' : 'bg-gray-100 border-2 border-gray-300')); ?>">
                                <?php if($paymentCompleted): ?>
                                <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <?php elseif($transcriptApplication->payment_status === 'Pending'): ?>
                                <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                <?php else: ?>
                                <div class="w-4 h-4 bg-gray-400 rounded-full"></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="ml-6 flex-1">
                            <h3 class="text-lg font-medium <?php echo e($paymentCompleted ? 'text-green-800' : ($transcriptApplication->payment_status === 'Pending' ? 'text-yellow-800' : 'text-gray-500')); ?>">
                                Payment <?php echo e($paymentCompleted ? 'Completed' : ($transcriptApplication->payment_status === 'Pending' ? 'Pending' : 'Required')); ?>

                            </h3>
                            <p class="text-sm <?php echo e($paymentCompleted ? 'text-green-600' : ($transcriptApplication->payment_status === 'Pending' ? 'text-yellow-600' : 'text-gray-400')); ?>">
                                <?php if($paymentCompleted): ?>
                                    Payment has been successfully processed
                                <?php elseif($transcriptApplication->payment_status === 'Pending'): ?>
                                    Payment is pending completion
                                <?php else: ?>
                                    Payment is required to proceed with your application
                                <?php endif; ?>
                            </p>
                            <?php if($paymentTransaction && $paymentTransaction->payment_date): ?>
                            <p class="text-xs text-gray-500 mt-1">
                                <?php echo e($paymentTransaction->payment_date->format('M d, Y \a\t H:i A')); ?>

                            </p>
                            <?php endif; ?>
                            <?php if(!$paymentCompleted && $transcriptApplication->payment_status !== 'Pending'): ?>
                            <div class="mt-2">
                                <a href="<?php echo e(route('student.transcript.paystack.payment.form', $transcriptApplication->id)); ?>" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Complete Payment
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Step 3: Application Processing -->
                    <?php
                        $isProcessing = $transcriptApplication->application_status === 'In Progress';
                        $isCompleted = $transcriptApplication->application_status === 'Completed';
                    ?>
                    <div class="relative flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-16 h-16 rounded-full <?php echo e($isCompleted ? 'bg-green-100 border-2 border-green-500' : ($isProcessing ? 'bg-blue-100 border-2 border-blue-500' : 'bg-gray-100 border-2 border-gray-300')); ?>">
                                <?php if($isCompleted): ?>
                                <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <?php elseif($isProcessing): ?>
                                <svg class="w-8 h-8 text-blue-600 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <?php else: ?>
                                <div class="w-4 h-4 bg-gray-400 rounded-full"></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="ml-6 flex-1">
                            <h3 class="text-lg font-medium <?php echo e($isCompleted ? 'text-green-800' : ($isProcessing ? 'text-blue-800' : 'text-gray-500')); ?>">
                                Application <?php echo e($isCompleted ? 'Processed' : ($isProcessing ? 'Processing' : 'Awaiting Processing')); ?>

                            </h3>
                            <p class="text-sm <?php echo e($isCompleted ? 'text-green-600' : ($isProcessing ? 'text-blue-600' : 'text-gray-400')); ?>">
                                <?php if($isCompleted): ?>
                                    Your transcript has been processed and is ready
                                <?php elseif($isProcessing): ?>
                                    Your application is currently being processed by our team
                                <?php else: ?>
                                    Application will be processed after payment confirmation
                                <?php endif; ?>
                            </p>
                            <?php if($isProcessing): ?>
                            <div class="mt-2">
                                <div class="text-xs text-blue-600">
                                    <span class="inline-flex items-center">
                                        <svg class="animate-spin -ml-1 mr-2 h-3 w-3 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Processing typically takes 3-5 business days
                                    </span>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Step 4: Ready for Collection/Delivery -->
                    <div class="relative flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-16 h-16 rounded-full <?php echo e($isCompleted ? 'bg-green-100 border-2 border-green-500' : 'bg-gray-100 border-2 border-gray-300'); ?>">
                                <?php if($isCompleted): ?>
                                <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <?php else: ?>
                                <div class="w-4 h-4 bg-gray-400 rounded-full"></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="ml-6 flex-1">
                            <h3 class="text-lg font-medium <?php echo e($isCompleted ? 'text-green-800' : 'text-gray-500'); ?>">
                                Ready for <?php echo e($transcriptApplication->type === 'physical' ? 'Collection' : 'Download'); ?>

                            </h3>
                            <p class="text-sm <?php echo e($isCompleted ? 'text-green-600' : 'text-gray-400'); ?>">
                                <?php if($isCompleted): ?>
                                    Your transcript is ready for <?php echo e($transcriptApplication->type === 'physical' ? 'collection' : 'download'); ?>

                                <?php else: ?>
                                    You will be notified when your transcript is ready
                                <?php endif; ?>
                            </p>
                            <?php if($isCompleted): ?>
                            <div class="mt-2">
                                <?php if($transcriptApplication->type === 'physical'): ?>
                                <div class="text-sm text-green-700">
                                    <strong>Collection Address:</strong><br>
                                    <?php echo e($transcriptApplication->delivery_address ?? 'University Registrar Office'); ?>

                                </div>
                                <?php else: ?>
                                <a href="#" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Download Transcript
                                </a>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Application Details -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Application Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Application Details</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Application Type</span>
                        <span class="text-sm font-medium text-gray-900 capitalize"><?php echo e($transcriptApplication->application_type); ?></span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Category</span>
                        <span class="text-sm font-medium text-gray-900 capitalize"><?php echo e($transcriptApplication->category); ?></span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Delivery Type</span>
                        <span class="text-sm font-medium text-gray-900 capitalize"><?php echo e(str_replace('_', ' ', $transcriptApplication->type)); ?></span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Destination</span>
                        <span class="text-sm font-medium text-gray-900 capitalize"><?php echo e(str_replace('_', ' ', $transcriptApplication->destination)); ?></span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Number of Copies</span>
                        <span class="text-sm font-medium text-gray-900"><?php echo e($transcriptApplication->number_of_copies); ?></span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Total Amount</span>
                        <span class="text-sm font-medium text-green-600">₦<?php echo e(number_format($transcriptApplication->total_amount, 2)); ?></span>
                    </div>
                    
                    <div class="flex justify-between py-2">
                        <span class="text-sm text-gray-600">Submitted On</span>
                        <span class="text-sm font-medium text-gray-900"><?php echo e($transcriptApplication->created_at->format('M d, Y \a\t H:i A')); ?></span>
                    </div>
                </div>
            </div>

            <!-- Status Summary -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Current Status</h2>
                
                <div class="space-y-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Application Status</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                <?php echo e($transcriptApplication->application_status === 'Completed' ? 'bg-green-100 text-green-800' : 
                                   ($transcriptApplication->application_status === 'In Progress' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800')); ?>">
                                <?php echo e($transcriptApplication->application_status); ?>

                            </span>
                        </div>
                        <div class="text-sm text-gray-600">
                            <?php if($transcriptApplication->application_status === 'Started'): ?>
                                Your application has been submitted and is awaiting payment.
                            <?php elseif($transcriptApplication->application_status === 'In Progress'): ?>
                                Your application is currently being processed by our team.
                            <?php elseif($transcriptApplication->application_status === 'Completed'): ?>
                                Your transcript has been processed and is ready for <?php echo e($transcriptApplication->type === 'physical' ? 'collection' : 'download'); ?>.
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Payment Status</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                <?php echo e($transcriptApplication->payment_status === 'Paid' || $transcriptApplication->payment_status === 'Completed' ? 'bg-green-100 text-green-800' : 
                                   ($transcriptApplication->payment_status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')); ?>">
                                <?php echo e($transcriptApplication->payment_status); ?>

                            </span>
                        </div>
                        <div class="text-sm text-gray-600">
                            <?php if($transcriptApplication->payment_status === 'Paid' || $transcriptApplication->payment_status === 'Completed'): ?>
                                Payment has been successfully processed.
                            <?php elseif($transcriptApplication->payment_status === 'Pending'): ?>
                                Payment is pending completion.
                            <?php else: ?>
                                Payment is required to proceed with processing.
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if($transcriptApplication->purpose): ?>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="text-sm font-medium text-gray-700 mb-2">Purpose</div>
                        <div class="text-sm text-gray-600"><?php echo e($transcriptApplication->purpose); ?></div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 space-y-3">
                    <?php if(!$paymentCompleted): ?>
                    <a href="<?php echo e(route('student.transcript.paystack.payment.form', $transcriptApplication->id)); ?>" 
                       class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Complete Payment
                    </a>
                    <?php endif; ?>
                    
                    <a href="<?php echo e(route('student.transcript.history')); ?>" 
                       class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        View All Applications
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-refresh page every 30 seconds if application is in progress
<?php if($transcriptApplication->application_status === 'In Progress'): ?>
setTimeout(function() {
    location.reload();
}, 30000);
<?php endif; ?>
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Veritas ICT\Downloads\trans\transcript-system\resources\views/student/transcript/progress.blade.php ENDPATH**/ ?>