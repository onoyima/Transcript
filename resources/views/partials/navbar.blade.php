<header x-data="{ menuToggle: false }"
    class="sticky top-0 z-50 flex w-full bg-white/95 backdrop-blur-md border-b border-gray-200/50 shadow-sm dark:bg-gray-900/95 dark:border-gray-700/50">
    <div class="flex grow flex-col items-center justify-between lg:flex-row lg:px-6">
        <div
            class="flex w-full items-center justify-between gap-3 px-4 py-3 sm:gap-4 lg:justify-normal lg:px-0 lg:py-4 border-b border-gray-200/50 lg:border-b-0 dark:border-gray-700/50">

            <!-- Left side: Hamburger Toggle BTN (Mobile) -->
            @auth('student')
            <div class="flex items-center lg:flex-1">
                <button
                    :class="sidebarToggle ? 'bg-primary-50 text-primary-600 border-primary-200 dark:bg-primary-900/20 dark:text-primary-400 dark:border-primary-700/50' : 'hover:bg-gray-50 hover:text-gray-700 dark:hover:bg-gray-800 dark:hover:text-gray-300'"
                    class="flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 text-gray-500 transition-all duration-200 lg:h-11 lg:w-11 dark:border-gray-700 dark:text-gray-400 shadow-sm hover:shadow-md"
                    @click.stop="sidebarToggle = !sidebarToggle">
                    <svg class="hidden fill-current lg:block" width="16" height="12" viewBox="0 0 16 12" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.583252 1C0.583252 0.585788 0.919038 0.25 1.33325 0.25H14.6666C15.0808 0.25 15.4166 0.585786 15.4166 1C15.4166 1.41421 15.0808 1.75 14.6666 1.75L1.33325 1.75C0.919038 1.75 0.583252 1.41422 0.583252 1ZM0.583252 11C0.583252 10.5858 0.919038 10.25 1.33325 10.25L14.6666 10.25C15.0808 10.25 15.4166 10.5858 15.4166 11C15.4166 11.4142 15.0808 11.75 14.6666 11.75L1.33325 11.75C0.919038 11.75 0.583252 11.4142 0.583252 11ZM1.33325 5.25C0.919038 5.25 0.583252 5.58579 0.583252 6C0.583252 6.41421 0.919038 6.75 1.33325 6.75L7.99992 6.75C8.41413 6.75 8.74992 6.41421 8.74992 6C8.74992 5.58579 8.41413 5.25 7.99992 5.25L1.33325 5.25Z"
                            fill="currentColor" />
                    </svg>

                    <svg :class="sidebarToggle ? 'hidden' : 'block lg:hidden'" class="fill-current lg:hidden" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M3.25 6C3.25 5.58579 3.58579 5.25 4 5.25L20 5.25C20.4142 5.25 20.75 5.58579 20.75 6C20.75 6.41421 20.4142 6.75 20 6.75L4 6.75C3.58579 6.75 3.25 6.41422 3.25 6ZM3.25 18C3.25 17.5858 3.58579 17.25 4 17.25L20 17.25C20.4142 17.25 20.75 17.5858 20.75 18C20.75 18.4142 20.4142 18.75 20 18.75L4 18.75C3.58579 18.75 3.25 18.4142 3.25 18ZM4 11.25C3.58579 11.25 3.25 11.5858 3.25 12C3.25 12.4142 3.58579 12.75 4 12.75L12 12.75C12.4142 12.75 12.75 12.4142 12.75 12C12.75 11.5858 12.4142 11.25 12 11.25L4 11.25Z"
                            fill="currentColor" />
                    </svg>

                    <!-- cross icon -->
                    <svg :class="sidebarToggle ? 'block lg:hidden' : 'hidden'" class="fill-current" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M6.21967 7.28131C5.92678 6.98841 5.92678 6.51354 6.21967 6.22065C6.51256 5.92775 6.98744 5.92775 7.28033 6.22065L11.999 10.9393L16.7176 6.22078C17.0105 5.92789 17.4854 5.92788 17.7782 6.22078C18.0711 6.51367 18.0711 6.98855 17.7782 7.28144L13.0597 12L17.7782 16.7186C18.0711 17.0115 18.0711 17.4863 17.7782 17.7792C17.4854 18.0721 17.0105 18.0721 16.7176 17.7792L11.999 13.0607L7.28033 17.7794C6.98744 18.0722 6.51256 18.0722 6.21967 17.7794C5.92678 17.4865 5.92678 17.0116 6.21967 16.7187L10.9384 12L6.21967 7.28131Z"
                            fill="currentColor" />
                    </svg>
                </button>
            </div>
            @endauth

            <!-- Center: Logo for mobile -->
            <div class="flex-1 flex justify-center lg:hidden">
                <a href="{{ route('student.dashboard') }}" class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center shadow-lg">
                        <i class="fas fa-graduation-cap text-white text-sm"></i>
                    </div>
                    <span class="font-bold text-gray-900 dark:text-white text-lg">Veritas</span>
                </a>
            </div>

            <!-- Right side: Dark Mode Toggle and Menu Button (Mobile) -->
            <div class="flex items-center gap-2 lg:hidden">
                <!-- Dark Mode Toggler (Mobile) -->
                <button
                    class="flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-500 transition-all duration-200 hover:bg-gray-50 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white shadow-sm hover:shadow-md"
                    @click.prevent="$root.darkMode = !$root.darkMode">
                    <svg class="hidden dark:block" width="16" height="16" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9.99998 1.5415C10.4142 1.5415 10.75 1.87729 10.75 2.2915V3.5415C10.75 3.95572 10.4142 4.2915 9.99998 4.2915C9.58577 4.2915 9.24998 3.95572 9.24998 3.5415V2.2915C9.24998 1.87729 9.58577 1.5415 9.99998 1.5415ZM10.0009 6.79327C8.22978 6.79327 6.79402 8.22904 6.79402 10.0001C6.79402 11.7712 8.22978 13.207 10.0009 13.207C11.772 13.207 13.2078 11.7712 13.2078 10.0001C13.2078 8.22904 11.772 6.79327 10.0009 6.79327ZM5.29402 10.0001C5.29402 7.40061 7.40135 5.29327 10.0009 5.29327C12.6004 5.29327 14.7078 7.40061 14.7078 10.0001C14.7078 12.5997 12.6004 14.707 10.0009 14.707C7.40135 14.707 5.29402 12.5997 5.29402 10.0001ZM15.9813 5.08035C16.2742 4.78746 16.2742 4.31258 15.9813 4.01969C15.6884 3.7268 15.2135 3.7268 14.9207 4.01969L14.0368 4.90357C13.7439 5.19647 13.7439 5.67134 14.0368 5.96423C14.3297 6.25713 14.8045 6.25713 15.0974 5.96423L15.9813 5.08035ZM18.4577 10.0001C18.4577 10.4143 18.1219 10.7501 17.7077 10.7501H16.4577C16.0435 10.7501 15.7077 10.4143 15.7077 10.0001C15.7077 9.58592 16.0435 9.25013 16.4577 9.25013H17.7077C18.1219 9.25013 18.4577 9.58592 18.4577 10.0001ZM14.9207 15.9806C15.2135 16.2735 15.6884 16.2735 15.9813 15.9806C16.2742 15.6877 16.2742 15.2128 15.9813 14.9199L15.0974 14.036C14.8045 13.7431 14.3297 13.7431 14.0368 14.036C13.7439 14.3289 13.7439 14.8038 14.0368 15.0967L14.9207 15.9806ZM9.99998 15.7088C10.4142 15.7088 10.75 16.0445 10.75 16.4588V17.7088C10.75 18.123 10.4142 18.4588 9.99998 18.4588C9.58577 18.4588 9.24998 18.123 9.24998 17.7088V16.4588C9.24998 16.0445 9.58577 15.7088 9.99998 15.7088ZM5.96356 15.0972C6.25646 14.8043 6.25646 14.3295 5.96356 14.0366C5.67067 13.7437 5.1958 13.7437 4.9029 14.0366L4.01902 14.9204C3.72613 15.2133 3.72613 15.6882 4.01902 15.9811C4.31191 16.274 4.78679 16.274 5.07968 15.9811L5.96356 15.0972ZM4.29224 10.0001C4.29224 10.4143 3.95645 10.7501 3.54224 10.7501H2.29224C1.87802 10.7501 1.54224 10.4143 1.54224 10.0001C1.54224 9.58592 1.87802 9.25013 2.29224 9.25013H3.54224C3.95645 9.25013 4.29224 9.58592 4.29224 10.0001ZM4.9029 5.9637C5.1958 6.25659 5.67067 6.25659 5.96356 5.9637C6.25646 5.6708 6.25646 5.19593 5.96356 4.90303L5.07968 4.01915C4.78679 3.72626 4.31191 3.72626 4.01902 4.01915C3.72613 4.31204 3.72613 4.78692 4.01902 5.07981L4.9029 5.9637Z"
                            fill="currentColor" />
                    </svg>
                    <svg class="dark:hidden" width="16" height="16" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17.4547 11.97L18.1799 12.1611C18.265 11.8383 18.1265 11.4982 17.8401 11.3266C17.5538 11.1551 17.1885 11.1934 16.944 11.4207L17.4547 11.97ZM8.0306 2.5459L8.57989 3.05657C8.80718 2.81209 8.84554 2.44682 8.67398 2.16046C8.50243 1.8741 8.16227 1.73559 7.83948 1.82066L8.0306 2.5459ZM12.9154 13.0035C9.64678 13.0035 6.99707 10.3538 6.99707 7.08524H5.49707C5.49707 11.1823 8.81835 14.5035 12.9154 14.5035V13.0035ZM16.944 11.4207C15.8869 12.4035 14.4721 13.0035 12.9154 13.0035V14.5035C14.8657 14.5035 16.6418 13.7499 17.9654 12.5193L16.944 11.4207ZM16.7295 11.7789C15.9437 14.7607 13.2277 16.9586 10.0003 16.9586V18.4586C13.9257 18.4586 17.2249 15.7853 18.1799 12.1611L16.7295 11.7789ZM10.0003 16.9586C6.15734 16.9586 3.04199 13.8433 3.04199 10.0003H1.54199C1.54199 14.6717 5.32892 18.4586 10.0003 18.4586V16.9586ZM3.04199 10.0003C3.04199 6.77289 5.23988 4.05695 8.22173 3.27114L7.83948 1.82066C4.21532 2.77574 1.54199 6.07486 1.54199 10.0003H3.04199ZM6.99707 7.08524C6.99707 5.52854 7.5971 4.11366 8.57989 3.05657L7.48132 2.03522C6.25073 3.35885 5.49707 5.13487 5.49707 7.08524H6.99707Z"
                            fill="currentColor" />
                    </svg>
                </button>

                <!-- Application nav menu button -->
                <button
                    class="flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 text-gray-500 transition-all duration-200 hover:bg-gray-50 hover:text-gray-700 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-300 shadow-sm hover:shadow-md"
                    :class="menuToggle ? 'bg-primary-50 text-primary-600 border-primary-200 dark:bg-primary-900/20 dark:text-primary-400 dark:border-primary-700/50' : ''" @click.stop="menuToggle = !menuToggle">
                    <svg class="fill-current" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M5.99902 10.4951C6.82745 10.4951 7.49902 11.1667 7.49902 11.9951V12.0051C7.49902 12.8335 6.82745 13.5051 5.99902 13.5051C5.1706 13.5051 4.49902 12.8335 4.49902 12.0051V11.9951C4.49902 11.1667 5.1706 10.4951 5.99902 10.4951ZM17.999 10.4951C18.8275 10.4951 19.499 11.1667 19.499 11.9951V12.0051C19.499 12.8335 18.8275 13.5051 17.999 13.5051C17.1706 13.5051 16.499 12.8335 16.499 12.0051V11.9951C16.499 11.1667 17.1706 10.4951 17.999 10.4951ZM13.499 11.9951C13.499 11.1667 12.8275 10.4951 11.999 10.4951C11.1706 10.4951 10.499 11.1667 10.499 11.9951V12.0051C10.499 12.8335 11.1706 13.5051 11.999 13.5051C12.8275 13.5051 13.499 12.8335 13.499 12.0051V11.9951Z"
                            fill="currentColor" />
                    </svg>
                </button>
            </div>

        </div>

        <div :class="menuToggle ? 'flex' : 'hidden'"
            class="w-full items-center justify-between gap-4 px-4 py-4 lg:flex lg:justify-end lg:px-0 bg-white/95 backdrop-blur-md lg:bg-transparent border-t border-gray-200/50 lg:border-t-0 dark:bg-gray-900/95 lg:dark:bg-transparent dark:border-gray-700/50">
            <div class="flex items-center gap-3">
                <!-- Dark Mode Toggler -->
                <button
                    class="relative flex h-11 w-11 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-500 transition-all duration-200 hover:bg-gray-50 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white shadow-sm hover:shadow-md"
                    @click.prevent="$root.darkMode = !$root.darkMode">
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
                <!-- Dark Mode Toggler -->

                <!-- Notification Menu Area -->
                <div class="relative" x-data="{ dropdownOpen: false, notifying: true }" @click.outside="dropdownOpen = false" x-cloak>
                    <button
                        class="relative flex h-11 w-11 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-500 transition-all duration-200 hover:bg-gray-50 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white shadow-sm hover:shadow-md"
                        @click.prevent="dropdownOpen = ! dropdownOpen; notifying = false">
                        <span :class="!notifying ? 'hidden' : 'flex'"
                            class="absolute -top-1 -right-1 z-10 h-3 w-3 rounded-full bg-gradient-to-r from-red-500 to-red-600 border-2 border-white dark:border-gray-900">
                            <span
                                class="absolute -z-10 inline-flex h-full w-full animate-ping rounded-full bg-red-500 opacity-75"></span>
                        </span>
                        <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M10.75 2.29248C10.75 1.87827 10.4143 1.54248 10 1.54248C9.58583 1.54248 9.25004 1.87827 9.25004 2.29248V2.83613C6.08266 3.20733 3.62504 5.9004 3.62504 9.16748V14.4591H3.33337C2.91916 14.4591 2.58337 14.7949 2.58337 15.2091C2.58337 15.6234 2.91916 15.9591 3.33337 15.9591H4.37504H15.625H16.6667C17.0809 15.9591 17.4167 15.6234 17.4167 15.2091C17.4167 14.7949 17.0809 14.4591 16.6667 14.4591H16.375V9.16748C16.375 5.9004 13.9174 3.20733 10.75 2.83613V2.29248ZM14.875 14.4591V9.16748C14.875 6.47509 12.6924 4.29248 10 4.29248C7.30765 4.29248 5.12504 6.47509 5.12504 9.16748V14.4591H14.875ZM8.00004 17.7085C8.00004 18.1228 8.33583 18.4585 8.75004 18.4585H11.25C11.6643 18.4585 12 18.1228 12 17.7085C12 17.2943 11.6643 16.9585 11.25 16.9585H8.75004C8.33583 16.9585 8.00004 17.2943 8.00004 17.7085Z"
                                fill="" />
                        </svg>
                    </button>

                    <!-- Dropdown Start -->
                    <div x-show="dropdownOpen" x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute -right-[240px] mt-4 flex h-[480px] w-[350px] flex-col rounded-2xl border border-gray-200/50 bg-white/95 backdrop-blur-md p-4 sm:w-[361px] lg:right-0 dark:border-gray-700/50 dark:bg-gray-900/95 shadow-xl">
                        <div
                            class="mb-4 flex items-center justify-between border-b border-gray-200/50 pb-3 dark:border-gray-700/50">
                            <h5 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                                <i class="fas fa-bell mr-2 text-primary-500"></i>
                                Notifications
                            </h5>

                            <button @click="dropdownOpen = false" class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 transition-colors duration-200 p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M6.21967 7.28131C5.92678 6.98841 5.92678 6.51354 6.21967 6.22065C6.51256 5.92775 6.98744 5.92775 7.28033 6.22065L11.999 10.9393L16.7176 6.22078C17.0105 5.92789 17.4854 5.92788 17.7782 6.22078C18.0711 6.51367 18.0711 6.98855 17.7782 7.28144L13.0597 12L17.7782 16.7186C18.0711 17.0115 18.0711 17.4863 17.7782 17.7792C17.4854 18.0721 17.0105 18.0721 16.7176 17.7792L11.999 13.0607L7.28033 17.7794C6.98744 18.0722 6.51256 18.0722 6.21967 17.7794C5.92678 17.4865 5.92678 17.0116 6.21967 16.7187L10.9384 12L6.21967 7.28131Z"
                                        fill="" />
                                </svg>
                            </button>
                        </div>

                        <ul class="flex h-auto flex-col overflow-y-auto space-y-2 scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600">
                            <li>
                                <a class="flex gap-3 rounded-xl p-3 transition-all duration-200 hover:bg-gray-50 dark:hover:bg-gray-800/50 border border-transparent hover:border-gray-200/50 dark:hover:border-gray-700/50"
                                    href="#">
                                    <span class="relative z-1 block h-10 w-full max-w-10 rounded-full">
                                        <img src="{{ asset('images/user/user-04.jpg') }}" alt="User"
                                            class="overflow-hidden rounded-full" />
                                        <span
                                            class="bg-success-500 absolute right-0 bottom-0 z-10 h-2.5 w-full max-w-2.5 rounded-full border-[1.5px] border-white dark:border-gray-900"></span>
                                    </span>

                                    <span class="block">
                                        <span class="text-theme-sm mb-1.5 block text-gray-500 dark:text-gray-400">
                                            <span class="font-medium text-gray-800 dark:text-white/90">DUmmy Dummy</span>
                                            requests permission to change
                                            <span class="font-medium text-gray-800 dark:text-white/90">Project
                                                - Notification</span>
                                        </span>

                                        <span
                                            class="text-theme-xs flex items-center gap-2 text-gray-500 dark:text-gray-400">
                                            <span>this</span>
                                            <span class="h-1 w-1 rounded-full bg-gray-400"></span>
                                            <span>15 min ago</span>
                                        </span>
                                    </span>
                                </a>
                            </li>

                        </ul>

                        {{-- <a href="#"
                            class="text-theme-sm shadow-theme-xs mt-3 flex justify-center rounded-lg border border-gray-300 bg-white p-3 font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                            View All Notification
                        </a> --}}
                    </div>
                    <!-- Dropdown End -->
                </div>
                <!-- Notification Menu Area -->
            </div>

            <!-- User Area -->
            @auth('student')
            @php
                $student = Auth::guard('student')->user();
                $academicInfo = $student->studentAcademic()->with('program')->first();
            @endphp
            <div class="relative" x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false" x-cloak>
                <button class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-700 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200 border border-transparent hover:border-gray-200/50 dark:hover:border-gray-700/50"
                    @click.prevent="dropdownOpen = ! dropdownOpen">
                    <!-- User Avatar -->
                    <div class="w-8 h-8 rounded-full flex items-center justify-center shadow-lg overflow-hidden">
                        @if($student->passport_url)
                            <img src="{{ $student->passport_url }}" alt="Profile Photo" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">
                                    {{ $student->initials }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- User Name -->
                    <div class="hidden sm:block">
                        <span class="text-sm font-medium text-gray-900 dark:text-white block">
                        {{ $student->fname }} {{ $student->lname }}
                    </span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            @if($academicInfo && $academicInfo->matric_no)
                                {{ $academicInfo->matric_no }}
                            @else
                                Student
                            @endif
                        </span>
                    </div>

                    <!-- Dropdown Arrow -->
                    <svg :class="dropdownOpen && 'rotate-180'" class="w-4 h-4 text-gray-500 dark:text-gray-400 transition-transform duration-200"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown Start -->
                <div x-show="dropdownOpen" x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-4 flex w-[280px] flex-col rounded-2xl border border-gray-200/50 bg-white/95 backdrop-blur-md p-4 dark:border-gray-700/50 dark:bg-gray-900/95 shadow-xl">
                    <!-- User Info Header -->
                    <div class="pb-4 border-b border-gray-200/50 dark:border-gray-700/50">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center shadow-lg overflow-hidden">
                                @if($student->passport_url)
                                    <img src="{{ $student->passport_url }}" alt="Profile Photo" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center">
                                        <span class="text-white font-semibold">
                                            {{ $student->initials }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <span class="text-sm font-semibold text-gray-900 dark:text-white block">
                                    {{ $student->fname }} {{ $student->lname }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 block">
                                    {{ $student->username }}
                                </span>
                            </div>
                        </div>

                        @if($academicInfo)
                        <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-3 space-y-2">
                            @if($academicInfo->matric_no)
                            <div class="flex items-center text-xs">
                                <i class="fas fa-id-card mr-2 text-primary-600 dark:text-primary-400 w-4"></i>
                                <span class="text-gray-700 dark:text-gray-300">{{ $academicInfo->matric_no }}</span>
                            </div>
                            @endif

                            @if($academicInfo->program)
                            <div class="flex items-center text-xs">
                                <i class="fas fa-graduation-cap mr-2 text-primary-600 dark:text-primary-400 w-4"></i>
                                <span class="text-gray-700 dark:text-gray-300">{{ $academicInfo->program->name ?? 'N/A' }}</span>
                            </div>
                            @endif

                            @if($academicInfo->level)
                            <div class="flex items-center text-xs">
                                <i class="fas fa-layer-group mr-2 text-primary-600 dark:text-primary-400 w-4"></i>
                                <span class="text-gray-700 dark:text-gray-300">Level {{ $academicInfo->level }}</span>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>

                    <ul class="flex flex-col gap-1 border-b border-gray-200 pt-4 pb-3 dark:border-gray-800">
                        <li>
                            <a href="{{ route('student.profile') }}"
                                class="group text-theme-sm flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                <i class="fas fa-user text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-300"></i>
                                My Profile
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('student.payments') }}"
                                class="group text-theme-sm flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                <i class="fas fa-credit-card text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-300"></i>
                                Payment History
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('student.transcript.history') }}"
                                class="group text-theme-sm flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                <i class="fas fa-history text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-300"></i>
                                Application History
                            </a>
                        </li>
                    </ul>

                    <!-- Logout Section -->
                    <div class="pt-3">
                        <form method="POST" action="{{ route('student.logout') }}">
                            @csrf
                            <button type="submit"
                                class="group text-theme-sm flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-red-600 hover:bg-red-50 hover:text-red-700 dark:text-red-400 dark:hover:bg-red-900/20 dark:hover:text-red-300 w-full text-left transition-all duration-200">
                                <i class="fas fa-sign-out-alt text-red-500 group-hover:text-red-700 dark:text-red-400 dark:group-hover:text-red-300"></i>
                                Logout
                            </button>
                        </form>
                    </div>

                </div>
                <!-- Dropdown End -->
            </div>
            @endauth

            @auth('transcript_staff')
            @php
                $staff = Auth::guard('transcript_staff')->user();
            @endphp
            <div class="relative" x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false" x-cloak>
                <button class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-700 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200 border border-transparent hover:border-gray-200/50 dark:hover:border-gray-700/50"
                    @click.prevent="dropdownOpen = ! dropdownOpen">
                    <!-- User Avatar -->
                    <div class="w-8 h-8 rounded-full flex items-center justify-center shadow-lg overflow-hidden">
                        @if($staff->passport_url)
                            <img src="{{ $staff->passport_url }}" alt="Profile Photo" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center">
                                <span class="text-white text-sm font-semibold">
                                    {{ strtoupper(substr($staff->fname, 0, 1) . substr($staff->lname, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- User Name -->
                    <div class="hidden sm:block">
                        <span class="text-sm font-medium text-gray-900 dark:text-white block">
                            {{ $staff->fname }} {{ $staff->lname }}
                        </span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            Staff Member
                        </span>
                    </div>

                    <!-- Dropdown Arrow -->
                    <svg :class="dropdownOpen && 'rotate-180'" class="w-4 h-4 text-gray-500 dark:text-gray-400 transition-transform duration-200"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown Start -->
                <div x-show="dropdownOpen" x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-4 flex w-[280px] flex-col rounded-2xl border border-gray-200/50 bg-white/95 backdrop-blur-md p-4 dark:border-gray-700/50 dark:bg-gray-900/95 shadow-xl">
                    <!-- User Info Header -->
                    <div class="pb-4 border-b border-gray-200/50 dark:border-gray-700/50">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center shadow-lg overflow-hidden">
                                @if($staff->passport_url)
                                    <img src="{{ $staff->passport_url }}" alt="Profile Photo" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center">
                                        <span class="text-white font-semibold">
                                            {{ strtoupper(substr($staff->fname, 0, 1) . substr($staff->lname, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <span class="text-sm font-semibold text-gray-900 dark:text-white block">
                                    {{ $staff->fname }} {{ $staff->lname }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 block">
                                    {{ $staff->username }}
                                </span>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-3 space-y-2">
                            @if($staff->username)
                            <div class="flex items-center text-xs">
                                <i class="fas fa-user mr-2 text-green-600 dark:text-green-400 w-4"></i>
                                <span class="text-gray-700 dark:text-gray-300">{{ $staff->username }}</span>
                            </div>
                            @endif

                            @if($staff->phone)
                            <div class="flex items-center text-xs">
                                <i class="fas fa-phone mr-2 text-green-600 dark:text-green-400 w-4"></i>
                                <span class="text-gray-700 dark:text-gray-300">{{ $staff->phone }}</span>
                            </div>
                            @endif

                            @if($staff->title)
                            <div class="flex items-center text-xs">
                                <i class="fas fa-briefcase mr-2 text-green-600 dark:text-green-400 w-4"></i>
                                <span class="text-gray-700 dark:text-gray-300">{{ $staff->title }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <ul class="flex flex-col gap-1 border-b border-gray-200 pt-4 pb-3 dark:border-gray-800">
                        <li>
                            <a href="{{ route('transcript.staff.profile') }}"
                                class="group text-theme-sm flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                <i class="fas fa-user text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-300"></i>
                                My Profile
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('transcript.staff.dashboard') }}"
                                class="group text-theme-sm flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                <i class="fas fa-tachometer-alt text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-300"></i>
                                Dashboard
                            </a>
                        </li>
                        @can('view_transcript_applications', $staff)
                        <li>
                            <a href="{{ route('transcript.staff.applications') }}"
                                class="group text-theme-sm flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                <i class="fas fa-file-alt text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-300"></i>
                                Applications
                            </a>
                        </li>
                        @endcan
                        @can('manage_transcript_payments', $staff)
                        <li>
                            <a href="{{ route('transcript.staff.payments') }}"
                                class="group text-theme-sm flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                <i class="fas fa-credit-card text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-300"></i>
                                Payments
                            </a>
                        </li>
                        @endcan
                    </ul>

                    <!-- Logout Section -->
                    <div class="pt-3">
                        <form method="POST" action="{{ route('transcript.staff.logout') }}">
                            @csrf
                            <button type="submit"
                                class="group text-theme-sm flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-red-600 hover:bg-red-50 hover:text-red-700 dark:text-red-400 dark:hover:bg-red-900/20 dark:hover:text-red-300 w-full text-left transition-all duration-200">
                                <i class="fas fa-sign-out-alt text-red-500 group-hover:text-red-700 dark:text-red-400 dark:group-hover:text-red-300"></i>
                                Logout
                            </button>
                        </form>
                    </div>

                </div>
                <!-- Dropdown End -->
            </div>
            @endauth
            <!-- User Area -->
        </div>
    </div>
</header>
