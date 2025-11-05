<?php $__env->startSection('title', 'Staff Login - Transcript System'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl w-full">
        <!-- Theme Toggle -->
        <div class="flex justify-end mb-4">
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
        <div class="bg-white dark:bg-gray-50 rounded-2xl shadow-2xl overflow-hidden">
            <div class="grid md:grid-cols-2">
                <!-- Login Form Section -->
                <div class="p-8 lg:p-12">
                    <!-- Quick Student Login Link -->
                    <div class="flex justify-end mb-4">
                        <a href="<?php echo e(route('student.login')); ?>"
                           class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 hover:text-gray-900 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white shadow-sm">
                            <i class="fas fa-user-graduate text-sm"></i>
                            <span class="text-sm">Student Login</span>
                        </a>
                    </div>
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <div class="mx-auto h-16 w-16 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mb-4 border border-primary-200 dark:border-primary-700">
                            <i class="fas fa-user-tie text-primary-600 dark:text-primary-400 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-800">Staff Portal</h2>
                        <p class="text-gray-600 dark:text-gray-700 mt-2">Access the Transcript Management System</p>
                    </div>

                    <!-- Display Status Messages -->
                    <?php if(session('status')): ?>
                        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-400 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-green-800 font-medium">Success</p>
                                <p class="text-green-700 text-sm mt-1"><?php echo e(session('status')); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($errors->any()): ?>
                        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4 flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-red-400 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-red-800 font-medium">Login Failed!</p>
                                <p class="text-red-700 text-sm mt-1">Please check your credentials and try again.</p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('transcript.staff.login.submit')); ?>" class="space-y-6" id="staffLoginForm">
                        <?php echo csrf_field(); ?>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-envelope mr-2 text-gray-400 dark:text-gray-500"></i>Email Address
                            </label>
                            <input type="email" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-400 dark:bg-gray-50 dark:text-gray-800 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors <?php $__errorArgs = ['email'];
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
                                   autocomplete="email" 
                                   autofocus 
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
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-lock mr-2 text-gray-400 dark:text-gray-500"></i>Password
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-gray-400 dark:bg-gray-50 dark:text-gray-800 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors <?php $__errorArgs = ['password'];
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
                                       autocomplete="current-password" 
                                       placeholder="Enter your password">
                                <button type="button" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300" 
                                        id="togglePassword">
                                    <i class="fas fa-eye"></i>
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
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-400 dark:bg-gray-50 rounded" 
                                   id="remember" 
                                   name="remember" 
                                   <?php echo e(old('remember') ? 'checked' : ''); ?>>
                            <label for="remember" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Remember me
                            </label>
                        </div>

                        <div>
                            <button type="submit" 
                                    class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200" 
                                    id="loginBtn">
                                <span class="hidden animate-spin mr-2" id="loginSpinner">
                                    <i class="fas fa-spinner"></i>
                                </span>
                                <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Having trouble? Contact your system administrator.
                        </p>
                    </div>
                </div>

                <!-- Branding Section -->
                <div class="hidden md:block bg-gray-50 dark:bg-gray-50 relative overflow-hidden">
                    <div class="relative z-10 h-full flex items-center justify-center p-8 lg:p-12">
                        <div class="text-center text-gray-800 dark:text-gray-800">
                            <div class="mb-8">
                                <div class="mx-auto h-24 w-24 bg-primary-100 dark:bg-primary-900/20 rounded-full flex items-center justify-center mb-6">
                                    <i class="fas fa-graduation-cap text-4xl text-primary-600 dark:text-primary-400"></i>
                                </div>
                                <h3 class="text-3xl font-bold mb-4">Transcript Management System</h3>
                                <p class="text-lg text-gray-600 dark:text-gray-700 leading-relaxed">
                                    Secure access for authorized staff members to manage student transcripts, 
                                    process applications, and handle administrative tasks.
                                </p>
                            </div>
                            
                            <div class="grid grid-cols-3 gap-6 mt-8">
                                <div class="text-center">
                                    <div class="mx-auto h-12 w-12 bg-primary-100 dark:bg-primary-900/20 rounded-lg flex items-center justify-center mb-3">
                                        <i class="fas fa-shield-alt text-xl text-primary-600 dark:text-primary-400"></i>
                                    </div>
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-800">Secure</p>
                                </div>
                                <div class="text-center">
                                    <div class="mx-auto h-12 w-12 bg-primary-100 dark:bg-primary-900/20 rounded-lg flex items-center justify-center mb-3">
                                        <i class="fas fa-users text-xl text-primary-600 dark:text-primary-400"></i>
                                    </div>
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-800">Role-Based</p>
                                </div>
                                <div class="text-center">
                                    <div class="mx-auto h-12 w-12 bg-primary-100 dark:bg-primary-900/20 rounded-lg flex items-center justify-center mb-3">
                                        <i class="fas fa-clock text-xl text-primary-600 dark:text-primary-400"></i>
                                    </div>
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-800">Efficient</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle the eye icon
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }

    // Form submission handling
    const form = document.getElementById('staffLoginForm');
    const loginBtn = document.getElementById('loginBtn');
    
    if (form && loginBtn) {
        form.addEventListener('submit', function() {
            loginBtn.disabled = true;
            const spinner = document.getElementById('loginSpinner');
            const icon = loginBtn.querySelector('.fas.fa-sign-in-alt');
            
            if (spinner) {
                spinner.classList.remove('hidden');
            }
            if (icon) {
                icon.classList.add('hidden');
            }
            
            // Update button text
            const textNode = loginBtn.childNodes[loginBtn.childNodes.length - 1];
            if (textNode && textNode.nodeType === Node.TEXT_NODE) {
                textNode.textContent = 'Signing In...';
            }
        });
    }

    // Add smooth focus transitions
    const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-blue-500');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-blue-500');
        });
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Veritas ICT\Downloads\trans\transcript-system\resources\views/transcript/staff/auth/login.blade.php ENDPATH**/ ?>