<!DOCTYPE html>
<html lang="en" x-data="themeData()" x-init="init()" :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transcript Application System</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS (if needed) -->
    <style>
        /* Add any custom styles here if needed */
    </style>

    <!-- Alpine.js for interactive components -->
    <script defer src="https://unpkg.com/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Tailwind Configuration -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f9f7',
                            100: '#dcf2ed',
                            200: '#bce5db',
                            300: '#8dd3c2',
                            400: '#5bbca5',
                            500: '#3da58a',
                            600: '#2d8570',
                            700: '#26695b',
                            800: '#22544a',
                            900: '#004f40',
                        },
                        brand: '#004f40',
                        // Dark mode dimmed colors
                        'dark-primary': {
                            50: '#1a2e2a',
                            100: '#1f3530',
                            200: '#243c36',
                            300: '#29433c',
                            400: '#2e4a42',
                            500: '#335148',
                            600: '#38584e',
                            700: '#3d5f54',
                            800: '#42665a',
                            900: '#476d60'
                        }
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js x-cloak CSS -->
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <!-- Theme Color Meta Tag -->
    <meta name="theme-color" content="#ffffff" id="theme-color-meta">

    <!-- Theme Styles (cache-busted) -->
    <link rel="stylesheet" href="{{ asset('css/theme-styles.css') }}?v={{ filemtime(public_path('css/theme-styles.css')) }}">

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('darkMode', () => themeData());
        });
    </script>
</head>


<body x-data="{ page: 'ecommerce', 'loaded': true, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    class="font-inter bg-white dark:bg-gray-900 transition-colors duration-300">
<!-- ===== Preloader Start ===== -->
    <div x-show="loaded" x-init="window.addEventListener('DOMContentLoaded', () => { setTimeout(() => loaded = false, 500) })"
        class="fixed top-0 left-0 z-50 flex h-screen w-screen items-center justify-center bg-white dark:bg-gray-900">
        <div class="flex flex-col items-center space-y-4">
            <div class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-primary-900 border-t-transparent dark:border-primary-600">
            </div>
            <div class="text-primary-900 dark:text-primary-400 font-medium">Loading...</div>
        </div>
    </div>

    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">

            @auth('student')
                @include('partials.sidebar') <!-- Include sidebar for authenticated users -->
            @endauth


            <div class="relative flex flex-1 flex-col h-screen transition-all duration-300"
                 @guest('student') style="margin-left: 0;" @endguest>
                <!-- Small Device Overlay Start -->
                @auth('student')
                <div :class="sidebarToggle ? 'block lg:hidden' : 'hidden'"
                     class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm transition-opacity duration-300"
                     @click="sidebarToggle = false"></div>
                @endauth
                <!-- Small Device Overlay End -->

                <!-- ===== Header Start ===== -->
                @auth('student')
                @include('partials.navbar') <!-- Include navbar partial here -->
                @endauth

                <!-- ===== Main Content Start ===== -->
                <main class="flex-1 overflow-y-auto">
                  <!-- ===== Content Area Start ===== -->
                  <div class="@auth('student') p-4 md:p-6 lg:p-8 @else p-0 @endauth">
                      @yield('content') <!-- Dynamic content goes here -->
                  </div>
                  <!-- ===== Content Area End ===== -->
                </main>
                <!-- ===== Main Content End ===== -->
              </div>
    </div>

    <!-- JavaScript is handled by Vite -->

    <!-- Additional JavaScript for enhanced functionality -->
    <script>
        // Smooth scrolling for anchor links
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('a[href^="#"]');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Add loading states to forms
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn && !submitBtn.disabled) {
                        submitBtn.disabled = true;
                        const originalText = submitBtn.textContent;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';

                        // Re-enable after 5 seconds as fallback
                        setTimeout(() => {
                            submitBtn.disabled = false;
                            submitBtn.textContent = originalText;
                        }, 5000);
                    }
                });
            });
        });
    </script>

    <!-- Theme Manager Script (cache-busted) -->
    <script src="{{ asset('js/theme-manager.js') }}?v={{ filemtime(public_path('js/theme-manager.js')) }}"></script>

</body>

</html>
