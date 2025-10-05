<aside :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
    class="sidebar fixed top-0 left-0 z-50 flex h-screen w-[290px] flex-col border-r border-gray-200/50 bg-white/95 backdrop-blur-xl px-5 transition-all duration-300 lg:static lg:translate-x-0 dark:border-gray-700/50 dark:bg-gray-900/95 shadow-xl"
    @click.outside="sidebarToggle = false">
    <!-- SIDEBAR HEADER -->
    <div :class="sidebarToggle ? 'justify-center' : 'justify-between'"
        class="sidebar-header flex items-center gap-2 pt-6 pb-6 border-b border-gray-100 dark:border-gray-800">
        <a href="<?php echo e(route('student.dashboard')); ?>" class="flex items-center space-x-3 group">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                    <i class="fas fa-graduation-cap text-white text-lg"></i>
                </div>
            </div>
            <span class="logo font-bold text-xl text-gray-900 dark:text-white" :class="sidebarToggle ? 'lg:hidden' : ''">
                Veritas
            </span>
        </a>
    </div>
    <!-- SIDEBAR HEADER -->

    <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear py-4">
        <!-- Sidebar Menu -->
        <nav x-data="{ selected: $persist('<?php echo e(request()->routeIs('student.dashboard') ? 'Dashboard' : (request()->routeIs('student.profile') ? 'Profile' : (request()->routeIs('student.transcript.*') ? 'Transcript' : 'Dashboard'))); ?>') }" class="space-y-2">
            <!-- Menu Group -->
            <div>
                <h3 class="mb-4 px-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    <span class="menu-group-title" :class="sidebarToggle ? 'lg:hidden' : ''">
                        Student Portal
                    </span>
                    <div :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
                        class="menu-group-icon mx-auto w-6 h-6 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-ellipsis-h text-gray-500 dark:text-gray-400 text-xs"></i>
                    </div>
                </h3>

                <ul class="space-y-1">
                    <!-- Menu Item Dashboard -->
                    <li>
                        <a href="<?php echo e(route('student.dashboard')); ?>"
                            class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 hover:bg-gray-50 dark:hover:bg-gray-800/50 <?php echo e(request()->routeIs('student.dashboard') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white'); ?>">
                            <div class="flex-shrink-0 w-6 h-6 mr-3 flex items-center justify-center">
                                <i class="fas fa-home text-current"></i>
                            </div>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Dashboard
                            </span>
                        </a>
                    </li>

                    <!-- Menu Item Dashboard -->

                    <!-- Menu Item Profile -->
                    <li>
                        <a href="<?php echo e(route('student.profile')); ?>"
                            class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 hover:bg-gray-50 dark:hover:bg-gray-800/50 <?php echo e(request()->routeIs('student.profile') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white'); ?>">
                            <div class="flex-shrink-0 w-6 h-6 mr-3 flex items-center justify-center">
                                <i class="fas fa-user text-current"></i>
                            </div>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                My Profile
                            </span>
                        </a>
                    </li>
                    <!-- Menu Item Profile -->

                    <!-- Menu Item New Application -->
                    <li>
                        <a href="<?php echo e(route('student.transcript.create')); ?>"
                            class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 hover:bg-gray-50 dark:hover:bg-gray-800/50 <?php echo e(request()->routeIs('student.transcript.create') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white'); ?>">
                            <div class="flex-shrink-0 w-6 h-6 mr-3 flex items-center justify-center">
                                <i class="fas fa-plus-circle text-current"></i>
                            </div>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                New Application
                            </span>
                        </a>
                    </li>
                    <!-- Menu Item New Application -->

                    <!-- Menu Item Application History -->
                    <li>
                        <a href="<?php echo e(route('student.transcript.history')); ?>"
                            class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 hover:bg-gray-50 dark:hover:bg-gray-800/50 <?php echo e(request()->routeIs('student.transcript.history') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white'); ?>">
                            <div class="flex-shrink-0 w-6 h-6 mr-3 flex items-center justify-center">
                                <i class="fas fa-history text-current"></i>
                            </div>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Application History
                            </span>
                        </a>
                    </li>
                    <!-- Menu Item Application History -->

                    <!-- Menu Item Payment History -->
                    <li>
                        <a href="<?php echo e(route('student.payments')); ?>"
                            class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 hover:bg-gray-50 dark:hover:bg-gray-800/50 <?php echo e(request()->routeIs('student.payments') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white'); ?>">
                            <div class="flex-shrink-0 w-6 h-6 mr-3 flex items-center justify-center">
                                <i class="fas fa-credit-card text-current"></i>
                            </div>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Payment History
                            </span>
                        </a>
                    </li>
                    <!-- Menu Item Payment History -->

                 
                </ul>
            </div>

          
        </nav>
        <!-- Sidebar Menu -->

        <!-- Promo Box -->
        <div :class="sidebarToggle ? 'lg:hidden' : ''"
            class="mx-auto mt-auto mb-6 w-full rounded-2xl bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/20 dark:to-primary-800/20 px-4 py-6 text-center border border-primary-200/50 dark:border-primary-700/50">
            <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center mx-auto mb-3 shadow-lg">
                <i class="fas fa-university text-white text-lg"></i>
            </div>
            <h3 class="mb-2 font-bold text-gray-900 dark:text-white text-sm">
                Veritas University
            </h3>
            <p class="text-xs mb-4 text-gray-600 dark:text-gray-400">
                ICT Department - Transcript System
            </p>
            <a href="#" 
                class="bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-xs flex items-center justify-center rounded-lg px-4 py-2.5 font-medium text-white transition-all duration-200 shadow-lg hover:shadow-xl">
                <i class="fas fa-phone mr-2"></i>
                Contact Support
            </a>
        </div> 
        <!-- Promo Box -->
    </div>
</aside>
<?php /**PATH C:\Users\Veritas ICT\Downloads\trans\transcript-system\resources\views/partials/sidebar.blade.php ENDPATH**/ ?>