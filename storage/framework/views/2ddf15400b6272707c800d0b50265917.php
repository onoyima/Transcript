<?php $__env->startSection('title', 'Payment Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-credit-card text-blue-600 mr-3 text-2xl"></i>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Payment Details - <?php echo e($payment->order_id); ?>

                </h1>
            </div>
            <a href="<?php echo e(route('transcript.staff.payments')); ?>" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Back to Payments
            </a>
        </div>
    </div>

    <!-- Payment Details Card -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Payment Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Payment Information</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600 dark:text-gray-400">Order ID:</span>
                            <span class="text-gray-900 dark:text-white"><?php echo e($payment->order_id); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600 dark:text-gray-400">Transaction ID:</span>
                            <span class="text-gray-900 dark:text-white"><?php echo e($payment->transaction_id ?? 'N/A'); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600 dark:text-gray-400">Amount:</span>
                            <span class="text-gray-900 dark:text-white font-semibold">₦<?php echo e(number_format($payment->amount, 2)); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600 dark:text-gray-400">Status:</span>
                            <span>
                                <?php if($payment->status == 'pending'): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Pending</span>
                                <?php elseif($payment->status == 'approved'): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Approved</span>
                                <?php elseif($payment->status == 'failed'): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Failed</span>
                                <?php elseif($payment->status == 'refunded'): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">Refunded</span>
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600 dark:text-gray-400">Fee Type:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                <?php echo e($payment->feeType->name ?? 'N/A'); ?>

                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600 dark:text-gray-400">Description:</span>
                            <span class="text-gray-900 dark:text-white"><?php echo e($payment->description ?? 'N/A'); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600 dark:text-gray-400">Payment Date:</span>
                            <span class="text-gray-900 dark:text-white"><?php echo e($payment->created_at->format('M d, Y H:i:s')); ?></span>
                        </div>
                        <?php if($payment->updated_at != $payment->created_at): ?>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600 dark:text-gray-400">Last Updated:</span>
                            <span class="text-gray-900 dark:text-white"><?php echo e($payment->updated_at->format('M d, Y H:i:s')); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Student Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Student Information</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600 dark:text-gray-400">Student Name:</span>
                            <span class="text-gray-900 dark:text-white"><?php echo e($payment->payer_name); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600 dark:text-gray-400">Matric Number:</span>
                            <span class="text-gray-900 dark:text-white"><?php echo e($payment->student->matric_no ?? 'N/A'); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600 dark:text-gray-400">Email:</span>
                            <span class="text-gray-900 dark:text-white"><?php echo e($payment->payer_email); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600 dark:text-gray-400">Phone:</span>
                            <span class="text-gray-900 dark:text-white"><?php echo e($payment->payer_phone ?? 'N/A'); ?></span>
                        </div>
                        <?php if($payment->student): ?>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600 dark:text-gray-400">Faculty:</span>
                            <span class="text-gray-900 dark:text-white"><?php echo e($payment->student->faculty ?? 'N/A'); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600 dark:text-gray-400">Department:</span>
                            <span class="text-gray-900 dark:text-white"><?php echo e($payment->student->department ?? 'N/A'); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600 dark:text-gray-400">Graduation Year:</span>
                            <span class="text-gray-900 dark:text-white"><?php echo e($payment->student->graduation_year ?? 'N/A'); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8">
                <div class="flex flex-wrap gap-3">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_transcript_payments', $staff)): ?>
                    <?php if($payment->status == 'pending'): ?>
                    <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200" onclick="verifyPayment(<?php echo e($payment->id); ?>)">
                        <i class="fas fa-check mr-2"></i> Verify Payment
                    </button>
                    <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200" onclick="rejectPayment(<?php echo e($payment->id); ?>)">
                        <i class="fas fa-times mr-2"></i> Reject Payment
                    </button>
                    <?php endif; ?>
                    
                    <?php if($payment->status == 'approved'): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('process_transcript_refunds', $staff)): ?>
                    <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200" onclick="processRefund(<?php echo e($payment->id); ?>)">
                        <i class="fas fa-undo mr-2"></i> Process Refund
                    </button>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>

                    <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200" onclick="printPayment()">
                        <i class="fas fa-print mr-2"></i> Print Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>

            <!-- Payment History Card -->
            <?php if(isset($paymentHistory) && $paymentHistory->count() > 0): ?>
            <div class="bg-white rounded-lg shadow-md mt-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-history mr-2 text-blue-600"></i>
                        Payment History
                    </h3>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Date</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Action</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Staff</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Notes</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__currentLoopData = $paymentHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900"><?php echo e($history->created_at->format('M d, Y H:i:s')); ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-900"><?php echo e($history->action); ?></td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?php echo e($history->status == 'approved' ? 'bg-green-100 text-green-800' : ($history->status == 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')); ?>">
                                            <?php echo e(ucfirst($history->status)); ?>

                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900"><?php echo e($history->staff_name ?? 'System'); ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-900"><?php echo e($history->notes ?? '-'); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Verification Modal -->
<div id="verifyModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center pb-3">
            <h5 class="text-lg font-semibold text-gray-900">Verify Payment</h5>
            <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeModal('verifyModal')">
                <span class="text-2xl">&times;</span>
            </button>
        </div>
        <div class="py-4">
            <p class="text-gray-700 mb-4">Are you sure you want to verify this payment?</p>
            <div class="mb-4">
                <label for="verifyNotes" class="block text-sm font-medium text-gray-700 mb-2">Verification Notes (Optional)</label>
                <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="verifyNotes" rows="3" placeholder="Add any notes about the verification..."></textarea>
            </div>
        </div>
        <div class="flex justify-end space-x-3 pt-3 border-t">
            <button type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-200" onclick="closeModal('verifyModal')">Cancel</button>
            <button type="button" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-200" id="confirmVerify">Verify Payment</button>
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center pb-3">
            <h5 class="text-lg font-semibold text-gray-900">Reject Payment</h5>
            <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeModal('rejectModal')">
                <span class="text-2xl">&times;</span>
            </button>
        </div>
        <div class="py-4">
            <p class="text-gray-700 mb-4">Are you sure you want to reject this payment?</p>
            <div class="mb-4">
                <label for="rejectReason" class="block text-sm font-medium text-gray-700 mb-2">Rejection Reason <span class="text-red-600">*</span></label>
                <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="rejectReason" rows="3" placeholder="Please provide a reason for rejection..." required></textarea>
            </div>
        </div>
        <div class="flex justify-end space-x-3 pt-3 border-t">
            <button type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-200" onclick="closeModal('rejectModal')">Cancel</button>
            <button type="button" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-200" id="confirmReject">Reject Payment</button>
        </div>
    </div>
</div>

<!-- Refund Modal -->
<div id="refundModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center pb-3">
            <h5 class="text-lg font-semibold text-gray-900">Process Refund</h5>
            <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeModal('refundModal')">
                <span class="text-2xl">&times;</span>
            </button>
        </div>
        <div class="py-4">
            <form id="refundForm">
                <div class="mb-4">
                    <label for="refundReason" class="block text-sm font-medium text-gray-700 mb-2">Refund Reason <span class="text-red-600">*</span></label>
                    <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="refundReason" rows="3" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="refundAmount" class="block text-sm font-medium text-gray-700 mb-2">Refund Amount <span class="text-red-600">*</span></label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="refundAmount" step="0.01" max="<?php echo e($payment->amount); ?>" value="<?php echo e($payment->amount); ?>" required>
                    <small class="text-sm text-gray-500 mt-1">Maximum refund amount: ₦<?php echo e(number_format($payment->amount, 2)); ?></small>
                </div>
            </form>
        </div>
        <div class="flex justify-end space-x-3 pt-3 border-t">
            <button type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-200" onclick="closeModal('refundModal')">Cancel</button>
            <button type="button" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 transition duration-200" id="confirmRefund">Process Refund</button>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function showModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

function verifyPayment(paymentId) {
    showModal('verifyModal');
}

function rejectPayment(paymentId) {
    showModal('rejectModal');
}

function processRefund(paymentId) {
    showModal('refundModal');
}

function printPayment() {
    window.print();
}

document.getElementById('confirmVerify').addEventListener('click', function() {
    const notes = document.getElementById('verifyNotes').value;
    
    fetch(`<?php echo e(route('transcript.staff.payments.verify', $payment->id)); ?>`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({
            notes: notes
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error verifying payment: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while verifying the payment.');
    });
    
    closeModal('verifyModal');
});

document.getElementById('confirmReject').addEventListener('click', function() {
    const reason = document.getElementById('rejectReason').value;
    
    if (!reason.trim()) {
        alert('Please provide a reason for rejection.');
        return;
    }
    
    fetch(`<?php echo e(url('transcript/staff/payments')); ?>/<?php echo e($payment->id); ?>/reject`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({
            reason: reason
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error rejecting payment: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while rejecting the payment.');
    });
    
    closeModal('rejectModal');
});

document.getElementById('confirmRefund').addEventListener('click', function() {
    const reason = document.getElementById('refundReason').value;
    const amount = document.getElementById('refundAmount').value;
    
    if (!reason.trim() || !amount) {
        alert('Please fill in all required fields.');
        return;
    }
    
    if (parseFloat(amount) > <?php echo e($payment->amount); ?>) {
        alert('Refund amount cannot exceed the original payment amount.');
        return;
    }
    
    fetch(`<?php echo e(url('transcript/staff/payments')); ?>/<?php echo e($payment->id); ?>/refund`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({
            reason: reason,
            amount: amount
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error processing refund: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while processing the refund.');
    });
    
    closeModal('refundModal');
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.staff', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Veritas ICT\Downloads\trans\transcript-system\resources\views/transcript/staff/payments/show.blade.php ENDPATH**/ ?>