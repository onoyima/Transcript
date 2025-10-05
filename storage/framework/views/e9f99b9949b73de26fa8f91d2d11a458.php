<?php $__env->startSection('title', 'New Transcript Application'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-white dark:bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200/50 dark:border-gray-700/50 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-black dark:text-white">New Transcript Application</h1>
    <p class="text-gray-900 dark:text-gray-100 mt-1">Submit a new transcript request</p>
                </div>
                <a href="<?php echo e(route('student.dashboard')); ?>" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-black dark:text-gray-100 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Pricing Summary -->
        <div id="pricingSummary" class="bg-gradient-to-r from-green-50 to-blue-50 dark:from-green-900/20 dark:to-blue-900/20 rounded-xl shadow-sm border border-green-200/50 dark:border-green-700/50 p-6 mb-6" style="display: none;">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                    <i class="fas fa-calculator mr-2 text-green-600"></i>
                    Pricing Summary
                </h2>
                <span class="text-sm text-gray-600 dark:text-gray-400">Live pricing updates</span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Transcript Price -->
                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Transcript</div>
                    <div class="text-xl font-bold text-gray-900 dark:text-white" id="summaryTranscriptPrice">₦0</div>
                </div>
                
                <!-- Courier Price -->
                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Courier</div>
                    <div class="text-xl font-bold text-gray-900 dark:text-white" id="summaryCourierPrice">₦0</div>
                </div>
                
                <!-- Payment Charges -->
                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Payment Charges</div>
                    <div class="text-xl font-bold text-orange-600 dark:text-orange-400" id="summaryPaymentCharges">₦0</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400" id="summaryPaymentMethod"></div>
                </div>
                
                <!-- Total -->
                <div class="bg-green-50 dark:bg-green-900/30 rounded-lg p-4 border border-green-200 dark:border-green-700">
                    <div class="text-sm text-green-700 dark:text-green-400 mb-1">Total Amount</div>
                    <div class="text-2xl font-bold text-green-800 dark:text-green-300" id="summaryTotal">₦0</div>
                </div>
            </div>
            
            <!-- Breakdown Details -->
            <div id="summaryBreakdown" class="mt-4 p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700" style="display: none;">
                <div class="text-sm font-medium text-gray-900 dark:text-white mb-2">Detailed Breakdown:</div>
                <div id="summaryBreakdownContent" class="text-sm text-gray-600 dark:text-gray-400 space-y-1"></div>
            </div>
        </div>

        <!-- Error and Success Messages -->
        <?php if(session('error')): ?>
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-xl p-4 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                    <div class="text-red-700 dark:text-red-400"><?php echo e(session('error')); ?></div>
                </div>
            </div>
        <?php endif; ?>

        <?php if(session('success')): ?>
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-xl p-4 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <div class="text-green-700 dark:text-green-400"><?php echo e(session('success')); ?></div>
                </div>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-xl p-4 mb-6">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-3 mt-1"></i>
                    <div>
                        <div class="text-red-700 dark:text-red-400 font-medium mb-2">Please correct the following errors:</div>
                        <ul class="text-red-600 dark:text-red-400 text-sm space-y-1">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>• <?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Application Form -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200/50 dark:border-gray-700/50">
            <div class="p-6">
                <form id="transcriptForm" action="<?php echo e(route('student.transcript.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    
                    <!-- Step 1: Category (Undergraduate/Postgraduate) -->
                    <div class="mb-6">
                        <label for="application_type" class="block text-sm font-medium text-black dark:text-gray-100 mb-3">
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-green-500 text-white text-sm font-bold rounded-full mr-2">1</span>
                            Select Category
                        </label>
                        <select id="categorySelect" name="application_type" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white dark:bg-gray-700 text-black dark:text-gray-100" required>
                            <option value="">Select one</option>
                            <option value="undergraduate">Undergraduate</option>
                            <option value="postgraduate">Postgraduate</option>
                        </select>
                    </div>

                    <!-- Step 2: Request Type (Self/Institutional) -->
                    <div class="mb-6" id="requestTypeSection" style="display: none;">
                        <label for="request_type" class="block text-sm font-medium text-black dark:text-gray-100 mb-3">
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-green-500 text-white text-sm font-bold rounded-full mr-2">2</span>
                            Select Request Type
                        </label>
                        <select id="requestTypeSelect" name="request_type" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white dark:bg-gray-700 text-black dark:text-gray-100" required>
                            <option value="">Select one</option>
                            <option value="self">Self</option>
                            <option value="institutional">Institutional</option>
                        </select>
                    </div>

                    <!-- Step 3: Delivery Options -->
                    <div class="mb-6" id="deliveryOptionsSection" style="display: none;">
                        <label class="block text-sm font-medium text-black dark:text-gray-100 mb-3">
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-green-500 text-white text-sm font-bold rounded-full mr-2">3</span>
                            Select Delivery Options
                        </label>
                        <!-- Self Request Options -->
                        <div id="selfDeliveryOptions" style="display: none;">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="relative">
                                    <input type="radio" id="physical_self" name="delivery_option" value="self_physical" class="sr-only peer">
                                    <label for="physical_self" class="flex items-center p-4 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 peer-checked:border-green-500 peer-checked:bg-green-50 dark:peer-checked:bg-green-900/20">
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 border-2 border-gray-300 dark:border-gray-500 rounded-full mr-3 peer-checked:border-green-500 peer-checked:bg-green-500 flex items-center justify-center">
                                                <div class="w-2 h-2 bg-white rounded-full hidden peer-checked:block"></div>
                                            </div>
                                            <div>
                                                <div class="font-medium text-black dark:text-white">Physical Self (Self-Collection)</div>
                                                <div class="text-sm text-gray-900 dark:text-gray-100">Pick up from university</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="relative">
                                    <input type="radio" id="ecopy_self" name="delivery_option" value="self_ecopy" class="sr-only peer">
                                    <label for="ecopy_self" class="flex items-center p-4 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 peer-checked:border-green-500 peer-checked:bg-green-50 dark:peer-checked:bg-green-900/20">
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 border-2 border-gray-300 dark:border-gray-500 rounded-full mr-3 peer-checked:border-green-500 peer-checked:bg-green-500 flex items-center justify-center">
                                                <div class="w-2 h-2 bg-white rounded-full hidden peer-checked:block"></div>
                                            </div>
                                            <div>
                                                <div class="font-medium text-black dark:text-white">E-Copy Self (Email)</div>
                                                <div class="text-sm text-gray-900 dark:text-gray-100">Electronic delivery via email</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Institutional Request Options -->
                        <div id="institutionalDeliveryOptions" style="display: none;">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="relative">
                                    <input type="radio" id="physical_institutional" name="delivery_option" value="institutional_physical" class="sr-only peer">
                                    <label for="physical_institutional" class="flex items-center p-4 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 peer-checked:border-green-500 peer-checked:bg-green-50 dark:peer-checked:bg-green-900/20">
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 border-2 border-gray-300 dark:border-gray-500 rounded-full mr-3 peer-checked:border-green-500 peer-checked:bg-green-500 flex items-center justify-center">
                                                <div class="w-2 h-2 bg-white rounded-full hidden peer-checked:block"></div>
                                            </div>
                                            <div>
                                                <div class="font-medium text-black dark:text-white">Physical Institutional</div>
                                                <div class="text-sm text-gray-900 dark:text-gray-100">Courier delivery to institution</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="relative">
                                    <input type="radio" id="ecopy_institutional" name="delivery_option" value="institutional_ecopy" class="sr-only peer">
                                    <label for="ecopy_institutional" class="flex items-center p-4 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 peer-checked:border-green-500 peer-checked:bg-green-50 dark:peer-checked:bg-green-900/20">
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 border-2 border-gray-300 dark:border-gray-500 rounded-full mr-3 peer-checked:border-green-500 peer-checked:bg-green-500 flex items-center justify-center">
                                                <div class="w-2 h-2 bg-white rounded-full hidden peer-checked:block"></div>
                                            </div>
                                            <div>
                                                <div class="font-medium text-black dark:text-white">E-Copy Institutional</div>
                                                <div class="text-sm text-gray-900 dark:text-gray-100">Electronic delivery to institution</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Sub-options for Institutional Physical -->
                        <div id="institutionalPhysicalSubOptions" style="display: none;" class="mt-4">
                            <label class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-3">Choose Delivery Location</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="relative">
                                    <input type="radio" id="local_institutional" name="institutional_location" value="local_institutional" class="sr-only peer">
                                    <label for="local_institutional" class="flex items-center p-4 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 peer-checked:border-green-500 peer-checked:bg-green-50 dark:peer-checked:bg-green-900/20">
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 border-2 border-gray-300 dark:border-gray-500 rounded-full mr-3 peer-checked:border-green-500 peer-checked:bg-green-500 flex items-center justify-center">
                                                <div class="w-2 h-2 bg-white rounded-full hidden peer-checked:block"></div>
                                            </div>
                                            <div>
                                                <div class="font-medium text-black dark:text-white">Local Institutional</div>
                                                <div class="text-sm text-gray-900 dark:text-gray-100">Within Nigeria</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="relative">
                                    <input type="radio" id="international_institutional" name="institutional_location" value="international_institutional" class="sr-only peer">
                                    <label for="international_institutional" class="flex items-center p-4 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 peer-checked:border-green-500 peer-checked:bg-green-50 dark:peer-checked:bg-green-900/20">
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 border-2 border-gray-300 dark:border-gray-500 rounded-full mr-3 peer-checked:border-green-500 peer-checked:bg-green-500 flex items-center justify-center">
                                                <div class="w-2 h-2 bg-white rounded-full hidden peer-checked:block"></div>
                                            </div>
                                            <div>
                                                <div class="font-medium text-black dark:text-white">International Institutional</div>
                                                <div class="text-sm text-gray-900 dark:text-gray-100">Outside Nigeria</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Self Physical Collection Section -->
                    <div class="mb-6" id="selfPhysicalSection" style="display: none;">
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">Physical Self (Self-Collection)</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-100">Pick up from university</div>
                                </div>
                                <div class="text-lg font-bold text-green-600 dark:text-green-400" id="selfPhysicalAmount">₦5,000</div>
                            </div>
                        </div>
                    </div>

                    <!-- Self E-copy Section -->
                    <div class="mb-6" id="selfEcopySection" style="display: none;">
                        <label for="self_email" class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Confirm Email Address</label>
                        <input type="email" id="self_email" name="self_email" value="<?php echo e($student->email ?? ''); ?>" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" readonly>
                        <p class="text-sm text-gray-900 dark:text-gray-100 mt-1">E-copy will be sent to this email address</p>
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg p-4 mt-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">E-Copy Self (Email)</div>
                                    <div class="text-sm text-gray-900 dark:text-gray-100">Electronic transcript via email</div>
                                </div>
                                <div class="text-lg font-bold text-green-600 dark:text-green-400" id="selfEcopyAmount">₦3,000</div>
                            </div>
                        </div>
                    </div>

                    <!-- Courier Selection for Institutional Physical -->
                    <div class="mb-6" id="courierSelectionSection" style="display: none;">
                        <label class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-3">Select Courier Service</label>
                        <div class="space-y-3">
                            <div class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <input type="radio" id="dhl_courier" name="courier" value="dhl" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 dark:border-gray-600">
                                <label for="dhl_courier" class="ml-3 cursor-pointer flex-1">
                                    <div class="font-medium text-gray-900 dark:text-white">DHL</div>
                                    <div class="text-sm text-gray-900 dark:text-gray-100 courier-price" data-courier="dhl">₦3,000</div>
                                </label>
                            </div>
                            <div class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <input type="radio" id="zcarex_courier" name="courier" value="zcarex" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 dark:border-gray-600">
                                <label for="zcarex_courier" class="ml-3 cursor-pointer flex-1">
                                    <div class="font-medium text-gray-900 dark:text-white">ZCarex</div>
                                    <div class="text-sm text-gray-900 dark:text-gray-100 courier-price" data-courier="zcarex">₦30,000</div>
                                </label>
                            </div>
                            <div class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <input type="radio" id="couples_courier" name="courier" value="couples" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 dark:border-gray-600">
                                <label for="couples_courier" class="ml-3 cursor-pointer flex-1">
                                    <div class="font-medium text-gray-900 dark:text-white">Couples</div>
                                    <div class="text-sm text-gray-900 dark:text-gray-100 courier-price" data-courier="couples">₦3,000</div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Institution Details for Physical Delivery -->
                    <div class="mb-6" id="institutionalPhysicalDetailsSection" style="display: none;">
                        <div class="space-y-4">
                            <div>
                                <label for="institution_name" class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Institution Name</label>
                                <input type="text" id="institution_name" name="institution_name" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" placeholder="Enter institution name">
                            </div>
                            <div>
                                <label for="institutional_email" class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Institution Registrar Email</label>
                                <input type="email" id="institutional_email" name="institution_email" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" placeholder="Enter institutional email">
                            </div>
                            <div>
                                <label for="delivery_address" class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Delivery Address</label>
                                <textarea id="delivery_address" name="delivery_address" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" placeholder="Enter delivery address"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Institution Details for E-copy -->
                    <div class="mb-6" id="institutionalEcopyDetailsSection" style="display: none;">
                        <div class="space-y-4">
                            <div>
                                <label for="institution_name_ecopy" class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Institution Name</label>
                                <input type="text" id="institution_name_ecopy" name="institution_name" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" placeholder="Enter institution name">
                            </div>
                            <div>
                                <label for="institutional_email_ecopy" class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Institution Registrar Email</label>
                                <input type="email" id="institutional_email_ecopy" name="institution_email" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" placeholder="Enter institutional email">
                            </div>
                            <div>
                                <label for="institution_address_ecopy" class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Institution Address</label>
                                <textarea id="institution_address_ecopy" name="delivery_address" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" placeholder="Enter institution address"></textarea>
                            </div>
                        </div>
                        <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">E-Copy Institutional</div>
                                    <div class="text-sm text-gray-900 dark:text-gray-100">Electronic transcript to institution</div>
                                </div>
                                <div class="text-lg font-bold text-blue-600 dark:text-blue-400" id="institutionalEcopyAmount">₦3,000</div>
                            </div>
                        </div>
                    </div>

                    <!-- Common sections for all flows -->
                    
                    <!-- Courier Selection (for Institutional Physical) -->
                    <div class="mb-6" id="courierSection" style="display: none;">
                        <label class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-3">Select Courier Service</label>
                        <div class="space-y-3">
                            <div class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <input type="radio" id="dhl" name="courier" value="dhl" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 dark:border-gray-600">
                                <label for="dhl" class="ml-3 cursor-pointer flex-1">
                                    <div class="font-medium text-gray-900 dark:text-white">DHL</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-100 courier-price" data-courier="dhl">₦3,000</div>
                                </label>
                            </div>
                            <div class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <input type="radio" id="zcarex" name="courier" value="zcarex" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 dark:border-gray-600">
                                <label for="zcarex" class="ml-3 cursor-pointer flex-1">
                                    <div class="font-medium text-gray-900 dark:text-white">ZCarex</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-100 courier-price" data-courier="zcarex">₦30,000</div>
                                </label>
                            </div>
                            <div class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <input type="radio" id="couples" name="courier" value="couples" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 dark:border-gray-600">
                                <label for="couples" class="ml-3 cursor-pointer flex-1">
                                    <div class="font-medium text-gray-900 dark:text-white">Couples</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-100 courier-price" data-courier="couples">₦3,000</div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Institution Details (for Institutional requests) -->
                    <div class="mb-6" id="institutionDetailsSection" style="display: none;">
                        <div class="mb-4">
                            <label for="institution_name" class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Institution Name</label>
                            <input type="text" id="institution_name" name="institution_name" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" placeholder="Enter institution name">
                        </div>
                        <div class="mb-4">
                            <label for="ref_no" class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Reference Number <span class="text-gray-500">(Optional)</span></label>
                            <input type="text" id="ref_no" name="ref_no" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" placeholder="Enter reference number">
                        </div>
                        <div class="mb-4">
                            <label for="institutional_email" class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Institution Registrar Email</label>
                            <input type="email" id="institutional_email" name="institution_email" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" placeholder="Enter institutional email">
                        </div>
                        <div class="mb-4" id="institutionalPhoneSection" style="display: none;">
                            <label for="institutional_phone" class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Institution Phone Number</label>
                            <input type="tel" id="institutional_phone" name="institutional_phone" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" placeholder="Enter phone number">
                        </div>
                    </div>

                    <!-- Delivery Address (for Physical delivery) -->
                    <div class="mb-6" id="deliveryAddressSection" style="display: none;">
                        <label for="delivery_address" class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Delivery Address</label>
                        <textarea id="delivery_address" name="delivery_address" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" placeholder="Enter complete delivery address (Google Maps or OpenStreetMap compatible)"></textarea>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Please provide a complete address that can be located on maps</p>
                    </div>

                    <!-- Email Confirmation (for Self E-copy) -->
                    <div class="mb-6" id="emailConfirmationSection" style="display: none;">
                        <label for="student_email" class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Confirm Email Address</label>
                        <input type="email" id="student_email" name="student_email" value="<?php echo e($student->email ?? ''); ?>" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" readonly>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">E-copy will be sent to this email address</p>
                    </div>

                    <!-- Purpose of Request -->
                    <div class="mb-6" id="purposeSection" style="display: none;">
                        <label for="purpose" class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Purpose of Request</label>
                        <textarea id="purpose" name="purpose" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" placeholder="Please specify the purpose for this transcript request..."></textarea>
                    </div>



                    <!-- Price Summary -->
                    <div class="mb-6" id="priceSummarySection" style="display: none;">
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                            <div class="font-medium text-black dark:text-white">Total Amount</div>
                            <div class="text-sm text-black dark:text-gray-100" id="totalBreakdown">Base fee + delivery charges</div>
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400 mt-2" id="totalAmount">₦0</div>
                        </div>
                    </div>

                    <!-- Payment Method Selection -->
                    <div class="mb-6" id="paymentMethodSection" style="display: none;">
                        <label class="block text-sm font-medium text-black dark:text-gray-100 mb-3">Select Payment Method</label>
                        <div class="space-y-3">
                            <div class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <input type="radio" id="paystack" name="payment_method" value="paystack" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 dark:border-gray-600" checked>
                                <label for="paystack" class="ml-3 cursor-pointer flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="font-medium text-black dark:text-white">Paystack</div>
                                            <div class="text-sm text-gray-900 dark:text-gray-100">Pay with Cards, Bank Transfer, USSD</div>
                                        </div>
                                        <div class="text-sm text-orange-600 dark:text-orange-400 font-medium" id="paystackCharge">+1.5% charges</div>
                                    </div>
                                </label>
                            </div>
                            <div class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <input type="radio" id="remita" name="payment_method" value="remita" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 dark:border-gray-600">
                                <label for="remita" class="ml-3 cursor-pointer flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="font-medium text-black dark:text-white">Remita</div>
                                            <div class="text-sm text-gray-900 dark:text-gray-100">Pay with Bank Transfer, Cards</div>
                                        </div>
                                        <div class="text-sm text-orange-600 dark:text-orange-400 font-medium" id="remitaCharge">+1.0% charges</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Payment Summary -->
                        <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="font-medium text-blue-900 dark:text-blue-200">Final Amount to Pay</div>
                                    <div class="text-sm text-blue-700 dark:text-blue-300" id="paymentSummaryText">Includes payment processing charges</div>
                                </div>
                                <div class="text-2xl font-bold text-blue-800 dark:text-blue-300" id="finalPaymentAmount">₦0</div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="<?php echo e(route('student.dashboard')); ?>" class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-black dark:text-gray-100 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Cancel
                        </a>
                        <button type="submit" id="submitBtn" class="inline-flex items-center px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Submit Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('transcriptForm');
    const submitBtn = document.getElementById('submitBtn');

    // Pricing structure (will be loaded from backend)
    let pricing = {};
    let paymentMethods = {};

    // Load pricing structure from backend
    async function loadPricingStructure() {
        try {
            const response = await fetch(`<?php echo e(route('student.transcript.pricing')); ?>?structure=1`);
            const data = await response.json();
            
            if (data.success && data.pricing) {
                pricing = data.pricing;
                console.log('Pricing structure loaded:', pricing);
                updateCourierPrices();
            } else {
                console.error('Failed to load pricing structure:', data);
            }
        } catch (error) {
            console.error('Error loading pricing structure:', error);
        }
    }

    // Load payment methods from backend
    async function loadPaymentMethods() {
        try {
            const response = await fetch(`<?php echo e(route('student.transcript.pricing')); ?>?payment_methods=1`);
            const data = await response.json();
            
            if (data.success && data.payment_methods) {
                paymentMethods = data.payment_methods;
                console.log('Payment methods loaded:', paymentMethods);
                updatePaymentChargeDisplay();
            }
        } catch (error) {
            console.error('Error loading payment methods:', error);
        }
    }

    // Initialize pricing on page load
    async function initializePricing() {
        await loadPricingStructure();
        await loadPaymentMethods();
    }
    initializePricing();

    // Form elements for new 3-step flow
    const categorySelect = document.getElementById('categorySelect'); // Step 1: Category
    const requestTypeSelect = document.getElementById('requestTypeSelect'); // Step 2: Request Type
    
    console.log('categorySelect found:', categorySelect);
    console.log('requestTypeSelect found:', requestTypeSelect);
    
    if (!categorySelect) {
        console.error('categorySelect element not found!');
        return;
    }
    if (!requestTypeSelect) {
        console.error('requestTypeSelect element not found!');
        return;
    }
    const selfPhysicalRadio = document.getElementById('physical_self');
    const selfEcopyRadio = document.getElementById('ecopy_self');
    const institutionalPhysicalRadio = document.getElementById('physical_institutional');
    const institutionalEcopyRadio = document.getElementById('ecopy_institutional');
    const localInstitutionalRadio = document.getElementById('local_institutional');
    const internationalInstitutionalRadio = document.getElementById('international_institutional');
    const courierInputs = document.querySelectorAll('input[name="courier"]');
    const paymentMethodInputs = document.querySelectorAll('input[name="payment_method"]');

    // Sections
    const requestTypeSection = document.getElementById('requestTypeSection');
    const deliveryOptionsSection = document.getElementById('deliveryOptionsSection');
    const selfDeliveryOptions = document.getElementById('selfDeliveryOptions');
    const institutionalDeliveryOptions = document.getElementById('institutionalDeliveryOptions');
    const institutionalPhysicalSubSection = document.getElementById('institutionalPhysicalSubOptions');
    const courierSection = document.getElementById('courierSection');
    const institutionDetailsSection = document.getElementById('institutionDetailsSection');
    const deliveryAddressSection = document.getElementById('deliveryAddressSection');
    const emailConfirmationSection = document.getElementById('emailConfirmationSection');
    const purposeSection = document.getElementById('purposeSection');
    const priceSummarySection = document.getElementById('priceSummarySection');
    const paymentMethodSection = document.getElementById('paymentMethodSection');
    const institutionalPhoneSection = document.getElementById('institutionalPhoneSection');

    // Step 1: Category Selection (Undergraduate/Postgraduate)
    categorySelect.addEventListener('change', function() {
        console.log('Category changed to:', this.value);
        if (this.value && this.value !== '') {
            console.log('Showing request type section');
            requestTypeSection.style.display = 'block';
            resetFromRequestType();
        } else {
            console.log('Hiding all sections');
            hideAllSections();
        }
    });

    // Step 2: Request Type Selection (Self/Institutional)
    requestTypeSelect.addEventListener('change', function() {
        console.log('Request type changed to:', this.value);
        if (this.value && this.value !== '') {
            console.log('Showing delivery options section');
            deliveryOptionsSection.style.display = 'block';
            // Reset other sections but not the delivery options we're about to show
            institutionalPhysicalSubSection.style.display = 'none';
            courierSection.style.display = 'none';
            institutionDetailsSection.style.display = 'none';
            deliveryAddressSection.style.display = 'none';
            emailConfirmationSection.style.display = 'none';
            purposeSection.style.display = 'none';
            priceSummarySection.style.display = 'none';
            paymentMethodSection.style.display = 'none';
            institutionalPhoneSection.style.display = 'none';
            // Now show the appropriate delivery options
            showRequestTypeSpecificSections();
        } else {
            resetFromRequestType();
        }
    });

    // Step 3: Delivery Options
    // Self Physical (Self-Collection)
    if (selfPhysicalRadio) {
        selfPhysicalRadio.addEventListener('change', function() {
            if (this.checked) {
                showCommonSections();
                calculateTotal();
            }
        });
    }

    // Self E-copy (Email)
    if (selfEcopyRadio) {
        selfEcopyRadio.addEventListener('change', function() {
            if (this.checked) {
                emailConfirmationSection.style.display = 'block';
                showCommonSections();
                calculateTotal();
            }
        });
    }

    // Institutional Physical
    if (institutionalPhysicalRadio) {
        institutionalPhysicalRadio.addEventListener('change', function() {
            if (this.checked) {
                institutionalPhysicalSubSection.style.display = 'block';
                institutionDetailsSection.style.display = 'block';
                institutionalPhoneSection.style.display = 'block';
                hideInstitutionalEcopySpecific();
                showCommonSections();
                calculateTotal();
            }
        });
    }

    // Institutional E-copy
    if (institutionalEcopyRadio) {
        institutionalEcopyRadio.addEventListener('change', function() {
            if (this.checked) {
                institutionDetailsSection.style.display = 'block';
                deliveryAddressSection.style.display = 'block';
                showCommonSections();
                hideInstitutionalPhysicalSpecific();
                calculateTotal();
            }
        });
    }

    // Local Institutional Physical
    if (localInstitutionalRadio) {
        localInstitutionalRadio.addEventListener('change', function() {
            if (this.checked) {
                courierSection.style.display = 'block';
                deliveryAddressSection.style.display = 'block';
                showCommonSections();
                updateCourierPricesForDestination('local');
                calculateTotal();
            }
        });
    }

    // International Institutional Physical
    if (internationalInstitutionalRadio) {
        internationalInstitutionalRadio.addEventListener('change', function() {
            if (this.checked) {
                courierSection.style.display = 'block';
                deliveryAddressSection.style.display = 'block';
                showCommonSections();
                updateCourierPricesForDestination('international');
                calculateTotal();
            }
        });
    }

    // Courier selection
    courierInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.checked) {
                calculateTotal();
            }
        });
    });

    // Payment method selection
    paymentMethodInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.checked) {
                calculateTotal();
            }
        });
    });

    function showRequestTypeSpecificSections() {
        const requestType = requestTypeSelect.value;
        
        if (requestType === 'self') {
            selfDeliveryOptions.style.display = 'block';
            institutionalDeliveryOptions.style.display = 'none';
        } else if (requestType === 'institutional') {
            selfDeliveryOptions.style.display = 'none';
            institutionalDeliveryOptions.style.display = 'block';
        }
    }

    function showCommonSections() {
        purposeSection.style.display = 'block';
        priceSummarySection.style.display = 'block';
        paymentMethodSection.style.display = 'block';
    }

    function hideInstitutionalPhysicalSpecific() {
        institutionalPhysicalSubSection.style.display = 'none';
        courierSection.style.display = 'none';
        institutionalPhoneSection.style.display = 'none';
    }

    function hideInstitutionalEcopySpecific() {
        deliveryAddressSection.style.display = 'none';
    }

    function hideAllSections() {
        requestTypeSection.style.display = 'none';
        resetFromRequestType();
    }

    function resetFromRequestType() {
        deliveryOptionsSection.style.display = 'none';
        resetFromDeliveryOptions();
    }

    function resetFromDeliveryOptions() {
        selfDeliveryOptions.style.display = 'none';
        institutionalDeliveryOptions.style.display = 'none';
        institutionalPhysicalSubSection.style.display = 'none';
        courierSection.style.display = 'none';
        institutionDetailsSection.style.display = 'none';
        deliveryAddressSection.style.display = 'none';
        emailConfirmationSection.style.display = 'none';
        purposeSection.style.display = 'none';
        priceSummarySection.style.display = 'none';
        paymentMethodSection.style.display = 'none';
        institutionalPhoneSection.style.display = 'none';
    }

    function updateCourierPrices() {
        if (!pricing || !pricing.courier) return;

        const courierPrices = document.querySelectorAll('.courier-price');
        courierPrices.forEach(price => {
            const courierName = price.getAttribute('data-courier');
            if (courierName && pricing.courier[courierName]) {
                // Default to local pricing, will be updated when destination is selected
                const priceValue = pricing.courier[courierName].local || pricing.courier[courierName];
                price.textContent = `₦${parseFloat(priceValue).toLocaleString()}`;
            }
        });
    }

    function updateCourierPricesForDestination(destination) {
        if (!pricing || !pricing.courier) return;

        const courierPrices = document.querySelectorAll('.courier-price');
        courierPrices.forEach(price => {
            const courierName = price.getAttribute('data-courier');
            if (courierName && pricing.courier[courierName] && pricing.courier[courierName][destination]) {
                const priceValue = pricing.courier[courierName][destination];
                price.textContent = `₦${parseFloat(priceValue).toLocaleString()}`;
            }
        });
    }

    function updatePaymentChargeDisplay() {
        if (paymentMethods.paystack) {
            const paystackCharge = document.getElementById('paystackCharge');
            if (paystackCharge) {
                paystackCharge.textContent = `+${paymentMethods.paystack.charge_percentage}% charges`;
            }
        }
        if (paymentMethods.remita) {
            const remitaCharge = document.getElementById('remitaCharge');
            if (remitaCharge) {
                remitaCharge.textContent = `+${paymentMethods.remita.charge_percentage}% charges`;
            }
        }
    }

    async function calculateTotal() {
        const category = categorySelect.value; // undergraduate/postgraduate
        const requestType = requestTypeSelect.value; // self/institutional
        
        // Determine delivery type and destination
        let deliveryType = '';
        let destination = '';
        let courier = '';

        if (requestType === 'self') {
            if (selfPhysicalRadio && selfPhysicalRadio.checked) {
                deliveryType = 'physical';
                destination = 'self_collection';
            } else if (selfEcopyRadio && selfEcopyRadio.checked) {
                deliveryType = 'e-copy';
                destination = 'email';
            }
        } else if (requestType === 'institutional') {
            if (institutionalPhysicalRadio && institutionalPhysicalRadio.checked) {
                deliveryType = 'physical';
                if (localInstitutionalRadio && localInstitutionalRadio.checked) {
                    destination = 'local';
                } else if (internationalInstitutionalRadio && internationalInstitutionalRadio.checked) {
                    destination = 'international';
                } else {
                    // Default to local if no specific destination selected yet
                    destination = 'local';
                }
                courier = document.querySelector('input[name="courier"]:checked')?.value || '';
            } else if (institutionalEcopyRadio && institutionalEcopyRadio.checked) {
                deliveryType = 'e-copy';
                destination = 'institutional';
            }
        }

        const paymentMethod = document.querySelector('input[name="payment_method"]:checked')?.value;

        if (!category || !requestType || !deliveryType) return;

        try {
            const params = new URLSearchParams();
            params.append('application_type', category);
            params.append('category', requestType);
            params.append('type', deliveryType);
            if (destination) params.append('destination', destination);
            if (courier) params.append('courier', courier);
            if (paymentMethod) params.append('payment_method', paymentMethod);

            const response = await fetch(`<?php echo e(route('student.transcript.pricing')); ?>?${params.toString()}`);
            const data = await response.json();

            if (data.success && data.breakdown) {
                const breakdown = data.breakdown;
                
                // Update total amount display
                const totalAmountElement = document.getElementById('totalAmount');
                if (totalAmountElement) {
                    totalAmountElement.textContent = `₦${parseFloat(breakdown.total).toLocaleString()}`;
                }
                
                // Update breakdown text
                const totalBreakdownElement = document.getElementById('totalBreakdown');
                if (totalBreakdownElement) {
                    let breakdownText = `Transcript: ₦${breakdown.transcript_price}`;
                    
                    if (breakdown.courier_price && parseFloat(breakdown.courier_price) > 0) {
                        breakdownText += ` + Courier: ₦${breakdown.courier_price}`;
                    }
                    
                    // Add payment charges if present
                    if (breakdown.payment_charges && parseFloat(breakdown.payment_charges) > 0) {
                        breakdownText += ` + Payment Fee (${breakdown.charge_percentage}%): ₦${breakdown.payment_charges}`;
                    }
                    
                    // Add additional charges if present
                    if (breakdown.additional_charges && Object.keys(breakdown.additional_charges).length > 0) {
                        for (const [key, value] of Object.entries(breakdown.additional_charges)) {
                            if (parseFloat(value) > 0) {
                                breakdownText += ` + ${key.replace('_', ' ').toUpperCase()}: ₦${value}`;
                            }
                        }
                    }
                    
                    totalBreakdownElement.textContent = breakdownText;
                }

                // Update final payment amount
                const finalPaymentAmountElement = document.getElementById('finalPaymentAmount');
                if (finalPaymentAmountElement) {
                    finalPaymentAmountElement.textContent = `₦${parseFloat(breakdown.total).toLocaleString()}`;
                }

                // Update individual summary elements
                const summaryTranscriptPrice = document.getElementById('summaryTranscriptPrice');
                if (summaryTranscriptPrice) {
                    summaryTranscriptPrice.textContent = `₦${parseFloat(breakdown.transcript_price || 0).toLocaleString()}`;
                }

                const summaryCourierPrice = document.getElementById('summaryCourierPrice');
                if (summaryCourierPrice) {
                    summaryCourierPrice.textContent = `₦${parseFloat(breakdown.courier_price || 0).toLocaleString()}`;
                }

                const summaryPaymentCharges = document.getElementById('summaryPaymentCharges');
                if (summaryPaymentCharges) {
                    summaryPaymentCharges.textContent = `₦${parseFloat(breakdown.payment_charges || 0).toLocaleString()}`;
                }
            }
        } catch (error) {
            console.error('Error calculating pricing:', error);
        }
    }

    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate required selections
        const category = categorySelect.value;
        const requestType = requestTypeSelect.value;
        
        let deliverySelected = false;
        if (requestType === 'self') {
            deliverySelected = (selfPhysicalRadio && selfPhysicalRadio.checked) || 
                             (selfEcopyRadio && selfEcopyRadio.checked);
        } else if (requestType === 'institutional') {
            deliverySelected = (institutionalPhysicalRadio && institutionalPhysicalRadio.checked) || 
                             (institutionalEcopyRadio && institutionalEcopyRadio.checked);
            
            // Additional validation for institutional physical
            if (institutionalPhysicalRadio && institutionalPhysicalRadio.checked) {
                const locationSelected = (localInstitutionalRadio && localInstitutionalRadio.checked) || 
                                       (internationalInstitutionalRadio && internationalInstitutionalRadio.checked);
                const courierSelected = document.querySelector('input[name="courier"]:checked');
                
                if (!locationSelected || !courierSelected) {
                    alert('Please select delivery location and courier service for institutional physical delivery.');
                    return;
                }
            }
        }
        
        if (!category || !requestType || !deliverySelected) {
            alert('Please complete all required selections before proceeding.');
            return;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
        
        // Calculate and add total amount to form
        const totalAmountElement = document.getElementById('totalAmount');
        if (totalAmountElement) {
            const totalAmountText = totalAmountElement.textContent;
            const totalAmount = parseFloat(totalAmountText.replace('₦', '').replace(/,/g, ''));
            
            const totalAmountInput = document.createElement('input');
            totalAmountInput.type = 'hidden';
            totalAmountInput.name = 'total_amount';
            totalAmountInput.value = totalAmount;
            form.appendChild(totalAmountInput);
        }
        
        // Submit form
        setTimeout(() => {
            this.submit();
        }, 1000);
    });
});


</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Veritas ICT\Downloads\trans\transcript-system\resources\views/student/transcript/create.blade.php ENDPATH**/ ?>