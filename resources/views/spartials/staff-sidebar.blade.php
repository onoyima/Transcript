<!-- Sidebar -->
<aside
    :class="sidebarToggle ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    class="absolute left-0 top-0 z-40 flex h-screen w-72.5 flex-col overflow-y-hidden bg-white/95 backdrop-blur-md border-r border-gray-200/50 duration-300 ease-linear dark:bg-gray-900/95 dark:border-gray-700/50 lg:static shadow-xl"
    @click.outside="sidebarToggle = false">
    
    <!-- SIDEBAR HEADER -->
    <div class="flex items-center justify-between gap-2 px-6 py-5.5 lg:py-6.5 border-b border-gray-200/50 dark:border-gray-700/50">
        <a href="{{ route('transcript.staff.dashboard') }}" class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-graduation-cap text-white text-lg"></i>
            </div>
            <div>
                <span class="font-bold text-gray-900 dark:text-white text-xl">Veritas</span>
                <span class="block text-xs text-green-600 dark:text-green-400 font-medium">Staff Portal</span>
            </div>
        </a>

        <button
            class="block lg:hidden rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-300 transition-all duration-200"
            @click.stop="sidebarToggle = !sidebarToggle">
            <svg class="fill-current" width="20" height="18" viewBox="0 0 20 18" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M19 8.175H2.98748L9.36248 1.6875C9.69998 1.35 9.69998 0.825 9.36248 0.4875C9.02498 0.15 8.49998 0.15 8.16248 0.4875L0.399976 8.3625C0.0624756 8.7 0.0624756 9.225 0.399976 9.5625L8.16248 17.4375C8.31248 17.5875 8.53748 17.7 8.76248 17.7C8.98748 17.7 9.17498 17.625 9.36248 17.475C9.69998 17.1375 9.69998 16.6125 9.36248 16.275L3.02498 9.8625H19C19.45 9.8625 19.825 9.4875 19.825 9.0375C19.825 8.55 19.45 8.175 19 8.175Z"
                    fill="" />
            </svg>
        </button>
    </div>
    <!-- SIDEBAR HEADER -->

    <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
        <!-- Sidebar Menu -->
        <nav class="mt-5 py-4 px-4 lg:mt-9 lg:px-6">
            <!-- Menu Group -->
            <div>
                <h3 class="mb-4 ml-4 text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    MAIN MENU
                </h3>

                <ul class="mb-6 flex flex-col gap-1.5">
                    <!-- Dashboard -->
                    <li>
                        <a class="group relative flex items-center gap-3 rounded-xl py-3 px-4 font-medium text-gray-700 duration-300 ease-in-out hover:bg-green-50 hover:text-green-700 dark:text-gray-300 dark:hover:bg-green-900/20 dark:hover:text-green-400 {{ request()->routeIs('transcript.staff.dashboard') ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400' : '' }}"
                            href="{{ route('transcript.staff.dashboard') }}">
                            <i class="fas fa-tachometer-alt text-lg {{ request()->routeIs('transcript.staff.dashboard') ? 'text-green-600 dark:text-green-400' : 'text-gray-500 group-hover:text-green-600 dark:text-gray-400 dark:group-hover:text-green-400' }}"></i>
                            Dashboard
                        </a>
                    </li>
                    <!-- Dashboard -->

                    <!-- Applications -->
                    @if(Auth::guard('transcript_staff')->user() && Auth::guard('transcript_staff')->user()->hasPermission('view_transcript_applications'))
                    <li>
                        <a class="group relative flex items-center gap-3 rounded-xl py-3 px-4 font-medium text-gray-700 duration-300 ease-in-out hover:bg-green-50 hover:text-green-700 dark:text-gray-300 dark:hover:bg-green-900/20 dark:hover:text-green-400 {{ request()->routeIs('transcript.staff.applications*') ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400' : '' }}"
                            href="{{ route('transcript.staff.applications') }}">
                            <i class="fas fa-file-alt text-lg {{ request()->routeIs('transcript.staff.applications*') ? 'text-green-600 dark:text-green-400' : 'text-gray-500 group-hover:text-green-600 dark:text-gray-400 dark:group-hover:text-green-400' }}"></i>
                            Applications
                            @if(isset($pendingApplicationsCount) && $pendingApplicationsCount > 0)
                                <span class="ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                                    {{ $pendingApplicationsCount }}
                                </span>
                            @endif
                        </a>
                    </li>
                    @endif
                    <!-- Applications -->

                    <!-- Payments -->
                    @if(Auth::guard('transcript_staff')->user() && Auth::guard('transcript_staff')->user()->hasPermission('view_transcript_payments'))
                    <li>
                        <a class="group relative flex items-center gap-3 rounded-xl py-3 px-4 font-medium text-gray-700 duration-300 ease-in-out hover:bg-green-50 hover:text-green-700 dark:text-gray-300 dark:hover:bg-green-900/20 dark:hover:text-green-400 {{ request()->routeIs('transcript.staff.payments*') ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400' : '' }}"
                            href="{{ route('transcript.staff.payments') }}">
                            <i class="fas fa-credit-card text-lg {{ request()->routeIs('transcript.staff.payments*') ? 'text-green-600 dark:text-green-400' : 'text-gray-500 group-hover:text-green-600 dark:text-gray-400 dark:group-hover:text-green-400' }}"></i>
                            Payments
                        </a>
                    </li>
                    @endif
                    <!-- Payments -->

                    <!-- Refunds -->
                    @if(Auth::guard('transcript_staff')->user() && Auth::guard('transcript_staff')->user()->hasPermission('process_transcript_refunds'))
                    <li>
                        <a class="group relative flex items-center gap-3 rounded-xl py-3 px-4 font-medium text-gray-700 duration-300 ease-in-out hover:bg-green-50 hover:text-green-700 dark:text-gray-300 dark:hover:bg-green-900/20 dark:hover:text-green-400 {{ request()->routeIs('transcript.staff.refunds*') ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400' : '' }}"
                            href="#">
                            <i class="fas fa-undo text-lg {{ request()->routeIs('transcript.staff.refunds*') ? 'text-green-600 dark:text-green-400' : 'text-gray-500 group-hover:text-green-600 dark:text-gray-400 dark:group-hover:text-green-400' }}"></i>
                            Refunds
                        </a>
                    </li>
                    @endif
                    <!-- Refunds -->

                    <!-- Students -->
                    @if(Auth::guard('transcript_staff')->user() && Auth::guard('transcript_staff')->user()->hasPermission('view_transcript_applications'))
                    <li>
                        <a class="group relative flex items-center gap-3 rounded-xl py-3 px-4 font-medium text-gray-700 duration-300 ease-in-out hover:bg-green-50 hover:text-green-700 dark:text-gray-300 dark:hover:bg-green-900/20 dark:hover:text-green-400 {{ request()->routeIs('transcript.staff.students*') ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400' : '' }}"
                            href="#">
                            <i class="fas fa-users text-lg {{ request()->routeIs('transcript.staff.students*') ? 'text-green-600 dark:text-green-400' : 'text-gray-500 group-hover:text-green-600 dark:text-gray-400 dark:group-hover:text-green-400' }}"></i>
                            Students
                        </a>
                    </li>
                    @endif
                    <!-- Students -->

                    <!-- Staff Management -->
                    @if(Auth::guard('transcript_staff')->user() && Auth::guard('transcript_staff')->user()->hasPermission('manage_transcript_staff'))
                    <li>
                        <a class="group relative flex items-center gap-3 rounded-xl py-3 px-4 font-medium text-gray-700 duration-300 ease-in-out hover:bg-green-50 hover:text-green-700 dark:text-gray-300 dark:hover:bg-green-900/20 dark:hover:text-green-400 {{ request()->routeIs('transcript.staff.manage*') ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400' : '' }}"
                            href="{{ route('transcript.staff.manage') }}">
                            <i class="fas fa-user-tie text-lg {{ request()->routeIs('transcript.staff.manage*') ? 'text-green-600 dark:text-green-400' : 'text-gray-500 group-hover:text-green-600 dark:text-gray-400 dark:group-hover:text-green-400' }}"></i>
                            Staff Management
                        </a>
                    </li>
                    @endif
                    <!-- Staff Management -->

                    <!-- Admin Dashboard -->
                    @if(Auth::guard('transcript_staff')->user() && (Auth::guard('transcript_staff')->user()->hasRole('transcript_admin') || Auth::guard('transcript_staff')->user()->hasRole('transcript_supervisor')))
                    <li>
                        <a class="group relative flex items-center gap-3 rounded-xl py-3 px-4 font-medium text-gray-700 duration-300 ease-in-out hover:bg-green-50 hover:text-green-700 dark:text-gray-300 dark:hover:bg-green-900/20 dark:hover:text-green-400 {{ request()->routeIs('transcript.staff.admin*') ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400' : '' }}"
                            href="{{ route('transcript.staff.admin.dashboard') }}">
                            <i class="fas fa-cogs text-lg {{ request()->routeIs('transcript.staff.admin*') ? 'text-green-600 dark:text-green-400' : 'text-gray-500 group-hover:text-green-600 dark:text-gray-400 dark:group-hover:text-green-400' }}"></i>
                            Admin Dashboard
                        </a>
                    </li>
                    @endif
                    <!-- Admin Dashboard -->

                    <!-- Reports -->
                    @if(Auth::guard('transcript_staff')->user() && Auth::guard('transcript_staff')->user()->hasPermission('generate_transcript_reports'))
                    <li>
                        <a class="group relative flex items-center gap-3 rounded-xl py-3 px-4 font-medium text-gray-700 duration-300 ease-in-out hover:bg-green-50 hover:text-green-700 dark:text-gray-300 dark:hover:bg-green-900/20 dark:hover:text-green-400 {{ request()->routeIs('transcript.staff.reports*') ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400' : '' }}"
                            href="{{ route('transcript.staff.reports') }}">
                            <i class="fas fa-chart-bar text-lg {{ request()->routeIs('transcript.staff.reports*') ? 'text-green-600 dark:text-green-400' : 'text-gray-500 group-hover:text-green-600 dark:text-gray-400 dark:group-hover:text-green-400' }}"></i>
                            Reports
                        </a>
                    </li>
                    @endif
                    <!-- Reports -->

                    <!-- Payment Reports -->
                    @if(Auth::guard('transcript_staff')->user() && Auth::guard('transcript_staff')->user()->hasPermission('generate_payment_reports'))
                    <li>
                        <a class="group relative flex items-center gap-3 rounded-xl py-3 px-4 font-medium text-gray-700 duration-300 ease-in-out hover:bg-green-50 hover:text-green-700 dark:text-gray-300 dark:hover:bg-green-900/20 dark:hover:text-green-400 {{ request()->routeIs('transcript.staff.payment-reports*') ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400' : '' }}"
                            href="#">
                            <i class="fas fa-file-invoice-dollar text-lg {{ request()->routeIs('transcript.staff.payment-reports*') ? 'text-green-600 dark:text-green-400' : 'text-gray-500 group-hover:text-green-600 dark:text-gray-400 dark:group-hover:text-green-400' }}"></i>
                            Payment Reports
                        </a>
                    </li>
                    @endif
                    <!-- Payment Reports -->

                    <!-- Analytics -->
                    @if(Auth::guard('transcript_staff')->user() && Auth::guard('transcript_staff')->user()->hasPermission('view_transcript_analytics'))
                    <li>
                        <a class="group relative flex items-center gap-3 rounded-xl py-3 px-4 font-medium text-gray-700 duration-300 ease-in-out hover:bg-green-50 hover:text-green-700 dark:text-gray-300 dark:hover:bg-green-900/20 dark:hover:text-green-400 {{ request()->routeIs('transcript.staff.analytics*') ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400' : '' }}"
                            href="#">
                            <i class="fas fa-analytics text-lg {{ request()->routeIs('transcript.staff.analytics*') ? 'text-green-600 dark:text-green-400' : 'text-gray-500 group-hover:text-green-600 dark:text-gray-400 dark:group-hover:text-green-400' }}"></i>
                            Analytics
                        </a>
                    </li>
                    @endif
                    <!-- Analytics -->
                </ul>
            </div>

            <!-- Settings Group -->
            <div>
                <h3 class="mb-4 ml-4 text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    SETTINGS
                </h3>

                <ul class="mb-6 flex flex-col gap-1.5">
                    <!-- Profile -->
                    <li>
                        <a class="group relative flex items-center gap-3 rounded-xl py-3 px-4 font-medium text-gray-700 duration-300 ease-in-out hover:bg-green-50 hover:text-green-700 dark:text-gray-300 dark:hover:bg-green-900/20 dark:hover:text-green-400 {{ request()->routeIs('transcript.staff.profile*') ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400' : '' }}"
                            href="{{ route('transcript.staff.profile') }}">
                            <i class="fas fa-user text-lg {{ request()->routeIs('transcript.staff.profile*') ? 'text-green-600 dark:text-green-400' : 'text-gray-500 group-hover:text-green-600 dark:text-gray-400 dark:group-hover:text-green-400' }}"></i>
                            My Profile
                        </a>
                    </li>
                    <!-- Profile -->

                    <!-- System Settings -->
                    @if(Auth::guard('transcript_staff')->user() && Auth::guard('transcript_staff')->user()->hasPermission('manage_transcript_system'))
                    <li>
                        <a class="group relative flex items-center gap-3 rounded-xl py-3 px-4 font-medium text-gray-700 duration-300 ease-in-out hover:bg-green-50 hover:text-green-700 dark:text-gray-300 dark:hover:bg-green-900/20 dark:hover:text-green-400 {{ request()->routeIs('transcript.staff.settings*') ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400' : '' }}"
                            href="#">
                            <i class="fas fa-cog text-lg {{ request()->routeIs('transcript.staff.settings*') ? 'text-green-600 dark:text-green-400' : 'text-gray-500 group-hover:text-green-600 dark:text-gray-400 dark:group-hover:text-green-400' }}"></i>
                            Settings
                        </a>
                    </li>
                    @endif
                    <!-- System Settings -->

                    <!-- Security Management -->
                    @if(Auth::guard('transcript_staff')->user() && Auth::guard('transcript_staff')->user()->hasPermission('manage_transcript_security'))
                    <li>
                        <a class="group relative flex items-center gap-3 rounded-xl py-3 px-4 font-medium text-gray-700 duration-300 ease-in-out hover:bg-green-50 hover:text-green-700 dark:text-gray-300 dark:hover:bg-green-900/20 dark:hover:text-green-400 {{ request()->routeIs('transcript.staff.security*') ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400' : '' }}"
                            href="#">
                            <i class="fas fa-shield-alt text-lg {{ request()->routeIs('transcript.staff.security*') ? 'text-green-600 dark:text-green-400' : 'text-gray-500 group-hover:text-green-600 dark:text-gray-400 dark:group-hover:text-green-400' }}"></i>
                            Security
                        </a>
                    </li>
                    @endif
                    <!-- Security Management -->
                </ul>
            </div>
        </nav>
        <!-- Sidebar Menu -->

        <!-- Staff Info Card -->
        @auth('transcript_staff')
        @php
            $staff = Auth::guard('transcript_staff')->user();
        @endphp
        <div class="mx-4 mb-4 mt-auto">
            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-4 border border-green-200/50 dark:border-green-700/50">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-green-200 dark:border-green-700">
                        @if($staff->passport_url)
                            <img src="{{ $staff->passport_url }}" alt="Profile Photo" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">
                                    {{ strtoupper(substr($staff->fname, 0, 1) . substr($staff->lname, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                            {{ $staff->fname }} {{ $staff->lname }}
                        </p>
                        <p class="text-xs text-green-600 dark:text-green-400">
                            {{ $staff->title ?? 'Staff Member' }}
                        </p>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <a href="{{ route('transcript.staff.profile') }}" 
                       class="text-xs text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 font-medium transition-colors duration-200">
                        View Profile
                    </a>
                    <form method="POST" action="{{ route('transcript.staff.logout') }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="text-xs text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 font-medium transition-colors duration-200">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endauth
        <!-- Staff Info Card -->
    </div>
</aside>