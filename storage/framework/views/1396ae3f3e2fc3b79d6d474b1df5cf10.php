<!-- Staff Top Navigation Bar -->
<nav class="bg-white shadow-lg border-b border-gray-200 fixed w-full z-30 top-0">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <!-- Mobile menu button -->
                <button id="staff-sidebar-toggle" 
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                    </svg>
                </button>
                
                <!-- Breadcrumb -->
                <div class="hidden lg:flex lg:items-center lg:ml-6">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="<?php echo e(route('transcript.staff.dashboard')); ?>" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                    <i class="fas fa-home mr-2"></i>
                                    Dashboard
                                </a>
                            </li>
                            <?php if(!request()->routeIs('transcript.staff.dashboard')): ?>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">
                                        <?php if(request()->routeIs('transcript.staff.applications*')): ?>
                                            Applications
                                        <?php elseif(request()->routeIs('transcript.staff.payments*')): ?>
                                            Payments
                                        <?php elseif(request()->routeIs('transcript.staff.students*')): ?>
                                            Students
                                        <?php elseif(request()->routeIs('transcript.staff.manage*')): ?>
                                            Staff Management
                                        <?php elseif(request()->routeIs('transcript.staff.settings*')): ?>
                                            Settings
                                        <?php elseif(request()->routeIs('transcript.staff.reports*')): ?>
                                            Reports
                                        <?php else: ?>
                                            <?php echo e(ucfirst(request()->segment(2))); ?>

                                        <?php endif; ?>
                                    </span>
                                </div>
                            </li>
                            <?php endif; ?>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Right side of navbar -->
            <div class="flex items-center">
                <!-- Notifications -->
                <div class="relative mr-3">
                    <button type="button" 
                            class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300" 
                            id="notification-menu-button" 
                            aria-expanded="false" 
                            data-dropdown-toggle="notification-dropdown">
                        <span class="sr-only">View notifications</span>
                        <div class="relative">
                            <i class="fas fa-bell text-gray-600 text-lg p-2"></i>
                            <!-- Notification badge -->
                            <div class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                                3
                            </div>
                        </div>
                    </button>
                    
                    <!-- Notification dropdown -->
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow" 
                         id="notification-dropdown">
                        <div class="px-4 py-3">
                            <p class="text-sm text-gray-900">Notifications</p>
                        </div>
                        <ul class="py-1" role="none">
                            <li>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-file-alt text-blue-500"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium">New application submitted</p>
                                            <p class="text-xs text-gray-500">2 minutes ago</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-credit-card text-green-500"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium">Payment received</p>
                                            <p class="text-xs text-gray-500">1 hour ago</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium">System maintenance scheduled</p>
                                            <p class="text-xs text-gray-500">3 hours ago</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View all notifications</a>
                        </div>
                    </div>
                </div>

                <!-- Dark mode toggle -->
                <button id="theme-toggle" type="button" 
                        class="text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 rounded-lg text-sm p-2.5 mr-3">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </button>

                <!-- User menu -->
                <div class="relative">
                    <button type="button" 
                            class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300" 
                            id="user-menu-button" 
                            aria-expanded="false" 
                            data-dropdown-toggle="user-dropdown">
                        <span class="sr-only">Open user menu</span>
                        <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center">
                            <span class="text-sm font-medium text-white">
                                <?php echo e(substr(auth('transcript_staff')->user()->first_name, 0, 1)); ?><?php echo e(substr(auth('transcript_staff')->user()->last_name, 0, 1)); ?>

                            </span>
                        </div>
                    </button>
                    
                    <!-- User dropdown -->
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow" 
                         id="user-dropdown">
                        <div class="px-4 py-3">
                            <p class="text-sm text-gray-900"><?php echo e(auth('transcript_staff')->user()->first_name); ?> <?php echo e(auth('transcript_staff')->user()->last_name); ?></p>
                        <p class="text-sm font-medium text-gray-500 truncate"><?php echo e(auth('transcript_staff')->user()->email); ?></p>
                        <p class="text-xs text-gray-400"><?php echo e(auth('transcript_staff')->user()->roles->pluck('name')->join(', ')); ?></p>
                        </div>
                        <ul class="py-1" role="none">
                            <li>
                                <a href="<?php echo e(route('transcript.staff.profile')); ?>" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i>Profile
                                </a>
                            </li>
                            <li>
                                <a href="#" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i>Settings
                                </a>
                            </li>
                            <li>
                                <a href="#" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-question-circle mr-2"></i>Help
                                </a>
                            </li>
                        </ul>
                        <div class="py-1">
                            <form method="POST" action="<?php echo e(route('transcript.staff.logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" 
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Theme toggle functionality
    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

    // Change the icons inside the button based on previous settings
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        themeToggleLightIcon.classList.remove('hidden');
    } else {
        themeToggleDarkIcon.classList.remove('hidden');
    }

    themeToggleBtn.addEventListener('click', function() {
        // toggle icons inside button
        themeToggleDarkIcon.classList.toggle('hidden');
        themeToggleLightIcon.classList.toggle('hidden');

        // if set via local storage previously
        if (localStorage.getItem('color-theme')) {
            if (localStorage.getItem('color-theme') === 'light') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            }
        } else {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        }
    });

    // Dropdown functionality
    const userMenuButton = document.getElementById('user-menu-button');
    const userDropdown = document.getElementById('user-dropdown');
    const notificationMenuButton = document.getElementById('notification-menu-button');
    const notificationDropdown = document.getElementById('notification-dropdown');

    function toggleDropdown(button, dropdown) {
        dropdown.classList.toggle('hidden');
        const expanded = button.getAttribute('aria-expanded') === 'true';
        button.setAttribute('aria-expanded', !expanded);
    }

    if (userMenuButton && userDropdown) {
        userMenuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleDropdown(userMenuButton, userDropdown);
            if (!notificationDropdown.classList.contains('hidden')) {
                notificationDropdown.classList.add('hidden');
            }
        });
    }

    if (notificationMenuButton && notificationDropdown) {
        notificationMenuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleDropdown(notificationMenuButton, notificationDropdown);
            if (!userDropdown.classList.contains('hidden')) {
                userDropdown.classList.add('hidden');
            }
        });
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function() {
        if (userDropdown && !userDropdown.classList.contains('hidden')) {
            userDropdown.classList.add('hidden');
            userMenuButton.setAttribute('aria-expanded', 'false');
        }
        if (notificationDropdown && !notificationDropdown.classList.contains('hidden')) {
            notificationDropdown.classList.add('hidden');
            notificationMenuButton.setAttribute('aria-expanded', 'false');
        }
    });
});
</script><?php /**PATH C:\Users\Veritas ICT\Downloads\trans\transcript-system\resources\views/spartials/navbar.blade.php ENDPATH**/ ?>