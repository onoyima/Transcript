<?php $__env->startSection('title', 'Staff Profile'); ?>

<?php $__env->startSection('content'); ?>
<!-- Compact Profile Header -->
<div class="bg-gradient-to-r from-green-400 to-green-600 dark:from-green-600 dark:to-green-800 rounded-xl p-6 mb-6 -mx-4 md:-mx-6 2xl:-mx-10">
    <div class="flex items-center gap-6">
        <!-- Profile Image -->
        <div class="w-20 h-20 rounded-full overflow-hidden border-3 border-white/20 shadow-lg flex-shrink-0">
            <div class="w-full h-full bg-white/10 backdrop-blur-sm flex items-center justify-center">
                <span class="text-white font-bold text-xl">
                    <?php echo e(strtoupper(substr($staff->fname, 0, 1) . substr($staff->lname, 0, 1))); ?>

                </span>
            </div>
        </div>

        <!-- Profile Info -->
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-white truncate">
                <?php echo e($staff->fname); ?> <?php echo e($staff->lname); ?>

            </h1>
            <div class="flex flex-wrap items-center gap-4 mt-2 text-green-100 text-sm">
                <?php if($staff->username): ?>
                    <span class="flex items-center gap-2">
                        <i class="fas fa-user"></i>
                        <?php echo e($staff->username); ?>

                    </span>
                <?php endif; ?>
                <?php if($workProfile && $workProfile->department): ?>
                    <span class="px-3 py-1 bg-white/20 rounded-full text-sm font-medium">
                        <?php echo e($workProfile->department ?? 'Department'); ?>

                    </span>
                <?php endif; ?>
                <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full
                    <?php if($staff->status === 'active'): ?> bg-white/20 text-white
                    <?php else: ?> bg-red-500/20 text-red-200
                    <?php endif; ?>">
                    <?php echo e(ucfirst($staff->status)); ?>

                </span>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="space-y-6">

        <!-- Main Information Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Personal & Work Information Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md border border-gray-200/50 dark:border-gray-700/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                    <i class="fas fa-user-tie mr-3 text-green-600 dark:text-green-400"></i>
                    Personal & Work Information
                </h3>

                <!-- Personal Information Section -->
                <div class="mb-6">
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-300 mb-4 border-b border-gray-200 dark:border-gray-600 pb-2">Personal Details</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">First Name</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white"><?php echo e($staff->fname); ?></p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Last Name</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white"><?php echo e($staff->lname); ?></p>
                        </div>
                        <?php if($staff->lname): ?>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">lname</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white"><?php echo e($staff->lname); ?></p>
                        </div>
                        <?php endif; ?>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Email</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white truncate"><?php echo e($staff->email); ?></p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Phone</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white"><?php echo e($staff->phone ?? 'N/A'); ?></p>
                        </div>
                        <?php if($staff->username): ?>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Username</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white"><?php echo e($staff->username); ?></p>
                        </div>
                        <?php endif; ?>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Member Since</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white"><?php echo e($staff->created_at->format('M j, Y')); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Work Information Section -->
                <?php if($workProfile): ?>
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-300 mb-4 border-b border-gray-200 dark:border-gray-600 pb-2">Work Details</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <?php if($workProfile->staff_number): ?>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Staff Number</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white"><?php echo e($workProfile->staff_number); ?></p>
                        </div>
                        <?php endif; ?>
                        <?php if($workProfile->department): ?>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Department</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white"><?php echo e($workProfile->department ?? 'Not assigned'); ?></p>
                        </div>
                        <?php endif; ?>
                        <?php if($workProfile->position): ?>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Position</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white"><?php echo e($workProfile->position ?? 'Not assigned'); ?></p>
                        </div>
                        <?php endif; ?>
                        <?php if($workProfile->appointment_date): ?>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Appointment Date</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white"><?php echo e(\Carbon\Carbon::parse($workProfile->appointment_date)->format('M j, Y')); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Roles & Permissions Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md border border-gray-200/50 dark:border-gray-700/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                    <i class="fas fa-shield-alt mr-3 text-green-600 dark:text-green-400"></i>
                    Roles & Permissions
                </h3>
                
                <?php if($roles->count() > 0): ?>
                    <div class="space-y-3">
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900 dark:text-white"><?php echo e($role->display_name); ?></h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400"><?php echo e($role->description); ?></p>
                                </div>
                                <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    Active
                                </span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="text-center p-8 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-info-circle text-2xl mb-2"></i>
                        <p>No roles assigned</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Activity Statistics -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md border border-gray-200/50 dark:border-gray-700/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                <i class="fas fa-chart-bar mr-3 text-green-600 dark:text-green-400"></i>
                Activity Overview
            </h3>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <?php if(isset($activityStats['applications_handled'])): ?>
                <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400"><?php echo e($activityStats['applications_handled']); ?></div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Applications</div>
                </div>
                <?php endif; ?>
                
                <?php if(isset($activityStats['pending_applications'])): ?>
                <div class="text-center p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                    <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400"><?php echo e($activityStats['pending_applications']); ?></div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Pending</div>
                </div>
                <?php endif; ?>
                
                <?php if(isset($activityStats['payments_processed'])): ?>
                <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400"><?php echo e($activityStats['payments_processed']); ?></div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Payments</div>
                </div>
                <?php endif; ?>
                
                <?php if(isset($activityStats['total_revenue'])): ?>
                <div class="text-center p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg">
                    <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">₦<?php echo e(number_format($activityStats['total_revenue'], 2)); ?></div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Revenue</div>
                </div>
                <?php endif; ?>
                
                <?php if(empty($activityStats)): ?>
                <div class="col-span-full text-center p-8 text-gray-500 dark:text-gray-400">
                    <i class="fas fa-info-circle text-2xl mb-2"></i>
                    <p>No activity statistics available based on your current permissions.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Update Contact Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md border border-gray-200/50 dark:border-gray-700/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                <i class="fas fa-edit mr-3 text-green-600 dark:text-green-400"></i>
                Update Contact Information
            </h3>

            <form action="<?php echo e(route('transcript.staff.profile.update')); ?>" method="POST" id="update-form" class="space-y-4">
                <?php echo csrf_field(); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Phone Number Input -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-phone mr-2 text-green-600 dark:text-green-400"></i>
                            Phone Number
                        </label>
                        <input
                            type="text"
                            name="phone"
                            id="phone"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white text-sm"
                            value="<?php echo e(old('phone', $staff->phone)); ?>"
                            placeholder="Enter phone number"/>
                        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-500"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Email Address Input -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-envelope mr-2 text-green-600 dark:text-green-400"></i>
                            Email Address
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white text-sm"
                            value="<?php echo e(old('email', $staff->email)); ?>"
                            placeholder="Enter email address"/>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-500"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                            class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-green-400 to-green-600 hover:from-green-500 hover:to-green-700 text-white rounded-lg transition-all duration-300 flex items-center justify-center font-medium text-sm shadow-md hover:shadow-lg"
                            id="update-button">
                        <span id="spinner" class="hidden animate-spin mr-2">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" stroke-opacity="0.3"/>
                                <path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <span id="button-text">
                            <i class="fas fa-save mr-2"></i>
                            Update Profile
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md border border-gray-200/50 dark:border-gray-700/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                <i class="fas fa-bolt mr-3 text-green-600 dark:text-green-400"></i>
                Quick Actions
            </h3>
            
            <div class="space-y-3">
                <a href="<?php echo e(route('transcript.staff.dashboard')); ?>" 
                   class="flex items-center p-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-tachometer-alt mr-3 text-green-600 dark:text-green-400"></i>
                    Dashboard
                </a>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_transcript_applications', $staff)): ?>
                <a href="<?php echo e(route('transcript.staff.applications')); ?>" 
                   class="flex items-center p-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-file-alt mr-3 text-green-600 dark:text-green-400"></i>
                    Applications
                </a>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_transcript_payments', $staff)): ?>
                <a href="<?php echo e(route('transcript.staff.payments')); ?>" 
                   class="flex items-center p-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-credit-card mr-3 text-green-600 dark:text-green-400"></i>
                    Payments
                </a>
                <?php endif; ?>
            </div>
        </div>

    <script>
        // Get the form, button, spinner, and text elements
        const updateButton = document.getElementById('update-button');
        const spinner = document.getElementById('spinner');
        const buttonText = document.getElementById('button-text');
        const form = document.getElementById('update-form');

        // Add event listener to the form submission
        form.addEventListener('submit', function(event) {
            // Show the spinner and update button text
            spinner.classList.remove('hidden');
            buttonText.innerHTML = 'Updating...';

            // Disable the button to prevent multiple clicks
            updateButton.disabled = true;
            updateButton.classList.add('opacity-75', 'cursor-not-allowed');
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.staff', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Veritas ICT\Downloads\trans\transcript-system\resources\views/transcript/staff/profile.blade.php ENDPATH**/ ?>