<!-- ===== Header Start ===== -->
<header class="sticky top-0 z-30 flex w-full bg-white border-b border-gray-200/50 shadow-sm dark:bg-gray-900 dark:border-gray-700/50">
    <div class="flex flex-grow items-center justify-between px-4 py-4 shadow-2 md:px-6 2xl:px-11">
        <div class="flex items-center gap-2 sm:gap-4 lg:hidden">
            <!-- Hamburger Toggle BTN -->
            <button
                class="z-50 block rounded-lg border border-gray-200 bg-white p-2 shadow-sm hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 lg:hidden"
                @click.stop="sidebarToggle = !sidebarToggle">
                <span class="relative block h-5.5 w-5.5 cursor-pointer">
                    <span class="du-block absolute right-0 h-full w-full">
                        <span
                            class="relative left-0 top-0 my-1 block h-0.5 w-0 rounded-sm bg-gray-600 delay-[0] duration-200 ease-in-out dark:bg-white"
                            :class="{ '!w-full delay-300': !sidebarToggle }"></span>
                        <span
                            class="relative left-0 top-0 my-1 block h-0.5 w-0 rounded-sm bg-gray-600 delay-150 duration-200 ease-in-out dark:bg-white"
                            :class="{ '!w-full delay-400': !sidebarToggle }"></span>
                        <span
                            class="relative left-0 top-0 my-1 block h-0.5 w-0 rounded-sm bg-gray-600 delay-200 duration-200 ease-in-out dark:bg-white"
                            :class="{ '!w-full delay-500': !sidebarToggle }"></span>
                    </span>
                    <span class="absolute right-0 h-full w-full rotate-45">
                        <span
                            class="absolute left-2.5 top-0 block h-full w-0.5 rounded-sm bg-gray-600 delay-300 duration-200 ease-in-out dark:bg-white"
                            :class="{ '!h-0 !delay-[0]': !sidebarToggle }"></span>
                        <span
                            class="delay-400 absolute left-0 top-2.5 block h-0.5 w-full rounded-sm bg-gray-600 duration-200 ease-in-out dark:bg-white"
                            :class="{ '!h-0 !delay-200': !sidebarToggle }"></span>
                    </span>
                </span>
            </button>
            <!-- Hamburger Toggle BTN -->

            <a class="block flex-shrink-0 lg:hidden" href="<?php echo e(route('transcript.staff.dashboard')); ?>">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
            <i class="fas fa-graduation-cap text-white text-sm"></i>
                    </div>
                    <span class="font-bold text-gray-900 dark:text-white">Veritas</span>
                </div>
            </a>
        </div>

        <div class="hidden sm:block">
            <div class="relative">
                <!-- Search Form -->
                <form action="#" method="GET" class="relative">
                    <button class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
                        <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M9.16666 3.33332C5.945 3.33332 3.33332 5.945 3.33332 9.16666C3.33332 12.3883 5.945 15 9.16666 15C12.3883 15 15 12.3883 15 9.16666C15 5.945 12.3883 3.33332 9.16666 3.33332ZM1.66666 9.16666C1.66666 5.02452 5.02452 1.66666 9.16666 1.66666C13.3088 1.66666 16.6667 5.02452 16.6667 9.16666C16.6667 13.3088 13.3088 16.6667 9.16666 16.6667C5.02452 16.6667 1.66666 13.3088 1.66666 9.16666Z"
                                fill="currentColor" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M13.2857 13.2857C13.6112 12.9603 14.1388 12.9603 14.4642 13.2857L18.0892 16.9107C18.4147 17.2362 18.4147 17.7638 18.0892 18.0892C17.7638 18.4147 17.2362 18.4147 16.9107 18.0892L13.2857 14.4642C12.9603 14.1388 12.9603 13.6112 13.2857 13.2857Z"
                                fill="currentColor" />
                        </svg>
                    </button>

                    <input type="text" name="search" placeholder="Search applications, students..."
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 pl-11 pr-4 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:ring-green-400 transition-all duration-200" />
                </form>
            </div>
        </div>

        <div class="flex items-center gap-3 2xsm:gap-7">
            <ul class="flex items-center gap-2 2xsm:gap-4">
                <!-- Notification Menu Area -->
                <li class="relative" x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false">
                    <a class="relative flex h-8.5 w-8.5 items-center justify-center rounded-full border border-gray-200 bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 transition-colors duration-200"
                        href="#" @click.prevent="dropdownOpen = ! dropdownOpen">
                        <span class="relative">
                            <svg class="fill-current text-gray-600 dark:text-gray-300" width="18" height="18" viewBox="0 0 18 18" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16.1999 14.9343L15.6374 14.0624C15.5249 13.8937 15.4687 13.7249 15.4687 13.528V7.67803C15.4687 6.01865 14.7655 4.47178 13.4718 3.31865C12.4312 2.39053 11.0812 1.7999 9.64678 1.6874V1.1249C9.64678 0.787402 9.36553 0.478027 8.9999 0.478027C8.63428 0.478027 8.35303 0.759277 8.35303 1.1249V1.65928C8.29678 1.65928 8.24053 1.65928 8.18428 1.6874C4.92178 2.05303 2.4749 4.66865 2.4749 7.79053V13.528C2.44678 13.8093 2.39053 13.9499 2.33428 14.0343L1.7999 14.9343C1.63115 15.2155 1.63115 15.553 1.7999 15.8343C1.96865 16.0874 2.2499 16.2562 2.55928 16.2562H8.38115V16.8749C8.38115 17.2124 8.6624 17.5218 9.02803 17.5218C9.36553 17.5218 9.6749 17.2405 9.6749 16.8749V16.2562H15.4687C15.778 16.2562 16.0593 16.0874 16.228 15.8343C16.3968 15.553 16.3968 15.2155 16.1999 14.9343ZM3.23428 14.9905L3.43115 14.653C3.5999 14.3718 3.68428 14.0343 3.74053 13.6405V7.79053C3.74053 5.31553 5.70928 3.23428 8.3249 2.95303C9.92803 2.78428 11.503 3.2624 12.6562 4.2749C13.6687 5.1749 14.2312 6.38428 14.2312 7.67803V13.528C14.2312 13.9499 14.3437 14.3437 14.5968 14.7374L14.7655 14.9905H3.23428Z"
                                    fill="currentColor" />
                            </svg>

                            <?php if(isset($notificationCount) && $notificationCount > 0): ?>
                                <span class="absolute -top-0.5 -right-0.5 z-1 h-2 w-2 rounded-full bg-red-500">
                                    <span class="absolute -z-1 inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"></span>
                                </span>
                            <?php endif; ?>
                        </span>
                    </a>

                    <!-- Dropdown Start -->
                    <div x-show="dropdownOpen"
                        class="absolute -right-27 mt-2.5 flex h-90 w-75 flex-col rounded-xl border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800 sm:right-0 sm:w-80"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95">
                        <div class="px-4.5 py-3 border-b border-gray-200 dark:border-gray-700">
                            <h5 class="text-sm font-medium text-gray-900 dark:text-white">Notifications</h5>
                        </div>

                        <ul class="flex h-auto flex-col overflow-y-auto">
                            <!-- Sample notification items -->
                            <li>
                                <a class="flex flex-col gap-2.5 border-t border-gray-200 px-4.5 py-3 hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-700"
                                    href="#">
                                    <p class="text-sm text-gray-900 dark:text-white">
                                        <span class="text-green-600 dark:text-green-400">New application</span> submitted for review
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">12 May, 2025 at 09:30 AM</p>
                                </a>
                            </li>
                            <li>
                                <a class="flex flex-col gap-2.5 border-t border-gray-200 px-4.5 py-3 hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-700"
                                    href="#">
                                    <p class="text-sm text-gray-900 dark:text-white">
                                        <span class="text-blue-600 dark:text-blue-400">Payment confirmed</span> for transcript request
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">12 May, 2025 at 08:15 AM</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- Dropdown End -->
                </li>
                <!-- Notification Menu Area -->

                <!-- Theme Toggle -->
                <li>
                    <button
                        class="relative flex h-11 w-11 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-500 transition-all duration-200 hover:bg-gray-50 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white shadow-sm hover:shadow-md"
                        @click.prevent="toggleTheme()" title="Toggle theme">
                        <svg class="hidden dark:block" width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M9.99998 1.5415C10.4142 1.5415 10.75 1.87729 10.75 2.2915V3.5415C10.75 3.95572 10.4142 4.2915 9.99998 4.2915C9.58577 4.2915 9.24998 3.95572 9.24998 3.5415V2.2915C9.24998 1.87729 9.58577 1.5415 9.99998 1.5415ZM10.0009 6.79327C8.22978 6.79327 6.79402 8.22904 6.79402 10.0001C6.79402 11.7712 8.22978 13.207 10.0009 13.207C11.772 13.207 13.2078 11.7712 13.2078 10.0001C13.2078 8.22904 11.772 6.79327 10.0009 6.79327ZM5.29402 10.0001C5.29402 7.40061 7.40135 5.29327 10.0009 5.29327C12.6004 5.29327 14.7078 7.40061 14.7078 10.0001C14.7078 12.5997 12.6004 14.707 10.0009 14.707C7.40135 14.707 5.29402 12.5997 5.29402 10.0001ZM15.9813 5.08035C16.2742 4.78746 16.2742 4.31258 15.9813 4.01969C15.6884 3.7268 15.2135 3.7268 14.9207 4.01969L14.0368 4.90357C13.7439 5.19647 13.7439 5.67134 14.0368 5.96423C14.3297 6.25713 14.8045 6.25713 15.0974 5.96423L15.9813 5.08035ZM18.4577 10.0001C18.4577 10.4143 18.1219 10.7501 17.7077 10.7501H16.4577C16.0435 10.7501 15.7077 10.4143 15.7077 10.0001C15.7077 9.58592 16.0435 9.25013 16.4577 9.25013H17.7077C18.1219 9.25013 18.4577 9.58592 18.4577 10.0001ZM14.9207 15.9806C15.2135 16.2735 15.6884 16.2735 15.9813 15.9806C16.2742 15.6877 16.2742 15.2128 15.9813 14.9199L15.0974 14.036C14.8045 13.7431 14.3297 13.7431 14.0368 14.036C13.7439 14.3289 13.7439 14.8038 14.0368 15.0967L14.9207 15.9806ZM9.99998 15.7088C10.4142 15.7088 10.75 16.0445 10.75 16.4588V17.7088C10.75 18.123 10.4142 18.4588 9.99998 18.4588C9.58577 18.4588 9.24998 18.123 9.24998 17.7088V16.4588C9.24998 16.0445 9.58577 15.7088 9.99998 15.7088ZM5.96356 15.0972C6.25646 14.8043 6.25646 14.3295 5.96356 14.0366C5.67067 13.7437 5.1958 13.7437 4.9029 14.0366L4.01902 14.9204C3.72613 15.2133 3.72613 15.6882 4.01902 15.9811C4.31191 16.274 4.78679 16.274 5.07968 15.9811L5.96356 15.0972ZM4.29224 10.0001C4.29224 10.4143 3.95645 10.7501 3.54224 10.7501H2.29224C1.87802 10.7501 1.54224 10.4143 1.54224 10.0001C1.54224 9.58592 1.87802 9.25013 2.29224 9.25013H3.54224C3.95645 9.25013 4.29224 9.58592 4.29224 10.0001ZM4.9029 5.9637C5.1958 6.25659 5.67067 6.25659 5.96356 5.9637C6.25646 5.6708 6.25646 5.19593 5.96356 4.90303L5.07968 4.01915C4.78679 3.72626 4.31191 3.72626 4.01902 4.01915C3.72613 4.31204 3.72613 4.78692 4.01902 5.07981L4.9029 5.9637Z"
                                fill="currentColor" />
                        </svg>
                        <svg class="dark:hidden" width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M17.4547 11.97L18.1799 12.1611C18.265 11.8383 18.1265 11.4982 17.8401 11.3266C17.5538 11.1551 17.1885 11.1934 16.944 11.4207L17.4547 11.97ZM8.0306 2.5459L8.57989 3.05657C8.80718 2.81209 8.84554 2.44682 8.67398 2.16046C8.50243 1.8741 8.16227 1.73559 7.83948 1.82066L8.0306 2.5459ZM12.9154 13.0035C9.64678 13.0035 6.99707 10.3538 6.99707 7.08524H5.49707C5.49707 11.1823 8.81835 14.5035 12.9154 14.5035V13.0035ZM16.944 11.4207C15.8869 12.4035 14.4721 13.0035 12.9154 13.0035V14.5035C14.8657 14.5035 16.6418 13.7499 17.9654 12.5193L16.944 11.4207ZM16.7295 11.7789C15.9437 14.7607 13.2277 16.9586 10.0003 16.9586V18.4586C13.9257 18.4586 17.2249 15.7853 18.1799 12.1611L16.7295 11.7789ZM10.0003 16.9586C6.15734 16.9586 3.04199 13.8433 3.04199 10.0003H1.54199C1.54199 14.6717 5.32892 18.4586 10.0003 18.4586V16.9586ZM3.04199 10.0003C3.04199 6.77289 5.23988 4.05695 8.22173 3.27114L7.83948 1.82066C4.21532 2.77574 1.54199 6.07486 1.54199 10.0003H3.04199ZM6.99707 7.08524C6.99707 5.52854 7.5971 4.11366 8.57989 3.05657L7.48132 2.03522C6.25073 3.35885 5.49707 5.13487 5.49707 7.08524H6.99707Z"
                                fill="currentColor" />
                        </svg>
                    </button>
                </li>
            </ul>

            <!-- User Area -->
            <?php if(auth()->guard('transcript_staff')->check()): ?>
            <?php
                $staff = Auth::guard('transcript_staff')->user();
            ?>
            <div class="relative" x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false">
                <a class="flex items-center gap-4" href="#" @click.prevent="dropdownOpen = ! dropdownOpen">
                    <span class="hidden text-right lg:block">
                        <span class="block text-sm font-medium text-gray-900 dark:text-white"><?php echo e($staff->fname); ?> <?php echo e($staff->lname); ?></span>
                        <span class="block text-xs text-gray-500 dark:text-gray-400"><?php echo e($staff->title ?? 'Staff Member'); ?></span>
                    </span>

                    <span class="h-12 w-12 rounded-full overflow-hidden border-2 border-green-200 dark:border-green-700">
                        <?php if($staff->passport_url): ?>
                            <img src="<?php echo e($staff->passport_url); ?>" alt="Profile Photo" class="h-full w-full object-cover">
                        <?php else: ?>
                            <div class="h-full w-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center">
                                <span class="text-white font-semibold">
                                    <?php echo e(strtoupper(substr($staff->fname, 0, 1) . substr($staff->lname, 0, 1))); ?>

                                </span>
                            </div>
                        <?php endif; ?>
                    </span>

                    <svg class="hidden fill-current sm:block" width="12" height="8" viewBox="0 0 12 8" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.410765 0.910734C0.736202 0.585297 1.26384 0.585297 1.58928 0.910734L6.00002 5.32148L10.4108 0.910734C10.7362 0.585297 11.2638 0.585297 11.5893 0.910734C11.9147 1.23617 11.9147 1.76381 11.5893 2.08924L6.58928 7.08924C6.26384 7.41468 5.7362 7.41468 5.41077 7.08924L0.410765 2.08924C0.0853277 1.76381 0.0853277 1.23617 0.410765 0.910734Z"
                            fill="currentColor" />
                    </svg>
                </a>

                <!-- Dropdown Start -->
                <div x-show="dropdownOpen"
                    class="absolute right-0 mt-4 flex w-62.5 flex-col rounded-xl border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95">
                    <ul class="flex flex-col gap-5 border-b border-gray-200 px-6 py-7.5 dark:border-gray-700">
                        <li>
                            <a href="<?php echo e(route('transcript.staff.profile')); ?>"
                                class="flex items-center gap-3.5 text-sm font-medium duration-300 ease-in-out hover:text-green-600 dark:hover:text-green-400 lg:text-base">
                                <svg class="fill-current" width="22" height="22" viewBox="0 0 22 22" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11 9.62499C8.42188 9.62499 6.35938 7.59687 6.35938 5.12187C6.35938 2.64687 8.42188 0.618744 11 0.618744C13.5781 0.618744 15.6406 2.64687 15.6406 5.12187C15.6406 7.59687 13.5781 9.62499 11 9.62499ZM11 2.16562C9.28125 2.16562 7.90625 3.50624 7.90625 5.12187C7.90625 6.73749 9.28125 8.07812 11 8.07812C12.7188 8.07812 14.0938 6.73749 14.0938 5.12187C14.0938 3.50624 12.7188 2.16562 11 2.16562Z"
                                        fill="currentColor" />
                                    <path
                                        d="M17.7719 21.4156H4.2281C3.5406 21.4156 2.9906 20.8656 2.9906 20.1781V17.0844C2.9906 13.7156 5.7406 10.9656 9.10935 10.9656H12.925C16.2937 10.9656 19.0437 13.7156 19.0437 17.0844V20.1781C19.0437 20.8656 18.4937 21.4156 17.7719 21.4156ZM4.53748 19.8687H17.4969V17.0844C17.4969 14.575 15.4344 12.5125 12.925 12.5125H9.07498C6.5656 12.5125 4.5031 14.575 4.5031 17.0844V19.8687H4.53748Z"
                                        fill="currentColor" />
                                </svg>
                                My Profile
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('transcript.staff.dashboard')); ?>"
                                class="flex items-center gap-3.5 text-sm font-medium duration-300 ease-in-out hover:text-green-600 dark:hover:text-green-400 lg:text-base">
                                <svg class="fill-current" width="22" height="22" viewBox="0 0 22 22" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17.7844 4.04687C17.1969 4.04687 16.7125 3.5625 16.7125 2.975C16.7125 2.3875 17.1969 1.90312 17.7844 1.90312C18.3719 1.90312 18.8563 2.3875 18.8563 2.975C18.8563 3.5625 18.3719 4.04687 17.7844 4.04687Z"
                                        fill="currentColor" />
                                    <path
                                        d="M11.0281 4.04687C10.4406 4.04687 9.95625 3.5625 9.95625 2.975C9.95625 2.3875 10.4406 1.90312 11.0281 1.90312C11.6156 1.90312 12.1 2.3875 12.1 2.975C12.1 3.5625 11.6156 4.04687 11.0281 4.04687Z"
                                        fill="currentColor" />
                                    <path
                                        d="M4.27188 4.04687C3.68438 4.04687 3.2 3.5625 3.2 2.975C3.2 2.3875 3.68438 1.90312 4.27188 1.90312C4.85938 1.90312 5.34375 2.3875 5.34375 2.975C5.34375 3.5625 4.85938 4.04687 4.27188 4.04687Z"
                                        fill="currentColor" />
                                    <path
                                        d="M18.8563 1.90312H17.7844C17.1969 1.90312 16.7125 1.41875 16.7125 0.83125C16.7125 0.24375 17.1969 -0.240625 17.7844 -0.240625H18.8563C20.2313 -0.240625 21.3719 0.9 21.3719 2.275V19.25C21.3719 20.625 20.2313 21.7656 18.8563 21.7656H3.14375C1.76875 21.7656 0.628125 20.625 0.628125 19.25V2.275C0.628125 0.9 1.76875 -0.240625 3.14375 -0.240625H4.21563C4.80313 -0.240625 5.2875 0.24375 5.2875 0.83125C5.2875 1.41875 4.80313 1.90312 4.21563 1.90312H3.14375C2.55625 1.90312 2.07188 2.3875 2.07188 2.975V19.25C2.07188 19.8375 2.55625 20.3219 3.14375 20.3219H18.8563C19.4438 20.3219 19.9281 19.8375 19.9281 19.25V2.975C19.9281 2.3875 19.4438 1.90312 18.8563 1.90312Z"
                                        fill="currentColor" />
                                </svg>
                                Dashboard
                            </a>
                        </li>
                    </ul>
                    <button class="flex items-center gap-3.5 px-6 py-4 text-sm font-medium duration-300 ease-in-out hover:text-red-600 dark:hover:text-red-400 lg:text-base"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <svg class="fill-current" width="22" height="22" viewBox="0 0 22 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15.5375 0.618744H11.6531C10.7594 0.618744 10.0031 1.37499 10.0031 2.26874V4.64062C10.0031 5.05312 10.3469 5.39687 10.7594 5.39687C11.1719 5.39687 11.5156 5.05312 11.5156 4.64062V2.23437C11.5156 2.16562 11.5844 2.09687 11.6531 2.09687H15.5375C16.3625 2.09687 17.0156 2.75 17.0156 3.575V18.425C17.0156 19.25 16.3625 19.9031 15.5375 19.9031H11.6531C11.5844 19.9031 11.5156 19.8344 11.5156 19.7656V17.3594C11.5156 16.9469 11.1719 16.6031 10.7594 16.6031C10.3469 16.6031 10.0031 16.9469 10.0031 17.3594V19.7312C10.0031 20.625 10.7594 21.3812 11.6531 21.3812H15.5375C17.2219 21.3812 18.5844 20.0187 18.5844 18.3344V3.66562C18.5844 1.98124 17.2219 0.618744 15.5375 0.618744Z"
                                fill="" />
                            <path
                                d="M6.05001 11.7563H12.2031C12.6156 11.7563 12.9594 11.4125 12.9594 11C12.9594 10.5875 12.6156 10.2438 12.2031 10.2438H6.08439L8.21564 8.07813C8.52501 7.76875 8.52501 7.2875 8.21564 6.97812C7.90626 6.66875 7.42501 6.66875 7.11564 6.97812L3.67814 10.4156C3.36876 10.725 3.36876 11.2063 3.67814 11.5156L7.11564 14.9531C7.42501 15.2625 7.90626 15.2625 8.21564 14.9531C8.52501 14.6438 8.52501 14.1625 8.21564 13.8531L6.05001 11.7563Z"
                                fill="" />
                        </svg>
                        Log Out
                    </button>

                    <form id="logout-form" action="<?php echo e(route('transcript.staff.logout')); ?>" method="POST" class="hidden">
                        <?php echo csrf_field(); ?>
                    </form>
                </div>
                <!-- Dropdown End -->
            </div>
            <?php endif; ?>
            <!-- User Area -->
        </div>
    </div>
</header>
<?php /**PATH C:\Users\Veritas ICT\Downloads\trans\transcript-system\resources\views/spartials/staff-navbar.blade.php ENDPATH**/ ?>