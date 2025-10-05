<?php $__env->startSection('title', 'Payment - Transcript Application'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Payment for Transcript Application</h1>
                    <p class="text-gray-600 mt-1">Complete your payment to process your transcript request</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Application ID</p>
                    <p class="text-lg font-semibold text-blue-600">#<?php echo e($transcriptApplication->id); ?></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Payment Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Payment Information</h2>
                    
                    <!-- Payment Method Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Payment Method</label>
                        <div class="space-y-3">
                            <div class="flex items-center p-4 border border-green-200 rounded-lg bg-green-50">
                                <input type="radio" id="paystack" name="payment_method" value="paystack" checked 
                                       class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                <label for="paystack" class="ml-3 flex items-center">
                                    <span class="text-sm font-medium text-gray-900">Paystack</span>
                                    <span class="ml-2 text-xs text-green-600 bg-green-100 px-2 py-1 rounded">Recommended</span>
                                </label>
                                <div class="ml-auto flex space-x-2">
                                    <img src="https://paystack.com/assets/img/payments/mastercard.png" alt="Mastercard" class="h-6">
                                    <img src="https://paystack.com/assets/img/payments/visa.png" alt="Visa" class="h-6">
                                    <img src="https://paystack.com/assets/img/payments/verve.png" alt="Verve" class="h-6">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email Input -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" id="email" name="email" 
                               value="<?php echo e($transcriptApplication->email); ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                               required>
                        <p class="text-xs text-gray-500 mt-1">Payment receipt will be sent to this email</p>
                    </div>

                    <!-- Payment Button -->
                    <button type="button" id="paystack-payment-btn" 
                            class="w-full bg-green-600 text-white py-3 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200 font-medium">
                        <span id="payment-btn-text">Pay ₦<?php echo e(number_format($transcriptApplication->total_amount, 2)); ?></span>
                        <span id="payment-btn-loading" class="hidden">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>

                    <!-- Security Notice -->
                    <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-md">
                        <div class="flex">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Your payment is secured by Paystack. We do not store your card details.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Order Summary</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Application Type</span>
                            <span class="text-sm font-medium text-gray-900 capitalize"><?php echo e($transcriptApplication->application_type); ?></span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Category</span>
                            <span class="text-sm font-medium text-gray-900 capitalize"><?php echo e($transcriptApplication->category); ?></span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Delivery Type</span>
                            <span class="text-sm font-medium text-gray-900 capitalize"><?php echo e($transcriptApplication->type); ?></span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Destination</span>
                            <span class="text-sm font-medium text-gray-900 capitalize"><?php echo e($transcriptApplication->destination); ?></span>
                        </div>
                        
                        <?php if($transcriptApplication->courier): ?>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Courier</span>
                            <span class="text-sm font-medium text-gray-900 uppercase"><?php echo e($transcriptApplication->courier); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <hr class="my-3">
                        
                        <div class="flex justify-between">
                            <span class="text-base font-semibold text-gray-900">Total Amount</span>
                            <span class="text-base font-bold text-green-600">₦<?php echo e(number_format($transcriptApplication->total_amount, 2)); ?></span>
                        </div>
                    </div>
                    
                    <!-- Student Information -->
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <h4 class="text-sm font-semibold text-gray-800 mb-2">Student Information</h4>
                        <div class="space-y-1">
                            <p class="text-xs text-gray-600"><?php echo e($student->first_name); ?> <?php echo e($student->middle_name); ?> <?php echo e($student->surname); ?></p>
                            <p class="text-xs text-gray-600"><?php echo e($student->matric_number); ?></p>
                            <p class="text-xs text-gray-600"><?php echo e($transcriptApplication->email); ?></p>
                        </div>
                    </div>
                </div>
                
                <!-- Help Section -->
                <div class="bg-gray-50 rounded-lg p-4 mt-4">
                    <h4 class="text-sm font-semibold text-gray-800 mb-2">Need Help?</h4>
                    <p class="text-xs text-gray-600 mb-2">If you encounter any issues with payment, please contact support.</p>
                    <a href="mailto:<?php echo e(config('mail.from.address')); ?>" class="text-xs text-blue-600 hover:text-blue-800">
                        <?php echo e(config('mail.from.address')); ?>

                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Paystack Inline Script -->
<script src="https://js.paystack.co/v1/inline.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const payButton = document.getElementById('paystack-payment-btn');
    const payButtonText = document.getElementById('payment-btn-text');
    const payButtonLoading = document.getElementById('payment-btn-loading');
    const emailInput = document.getElementById('email');
    
    payButton.addEventListener('click', function() {
        const email = emailInput.value.trim();
        
        if (!email) {
            alert('Please enter your email address');
            emailInput.focus();
            return;
        }
        
        if (!isValidEmail(email)) {
            alert('Please enter a valid email address');
            emailInput.focus();
            return;
        }
        
        // Show loading state
        payButtonText.classList.add('hidden');
        payButtonLoading.classList.remove('hidden');
        payButton.disabled = true;
        
        // Initialize payment with backend
        fetch('<?php echo e(route("student.transcript.paystack.payment.initialize", $transcriptApplication->id)); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({
                email: email
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                // Open Paystack popup
                const handler = PaystackPop.setup({
                    key: '<?php echo e($paystackPublicKey); ?>',
                    email: email,
                    amount: <?php echo e($transcriptApplication->total_amount * 100); ?>, // Amount in kobo
                    currency: 'NGN',
                    ref: data.data.reference,
                    callback: function(response) {
                        // Payment successful
                        window.location.href = '<?php echo e(route("student.transcript.paystack.callback")); ?>?reference=' + response.reference;
                    },
                    onClose: function() {
                        // Reset button state
                        payButtonText.classList.remove('hidden');
                        payButtonLoading.classList.add('hidden');
                        payButton.disabled = false;
                    }
                });
                
                handler.openIframe();
            } else {
                alert('Payment initialization failed: ' + data.message);
                // Reset button state
                payButtonText.classList.remove('hidden');
                payButtonLoading.classList.add('hidden');
                payButton.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
            // Reset button state
            payButtonText.classList.remove('hidden');
            payButtonLoading.classList.add('hidden');
            payButton.disabled = false;
        });
    });
    
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Veritas ICT\Downloads\trans\transcript-system\resources\views/student/transcript/paystack_payment.blade.php ENDPATH**/ ?>