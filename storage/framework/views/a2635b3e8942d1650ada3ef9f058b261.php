<?php $__env->startSection('title', 'Student Login - Veritas University'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex items-center justify-center py-6 sm:py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl w-full space-y-6 sm:space-y-8">
        <!-- Theme Toggle -->
        <div class="flex justify-end">
            <button
                class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 hover:text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white shadow-sm"
                @click.prevent="toggleTheme()"
                title="Toggle theme">
                <svg class="hidden dark:block" width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 2a6 6 0 110 12A6 6 0 0110 4z" fill="currentColor"/>
                </svg>
                <svg class="dark:hidden" width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 15a5 5 0 100-10 5 5 0 000 10z" fill="currentColor"/>
                </svg>
                <span class="text-sm">Theme</span>
            </button>
        </div>
        

        <!-- Main Card -->
        <div class="bg-white dark:bg-gray-50 rounded-2xl shadow-2xl overflow-hidden">

            <!-- Card Body -->
            <div class="px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
                <!-- Quick Staff Login Link -->
                <div class="flex justify-end mb-4">
                    <a href="<?php echo e(route('transcript.staff.login')); ?>"
                       class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 hover:text-gray-900 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white shadow-sm">
                        <i class="fas fa-user-tie text-sm"></i>
                        <span class="text-sm">Staff Login</span>
                    </a>
                </div>
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Left: Existing Login Content -->
                    <div>
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

                <!-- Tabs moved to right column -->
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Student Login</h2>

                <div class="tab-content">
                    <!-- Password Login Tab -->
                    <div class="tab-panel active" id="password-login">
                        <form id="loginForm" method="POST" action="<?php echo e(route('student.login.submit')); ?>" class="space-y-4 sm:space-y-6">
                            <?php echo csrf_field(); ?>
                            <div>
                                <label for="email" class="block text-sm sm:text-base font-medium text-gray-900 dark:text-gray-300 mb-2">
                                    <i class="fas fa-user mr-1 sm:mr-2 text-gray-900 dark:text-white text-xs sm:text-sm"></i>Email Address
                                </label>
                                <input type="email" 
                                       class="w-full px-4 sm:px-5 py-3 sm:py-4 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 text-base sm:text-lg <?php $__errorArgs = ['email'];
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
                                <label for="password" class="block text-sm sm:text-base font-medium text-gray-900 dark:text-gray-300 mb-2">
                                    <i class="fas fa-lock mr-1 sm:mr-2 text-gray-900 dark:text-white text-xs sm:text-sm"></i>Password
                                </label>
                                <div class="relative">
                                    <input type="password" 
                                           class="w-full px-4 sm:px-5 py-3 sm:py-4 pr-10 sm:pr-12 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 text-base sm:text-lg <?php $__errorArgs = ['password'];
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
                                            class="absolute inset-y-0 right-0 pr-2 sm:pr-3 flex items-center text-gray-900 dark:text-gray-300 hover:text-primary-500 dark:hover:text-primary-400 transition-colors duration-200" 
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
                                        class="w-full flex justify-center items-center py-3 sm:py-4 px-4 sm:px-5 border border-transparent rounded-xl shadow-lg text-base font-medium text-white bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
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
                                <label for="matric_number" class="block text-sm font-medium text-gray-900 dark:text-gray-300 mb-2">
                                    <i class="fas fa-id-card mr-2 text-gray-900"></i>Matriculation Number
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
                                <p class="mt-2 text-sm text-gray-900 dark:text-white">
                                    Enter your matriculation number exactly as it appears on your student ID.
                                </p>
                            </div>

                            <div>
                                <label for="email_matric" class="block text-sm font-medium text-gray-900 dark:text-gray-300 mb-2">
                                    <i class="fas fa-envelope mr-2 text-gray-900"></i>Email Address
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
                                <p class="mt-2 text-sm text-gray-900 dark:text-white">
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

                <!-- Right: Branding Section (Desktop) with tabs underneath -->
                <div class="hidden md:block bg-gray-50 dark:bg-gray-50 relative overflow-hidden">
                    <div class="relative z-10 h-full flex items-center justify-center p-8 lg:p-12">
                        <div class="text-center text-gray-800 dark:text-gray-800 w-full">
                            <div class="mb-6">
                                <div class="mx-auto h-14 w-14 bg-primary-100 dark:bg-primary-900/20 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-graduation-cap text-4xl text-primary-600 dark:text-primary-400"></i>
                                </div>
                                
                            </div>
                            <!-- Tabs under branding -->
                            <div class="mt-4 grid grid-cols-3 gap-2">
                                <button class="tab-button active border border-transparent bg-white dark:bg-gray-800 rounded-md p-2 shadow-sm hover:shadow transition-all duration-200 inline-flex items-center justify-center w-full gap-2 text-gray-900 dark:text-white" 
                                        id="password-tab" data-target="#password-login">
                                    <div class="h-6 w-6 bg-primary-100 dark:bg-primary-900/20 rounded-md flex items-center justify-center mr-2">
                                        <i class="fas fa-key text-sm text-primary-600 dark:text-primary-400"></i>
                                    </div>
                                    <span class="font-medium text-xs">Login with Password</span>
                                </button>
                                <button class="tab-button border border-transparent bg-white dark:bg-gray-800 rounded-md p-2 shadow-sm hover:shadow transition-all duration-200 inline-flex items-center justify-center w-full gap-2 text-gray-900 dark:text-white" 
                                        id="matric-tab" data-target="#matric-verification">
                                    <div class="h-6 w-6 bg-primary-100 dark:bg-primary-900/20 rounded-md flex items-center justify-center mr-2">
                                        <i class="fas fa-id-card text-sm text-primary-600 dark:text-primary-400"></i>
                                    </div>
                                    <span class="font-medium text-xs">I Know My Matric Number</span>
                                </button>
                                <button class="tab-button border border-transparent bg-white dark:bg-gray-800 rounded-md p-2 shadow-sm hover:shadow transition-all duration-200 inline-flex items-center justify-center w-full gap-2 text-gray-900 dark:text-white" 
                                        id="security-tab" data-target="#security-questions">
                                    <div class="h-6 w-6 bg-primary-100 dark:bg-primary-900/20 rounded-md flex items-center justify-center mr-2">
                                        <i class="fas fa-question-circle text-sm text-primary-600 dark:text-primary-400"></i>
                                    </div>
                                    <span class="font-medium text-xs">Can't Remember Matric Number?</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Branding Section (Mobile - shown under content) with tabs underneath -->
                <div class="md:hidden mt-8">
                    <div class="bg-gray-50 dark:bg-gray-50 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                        <div class="text-center text-gray-800 dark:text-gray-800">
                            <div class="mb-6">
                                <div class="mx-auto h-12 w-12 bg-primary-100 dark:bg-primary-900/20 rounded-full flex items-center justify-center mb-2">
                                    <i class="fas fa-graduation-cap text-xl text-primary-600 dark:text-primary-400"></i>
                                </div>
                            </div>
                            <!-- Tabs under branding (mobile) -->
                            <div class="mt-2 grid grid-cols-3 gap-1.5 text-center">
                                <button class="tab-button active border border-transparent bg-white dark:bg-gray-800 rounded-md p-2 shadow-sm hover:shadow transition-all duration-200 inline-flex items-center justify-center w-full gap-2 text-gray-900 dark:text-white" 
                                        id="password-tab" data-target="#password-login">
                                    <div class="h-6 w-6 bg-primary-100 dark:bg-primary-900/20 rounded-md flex items-center justify-center mr-2">
                                        <i class="fas fa-key text-sm text-primary-600 dark:text-primary-400"></i>
                                    </div>
                                    <span class="font-medium text-xs">Login with Password</span>
                                </button>
                                <button class="tab-button border border-transparent bg-white dark:bg-gray-800 rounded-md p-2 shadow-sm hover:shadow transition-all duration-200 inline-flex items-center justify-center w-full gap-2 text-gray-900 dark:text-white" 
                                        id="matric-tab" data-target="#matric-verification">
                                    <div class="h-6 w-6 bg-primary-100 dark:bg-primary-900/20 rounded-md flex items-center justify-center mr-2">
                                        <i class="fas fa-id-card text-sm text-primary-600 dark:text-primary-400"></i>
                                    </div>
                                    <span class="font-medium text-xs">I Know My Matric Number</span>
                                </button>
                                <button class="tab-button border border-transparent bg-white dark:bg-gray-800 rounded-md p-2 shadow-sm hover:shadow transition-all duration-200 inline-flex items-center justify-center w-full gap-2 text-gray-900 dark:text-white" 
                                        id="security-tab" data-target="#security-questions">
                                    <div class="h-6 w-6 bg-primary-100 dark:bg-primary-900/20 rounded-md flex items-center justify-center mr-2">
                                        <i class="fas fa-question-circle text-sm text-primary-600 dark:text-primary-400"></i>
                                    </div>
                                    <span class="font-medium text-xs">Can't Remember Matric Number?</span>
                                </button>
                            </div>
                        </div>
                    </div>
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