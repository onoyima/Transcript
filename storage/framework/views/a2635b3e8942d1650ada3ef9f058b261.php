

<?php $__env->startSection('title', 'Student Login - Veritas University'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 flex items-center justify-center py-6 sm:py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl w-full space-y-6 sm:space-y-8">
        <!-- Header Section -->
        <div class="text-center">
            <div class="mx-auto h-16 w-16 sm:h-20 sm:w-20 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center mb-4 sm:mb-6 shadow-lg">
                <i class="fas fa-graduation-cap text-white text-2xl sm:text-3xl"></i>
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-gray-800 mb-2 sm:mb-3">Veritas University</h2>
            <p class="text-black dark:text-black text-base sm:text-lg font-medium">Student Transcript Portal</p>
            <p class="text-black dark:text-black text-xs sm:text-sm mt-1 sm:mt-2">Secure access to your academic records</p>
        </div>

        <!-- Main Card -->
        <div class="bg-white/95 dark:bg-gray-50/95 backdrop-blur-sm rounded-3xl shadow-2xl border border-gray-200/50 dark:border-gray-300/50 overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gray-50 dark:bg-gray-100 px-4 sm:px-6 lg:px-8 py-4 sm:py-6 border-b border-gray-200 dark:border-gray-300">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg sm:text-xl font-semibold text-gray-800 dark:text-gray-800 flex items-center">
                            <i class="fas fa-sign-in-alt mr-2 sm:mr-3 text-primary-600 dark:text-primary-400"></i>
                            <span class="hidden sm:inline">Student Authentication Portal</span>
                            <span class="sm:hidden">Authentication Portal</span>
                        </h3>
                        <p class="text-black dark:text-black text-xs sm:text-sm mt-1">Choose your preferred login method below</p>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="<?php echo e(route('transcript.staff.login')); ?>" 
                           class="inline-flex items-center px-3 sm:px-4 py-2 border border-gray-300 rounded-lg text-xs sm:text-sm font-medium text-black bg-white hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200 shadow-sm">
                            <i class="fas fa-user-tie mr-1 sm:mr-2 text-xs"></i>
                            <span class="hidden sm:inline">Staff Login</span>
                            <span class="sm:hidden">Staff</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Body -->
            <div class="px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
                <?php if(session('success')): ?>
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-green-800 font-medium"><?php echo e(session('success')); ?></p>
                        </div>
                        <button type="button" class="ml-auto text-green-400 hover:text-green-600" onclick="this.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6 flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-red-800 font-medium"><?php echo e(session('error')); ?></p>
                        </div>
                        <button type="button" class="ml-auto text-red-400 hover:text-red-600" onclick="this.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- Login Options Tabs -->
                <div class="border-b border-gray-200/50 dark:border-gray-700/50 mb-6 sm:mb-8">
                    <nav class="-mb-px flex flex-col sm:flex-row gap-2 sm:gap-4 lg:gap-8" aria-label="Tabs">
                        <button class="tab-button active border-b-2 border-primary-500 py-3 sm:py-4 px-3 sm:px-4 text-xs sm:text-sm font-medium text-primary-600 dark:text-primary-400 bg-primary-50/50 dark:bg-primary-900/20 rounded-t-lg transition-all duration-200 flex items-center justify-center sm:justify-start flex-1 sm:flex-none" 
                                id="password-tab" data-target="#password-login">
                            <i class="fas fa-key mr-1 sm:mr-2 text-xs sm:text-sm"></i>
                            <span class="hidden sm:inline">Login with Password</span>
                            <span class="sm:hidden">Password</span>
                        </button>
                        <button class="tab-button border-b-2 border-transparent py-3 sm:py-4 px-3 sm:px-4 text-xs sm:text-sm font-medium text-black dark:text-black hover:text-black dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-t-lg transition-all duration-200 flex items-center justify-center sm:justify-start flex-1 sm:flex-none" 
                                id="matric-tab" data-target="#matric-verification">
                            <i class="fas fa-id-card mr-1 sm:mr-2 text-xs sm:text-sm"></i>
                            <span class="hidden sm:inline">I Know My Matric Number</span>
                            <span class="sm:hidden">Matric Number</span>
                        </button>
                        <button class="tab-button border-b-2 border-transparent py-3 sm:py-4 px-3 sm:px-4 text-xs sm:text-sm font-medium text-black dark:text-black hover:text-black dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-t-lg transition-all duration-200 flex items-center justify-center sm:justify-start flex-1 sm:flex-none" 
                                id="security-tab" data-target="#security-questions">
                            <i class="fas fa-question-circle mr-1 sm:mr-2 text-xs sm:text-sm"></i>
                            <span class="hidden sm:inline">Can't Remember Matric Number?</span>
                            <span class="sm:hidden">Security Questions</span>
                        </button>
                    </nav>
                </div>

                <div class="tab-content">
                    <!-- Password Login Tab -->
                    <div class="tab-panel active" id="password-login">
                        <form id="loginForm" method="POST" action="<?php echo e(route('student.login.submit')); ?>" class="space-y-4 sm:space-y-6">
                            <?php echo csrf_field(); ?>
                            <div>
                                <label for="email" class="block text-xs sm:text-sm font-medium text-black dark:text-gray-300 mb-1 sm:mb-2">
                                    <i class="fas fa-user mr-1 sm:mr-2 text-black dark:text-black text-xs sm:text-sm"></i>Email Address
                                </label>
                                <input type="email" 
                                       class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 dark:border-gray-400 bg-white dark:bg-gray-50 text-gray-900 dark:text-gray-800 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 text-sm sm:text-base <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 focus:ring-red-500 focus:border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="email" 
                                       name="email" 
                                       value="<?php echo e(old('email')); ?>" 
                                       required 
                                       placeholder="Enter your email address">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label for="password" class="block text-xs sm:text-sm font-medium text-black dark:text-gray-300 mb-1 sm:mb-2">
                                    <i class="fas fa-lock mr-1 sm:mr-2 text-black dark:text-black text-xs sm:text-sm"></i>Password
                                </label>
                                <div class="relative">
                                    <input type="password" 
                                           class="w-full px-3 sm:px-4 py-2 sm:py-3 pr-10 sm:pr-12 border border-gray-300 dark:border-gray-400 bg-white dark:bg-gray-50 text-gray-900 dark:text-gray-800 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 text-sm sm:text-base <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 focus:ring-red-500 focus:border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="password" 
                                           name="password" 
                                           required 
                                           placeholder="Enter your password">
                                    <button type="button" 
                                            class="absolute inset-y-0 right-0 pr-2 sm:pr-3 flex items-center text-black dark:text-black hover:text-primary-500 dark:hover:text-primary-400 transition-colors duration-200" 
                                            id="togglePassword">
                                        <i class="fas fa-eye text-sm"></i>
                                    </button>
                                </div>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" 
                                       class="h-3 w-3 sm:h-4 sm:w-4 text-primary-600 focus:ring-primary-500 border-gray-300 dark:border-gray-400 bg-white dark:bg-gray-50 rounded" 
                                       id="remember" 
                                       name="remember">
                                <label for="remember" class="ml-2 block text-xs sm:text-sm text-black dark:text-gray-300">
                                    Remember me
                                </label>
                            </div>

                            <!-- Progress Bar (hidden by default) -->
                            <div id="loginProgress" class="hidden mb-4">
                                <div class="bg-gray-200 rounded-full h-2 overflow-hidden">
                                    <div class="bg-gradient-to-r from-green-400 to-green-600 h-full rounded-full transition-all duration-1000 ease-out" 
                                         style="width: 0%" id="progressBar"></div>
                                </div>
                                <p class="text-center text-sm text-black mt-2" id="progressText">Authenticating...</p>
                            </div>

                            <div>
                                <button type="submit" 
                                        id="loginButton"
                                        class="w-full flex justify-center items-center py-2 sm:py-3 px-3 sm:px-4 border border-transparent rounded-xl shadow-lg text-sm font-medium text-white bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                                    <i class="fas fa-sign-in-alt mr-1 sm:mr-2 text-sm" id="loginIcon"></i>
                                    <span class="hidden sm:inline" id="loginTextLarge">Sign In to Portal</span>
                                    <span class="sm:hidden" id="loginTextSmall">Sign In</span>
                                </button>
                            </div>

                            <div class="text-center">
                                <a href="<?php echo e(route('student.password.reset')); ?>" 
                                   class="text-xs sm:text-sm text-primary-600 hover:text-primary-500 font-medium transition-colors duration-200">
                                    <i class="fas fa-question-circle mr-1 text-xs sm:text-sm"></i>Forgot your password?
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Matric Number Verification Tab -->
                    <div class="tab-panel hidden" id="matric-verification">
                        <div class="bg-primary-50 border border-primary-200 rounded-xl p-4 mb-6 flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-primary-500 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-primary-800 font-medium">Know your matric number but forgot your login details?</p>
                                <p class="text-primary-700 text-sm mt-1">Enter your matriculation number and email below. We'll send you a password reset link with your login credentials.</p>
                            </div>
                        </div>

                        <form method="POST" action="<?php echo e(route('student.matric.process')); ?>" class="space-y-6">
                            <?php echo csrf_field(); ?>
                            <div>
                                <label for="matric_number" class="block text-sm font-medium text-black dark:text-gray-300 mb-2">
                                    <i class="fas fa-id-card mr-2 text-black"></i>Matriculation Number
                                </label>
                                <input type="text" 
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-400 bg-white dark:bg-gray-50 text-gray-900 dark:text-gray-800 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 uppercase <?php $__errorArgs = ['matric_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 focus:ring-red-500 focus:border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="matric_number" 
                                       name="matric_number" 
                                       value="<?php echo e(old('matric_number')); ?>" 
                                       required 
                                       placeholder="Enter your matriculation number">
                                <?php $__errorArgs = ['matric_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <p class="mt-2 text-sm text-black dark:text-black">
                                    Enter your matriculation number exactly as it appears on your student ID.
                                </p>
                            </div>

                            <div>
                                <label for="email_matric" class="block text-sm font-medium text-black dark:text-gray-300 mb-2">
                                    <i class="fas fa-envelope mr-2 text-black"></i>Email Address
                                </label>
                                <input type="email" 
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-400 bg-white dark:bg-gray-50 text-gray-900 dark:text-gray-800 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 focus:ring-red-500 focus:border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="email_matric" 
                                       name="email" 
                                       value="<?php echo e(old('email')); ?>" 
                                       required 
                                       placeholder="Enter your email address">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <p class="mt-2 text-sm text-black dark:text-black">
                                    We'll send your login credentials and password reset link to this email.
                                </p>
                            </div>

                            <div>
                                <button type="submit" 
                                        class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-medium text-white bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200 transform hover:scale-[1.02]">
                                    <i class="fas fa-paper-plane mr-2"></i>Send Password Reset Link
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Security Questions Tab -->
                    <div class="tab-panel hidden" id="security-questions">
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6 flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-amber-400 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-amber-800 font-medium">Can't remember your matriculation number?</p>
                                <p class="text-amber-700 text-sm mt-1">Answer the security questions below. If they match our records, we'll send you a password reset link with your login credentials.</p>
                            </div>
                        </div>

                        <form method="POST" action="<?php echo e(route('student.security.verify')); ?>" class="space-y-6">
                            <?php echo csrf_field(); ?>
                            <div>
                                <label for="surname" class="block text-sm font-medium text-black mb-2">
                                    <i class="fas fa-user mr-2 text-black"></i>Surname (Last Name)
                                </label>
                                <input type="text" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 <?php $__errorArgs = ['surname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 focus:ring-red-500 focus:border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="surname" 
                                       name="surname" 
                                       value="<?php echo e(old('surname')); ?>" 
                                       required 
                                       placeholder="Enter your surname as registered">
                                <?php $__errorArgs = ['surname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-black mb-2">
                                    <i class="fas fa-calendar mr-2 text-black"></i>Date of Birth
                                </label>
                                <input type="date" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 <?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 focus:ring-red-500 focus:border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="date_of_birth" 
                                       name="date_of_birth" 
                                       value="<?php echo e(old('date_of_birth')); ?>" 
                                       required>
                                <?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label for="program_id" class="block text-sm font-medium text-black mb-2">
                                    <i class="fas fa-graduation-cap mr-2 text-black"></i>Program of Study
                                </label>
                                <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 <?php $__errorArgs = ['program_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 focus:ring-red-500 focus:border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="program_id" 
                                        name="program_id" 
                                        required>
                                    <option value="">Select your program</option>
                                    <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($program->id); ?>" <?php echo e(old('program_id') == $program->id ? 'selected' : ''); ?>>
                                            <?php echo e($program->name); ?> (<?php echo e($program->code); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['program_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label for="email_security" class="block text-sm font-medium text-black mb-2">
                                    <i class="fas fa-envelope mr-2 text-black"></i>Email Address
                                </label>
                                <input type="email" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 focus:ring-red-500 focus:border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="email_security" 
                                       name="email" 
                                       value="<?php echo e(old('email')); ?>" 
                                       required 
                                       placeholder="Enter your email address">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <p class="mt-2 text-sm text-black">
                                    We'll send your login credentials and password reset link to this email.
                                </p>
                            </div>

                            <div>
                                <button type="submit" 
                                        class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-medium text-white bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200 transform hover:scale-[1.02]">
                                    <i class="fas fa-search mr-2"></i>Verify & Send Reset Link
                                </button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>

            <!-- Security Notice -->
            <div class="mt-8 bg-gray-50 border border-gray-200 rounded-xl p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-shield-alt text-primary-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-gray-900">Security Notice</h3>
                        <div class="mt-2 text-sm text-black">
                            <p>Your account security is important to us. If you're having trouble accessing your account or suspect unauthorized access, please contact our support team immediately.</p>
                            <div class="mt-3 flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-2 sm:space-y-0">
                                <div class="flex items-center">
                                    <i class="fas fa-envelope text-primary-400 mr-2"></i>
                                    <span class="text-sm">ictsupport@veritas.edu.ng</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-phone text-primary-400 mr-2"></i>
                                    <span class="text-sm">(+234) 812 0212 639</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .tab-panel {
        display: none;
    }
    .tab-panel.active {
        display: block;
    }
    .tab-button.active {
        background: linear-gradient(135deg, #3b82f6, #6366f1);
        color: white;
        border-color: #3b82f6;
    }
</style>

<script>
    // Tab functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabPanels = document.querySelectorAll('.tab-panel');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                
                // Remove active class from all buttons
                tabButtons.forEach(btn => {
                    btn.classList.remove('active', 'border-blue-500', 'text-blue-600');
                    btn.classList.add('border-transparent', 'text-black');
                });
                
                // Add active class to clicked button
                this.classList.add('active', 'border-blue-500', 'text-blue-600');
                this.classList.remove('border-transparent', 'text-black');
                
                // Hide all panels
                tabPanels.forEach(panel => {
                    panel.classList.remove('active');
                    panel.classList.add('hidden');
                });
                
                // Show target panel
                const targetPanel = document.querySelector(targetId);
                if (targetPanel) {
                    targetPanel.classList.add('active');
                    targetPanel.classList.remove('hidden');
                }
            });
        });
        
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                const icon = this.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        }

        // Auto-uppercase matric number
        const matricInput = document.getElementById('matric_number');
        if (matricInput) {
            matricInput.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        }

        // Login form progress handling
        const loginForm = document.getElementById('loginForm');
        const loginButton = document.getElementById('loginButton');
        const loginProgress = document.getElementById('loginProgress');
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');
        const loginIcon = document.getElementById('loginIcon');
        const loginTextLarge = document.getElementById('loginTextLarge');
        const loginTextSmall = document.getElementById('loginTextSmall');

        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                // Show progress bar and disable button
                loginProgress.classList.remove('hidden');
                loginButton.disabled = true;
                
                // Change button text and icon
                loginIcon.className = 'fas fa-spinner fa-spin mr-1 sm:mr-2 text-sm';
                loginTextLarge.textContent = 'Signing In...';
                loginTextSmall.textContent = 'Signing In...';
                
                // Animate progress bar
                let progress = 0;
                const progressInterval = setInterval(() => {
                    progress += Math.random() * 15;
                    if (progress > 90) progress = 90;
                    progressBar.style.width = progress + '%';
                    
                    if (progress > 30) {
                        progressText.textContent = 'Verifying credentials...';
                    }
                    if (progress > 60) {
                        progressText.textContent = 'Setting up your session...';
                    }
                }, 100);
                
                // Clear interval after 5 seconds (fallback)
                setTimeout(() => {
                    clearInterval(progressInterval);
                    progressBar.style.width = '100%';
                    progressText.textContent = 'Almost done...';
                }, 5000);
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Veritas ICT\Downloads\trans\transcript-system\resources\views/student/auth/login.blade.php ENDPATH**/ ?>