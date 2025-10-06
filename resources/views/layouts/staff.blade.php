<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: false }" x-init="
        if (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) {
          localStorage.setItem('darkMode', JSON.stringify(true));
        }
        darkMode = JSON.parse(localStorage.getItem('darkMode'));
        $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" x-cloak :class="{ 'dark': darkMode }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Staff Portal') - {{ config('app.name', 'Transcript System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'ui-sans-serif', 'system-ui'],
                    }
                }
            },
            darkMode: 'class',
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom Styles -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Custom scrollbar */
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        .dark .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #4b5563;
        }

        .dark .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }

        /* Smooth transitions */
        * {
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        /* Backdrop blur support */
        .backdrop-blur-md {
            backdrop-filter: blur(12px);
        }

        /* Animation for sidebar toggle */
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50 dark:bg-gray-900 font-sans antialiased" x-data="{ sidebarToggle: false }">

    <!-- Main Layout Container -->
    <div class="flex h-screen overflow-hidden">

        @auth('transcript_staff')
        <!-- Sidebar -->
        @include('spartials.staff-sidebar')

        <!-- Main Content Area -->
        <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
            <!-- Header -->
            @include('spartials.staff-navbar')

            <!-- Main Content -->
            <main class="grow relative">
                <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10 relative">
                    
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 dark:border-green-800 dark:bg-green-900/20" x-data="{ show: true }" x-show="show" x-transition>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-green-600 dark:text-green-400 mr-3"></i>
                                    <div>
                                        <h4 class="text-sm font-semibold text-green-800 dark:text-green-200">Success!</h4>
                                        <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
                                    </div>
                                </div>
                                <button @click="show = false" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-200">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-800 dark:bg-red-900/20" x-data="{ show: true }" x-show="show" x-transition>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 mr-3"></i>
                                    <div>
                                        <h4 class="text-sm font-semibold text-red-800 dark:text-red-200">Error!</h4>
                                        <p class="text-sm text-red-700 dark:text-red-300">{{ session('error') }}</p>
                                    </div>
                                </div>
                                <button @click="show = false" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-800 dark:bg-red-900/20" x-data="{ show: true }" x-show="show" x-transition>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 mr-3"></i>
                                    <div>
                                        <h4 class="text-sm font-semibold text-red-800 dark:text-red-200">Please fix the following errors:</h4>
                                        <ul class="mt-2 text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <button @click="show = false" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- Page Content -->
                    @yield('content')
                </div>
            </main>
        </div>
        @else
        <!-- Guest Content -->
        <div class="flex-1 flex items-center justify-center">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Access Denied</h1>
                <p class="text-gray-600 dark:text-gray-400 mb-6">You need to be logged in as staff to access this area.</p>
                <a href="{{ route('transcript.staff.login') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Staff Login
                </a>
            </div>
        </div>
        @endauth
    </div>

    <!-- Scripts -->
    <script>
        // Auto-hide flash messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('[x-data*="show: true"]');
                alerts.forEach(function(alert) {
                    const alpineData = Alpine.$data(alert);
                    if (alpineData && alpineData.show) {
                        alpineData.show = false;
                    }
                });
            }, 5000);
        });

        // CSRF token setup
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };
    </script>

    @stack('scripts')
</body>
</html>