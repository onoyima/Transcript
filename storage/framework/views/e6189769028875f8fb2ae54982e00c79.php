

<?php $__env->startSection('content'); ?>
<div class="bg-gray-50 dark:bg-gray-900">
    <!-- Compact Profile Header -->
    <div class="bg-gradient-to-r from-green-400 to-green-600 dark:from-green-600 dark:to-green-800 px-6 py-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center gap-6">
                <!-- Profile Image -->
                <div class="w-20 h-20 rounded-full overflow-hidden border-3 border-white/20 shadow-lg flex-shrink-0">
                    <?php if($student->passport_url): ?>
                        <img src="<?php echo e($student->passport_url); ?>" alt="Profile Photo" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="w-full h-full bg-white/10 backdrop-blur-sm flex items-center justify-center">
                            <span class="text-white font-bold text-xl">
                                <?php echo e(substr($student->fname, 0, 1)); ?><?php echo e(substr($student->lname, 0, 1)); ?>

                            </span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Profile Info -->
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-white truncate">
                        <?php echo e($student->fname); ?> <?php echo e($student->lname); ?>

                    </h1>
                    <div class="flex flex-wrap items-center gap-4 mt-2 text-green-100 text-sm">
                        <?php if($academicInfo && $academicInfo->matric_no): ?>
                            <span class="flex items-center gap-2">
                                <i class="fas fa-id-card"></i>
                                <?php echo e($academicInfo->matric_no); ?>

                            </span>
                        <?php endif; ?>
                        <?php if($academicInfo && $academicInfo->level): ?>
                            <span class="px-3 py-1 bg-white/20 rounded-full text-sm font-medium">
                                <?php echo e($academicInfo->level); ?> Level
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto p-6 space-y-6">

        <!-- Main Information Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Personal & Academic Information Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md border border-gray-200/50 dark:border-gray-700/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-black mb-6 flex items-center">
                    <i class="fas fa-user-graduate mr-3 text-green-600 dark:text-green-400"></i>
                    Personal & Academic Information
                </h3>

                <!-- Personal Information Section -->
                <div class="mb-6">
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-900 mb-4 border-b border-gray-200 dark:border-gray-600 pb-2">Personal Details</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-900">Name</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-black"><?php echo e($student->fname); ?> <?php echo e($student->lname); ?></p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-900">Gender</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-black"><?php echo e(ucfirst($student->gender ?? 'N/A')); ?></p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-900">Date of Birth</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-black">
                                <?php if($student->dob): ?>
                                    <?php echo e(\Carbon\Carbon::parse($student->dob)->format('M j, Y')); ?>

                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-900">Email</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-black truncate"><?php echo e($student->email ?? 'N/A'); ?></p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-900">Phone</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-black"><?php echo e($student->phone ?? 'N/A'); ?></p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-900">State</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-black"><?php echo e($student->state_id ?? 'N/A'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Academic Information Section -->
                <?php if($academicInfo): ?>
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-900 mb-4 border-b border-gray-200 dark:border-gray-600 pb-2">Academic Details</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-900">Matric Number</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-black"><?php echo e($academicInfo->matric_no ?? 'N/A'); ?></p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-900">Level</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-black"><?php echo e($academicInfo->level ?? 'N/A'); ?></p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-900">Program</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-black"><?php echo e($academicInfo->program->course_study_id ?? 'N/A'); ?></p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-900">Session</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-black"><?php echo e($academicInfo->session ?? 'N/A'); ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Contact & Medical Information Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md border border-gray-200/50 dark:border-gray-700/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-black mb-6 flex items-center">
                    <i class="fas fa-address-card mr-3 text-green-600 dark:text-green-400"></i>
                    Contact & Medical Information
                </h3>

                <!-- Emergency Contact Section -->
                <?php if($contactInfo): ?>
                <div class="mb-6">
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-900 mb-4 border-b border-gray-200 dark:border-gray-600 pb-2">Emergency Contact</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-900">Contact Name</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-black"><?php echo e($contactInfo->full_name ?? 'N/A'); ?></p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-900">Relationship</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-black"><?php echo e(ucfirst($contactInfo->relationship ?? 'N/A')); ?></p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-900">Phone</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-black"><?php echo e($contactInfo->paphone ?? 'N/A'); ?></p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-900">Email</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-black truncate"><?php echo e($contactInfo->email ?? 'N/A'); ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Medical Information Section -->
                <?php if($medicalInfo): ?>
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-900 mb-4 border-b border-gray-200 dark:border-gray-600 pb-2">Medical Details</h4>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-900">Blood Group</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-black"><?php echo e($medicalInfo->blood_group ?? 'N/A'); ?></p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-900">Genotype</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-black"><?php echo e($medicalInfo->genotype ?? 'N/A'); ?></p>
                        </div>
                    </div>
                    <?php if($medicalInfo->condition && $medicalInfo->condition !== 'None reported'): ?>
                    <div class="space-y-2 mb-4">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-900">Medical Conditions</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-black"><?php echo e($medicalInfo->condition); ?></p>
                    </div>
                    <?php endif; ?>
                    <?php if($medicalInfo->allergies && $medicalInfo->allergies !== 'None reported'): ?>
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-900">Allergies</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-black"><?php echo e($medicalInfo->allergies); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Update Contact Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md border border-gray-200/50 dark:border-gray-700/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-black mb-6 flex items-center">
                <i class="fas fa-edit mr-3 text-green-600 dark:text-green-400"></i>
                Update Contact Information
            </h3>

            <form action="<?php echo e(route('student.update.details')); ?>" method="POST" id="update-form" class="space-y-4">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="matric_number" value="<?php echo e($student->id); ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Phone Number Input -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-900 dark:text-gray-900 mb-2">
                            <i class="fas fa-phone mr-2 text-green-600 dark:text-green-400"></i>
                            Phone Number
                        </label>
                        <input
                            type="text"
                            name="phone"
                            id="phone"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white text-sm"
                            value="<?php echo e(old('phone', $student->phone)); ?>"
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
                        <label for="email" class="block text-sm font-medium text-gray-900 dark:text-gray-900 mb-2">
                            <i class="fas fa-envelope mr-2 text-green-600 dark:text-green-400"></i>
                            Email Address
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white text-sm"
                            value="<?php echo e(old('email', $student->email)); ?>"
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Veritas ICT\Downloads\trans\transcript-system\resources\views/student/profile.blade.php ENDPATH**/ ?>