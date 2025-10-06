@extends('layouts.staff')

@section('title', 'Staff Profile')

@section('content')
<!-- Compact Profile Header -->
<div class="bg-gradient-to-r from-green-400 to-green-600 dark:from-green-600 dark:to-green-800 rounded-xl p-6 mb-6 -mx-4 md:-mx-6 2xl:-mx-10">
    <div class="flex items-center gap-6">
        <!-- Profile Image -->
        <div class="w-20 h-20 rounded-full overflow-hidden border-3 border-white/20 shadow-lg flex-shrink-0">
            @if($staff->passport_url)
                <img src="{{ $staff->passport_url }}" alt="Profile Photo" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-white/10 backdrop-blur-sm flex items-center justify-center">
                    <span class="text-white font-bold text-xl">
                        {{ strtoupper(substr($staff->fname, 0, 1) . substr($staff->lname, 0, 1)) }}
                    </span>
                </div>
            @endif
        </div>

        <!-- Profile Info -->
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-white truncate">
                {{ $staff->fname }} {{ $staff->lname }}
            </h1>
            <div class="flex flex-wrap items-center gap-4 mt-2 text-green-100 text-sm">
                @if($staff->username)
                    <span class="flex items-center gap-2">
                        <i class="fas fa-user"></i>
                        {{ $staff->username }}
                    </span>
                @endif
                @if($workProfile && $workProfile->department)
                    <span class="px-3 py-1 bg-white/20 rounded-full text-sm font-medium">
                        {{ $workProfile->department ?? 'Department' }}
                    </span>
                @endif
                <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full
                    @if($staff->status === 'active') bg-white/20 text-white
                    @else bg-red-500/20 text-red-200
                    @endif">
                    {{ ucfirst($staff->status) }}
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="space-y-6">

        <!-- Main Information Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Personal & Work Information Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md border border-gray-200/50 dark:border-gray-700/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                    <i class="fas fa-user-tie mr-3 text-green-600 dark:text-green-400"></i>
                    Personal & Work Information
                </h3>

                <!-- Personal Information Section -->
                <div class="mb-6">
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-300 mb-4 border-b border-gray-200 dark:border-gray-600 pb-2">Personal Details</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">First Name</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $staff->fname }}</p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Last Name</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $staff->lname }}</p>
                        </div>
                        @if($staff->lname)
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">lname</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $staff->lname }}</p>
                        </div>
                        @endif
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Email</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $staff->email }}</p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Phone</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $staff->phone ?? 'N/A' }}</p>
                        </div>
                        @if($staff->username)
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Username</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $staff->username }}</p>
                        </div>
                        @endif
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Member Since</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $staff->created_at->format('M j, Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Work Information Section -->
                @if($workProfile)
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-300 mb-4 border-b border-gray-200 dark:border-gray-600 pb-2">Work Details</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @if($workProfile->staff_number)
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Staff Number</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $workProfile->staff_number }}</p>
                        </div>
                        @endif
                        @if($workProfile->department)
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Department</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $workProfile->department ?? 'Not assigned' }}</p>
                        </div>
                        @endif
                        @if($workProfile->position)
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Position</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $workProfile->position ?? 'Not assigned' }}</p>
                        </div>
                        @endif
                        @if($workProfile->appointment_date)
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Appointment Date</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($workProfile->appointment_date)->format('M j, Y') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Roles & Permissions Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md border border-gray-200/50 dark:border-gray-700/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                    <i class="fas fa-shield-alt mr-3 text-green-600 dark:text-green-400"></i>
                    Roles & Permissions
                </h3>
                
                @if($roles->count() > 0)
                    <div class="space-y-3">
                        @foreach($roles as $role)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $role->display_name }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $role->description }}</p>
                                </div>
                                <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    Active
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center p-8 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-info-circle text-2xl mb-2"></i>
                        <p>No roles assigned</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Activity Statistics -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md border border-gray-200/50 dark:border-gray-700/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                <i class="fas fa-chart-bar mr-3 text-green-600 dark:text-green-400"></i>
                Activity Overview
            </h3>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @if(isset($activityStats['applications_handled']))
                <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $activityStats['applications_handled'] }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Applications</div>
                </div>
                @endif
                
                @if(isset($activityStats['pending_applications']))
                <div class="text-center p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                    <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $activityStats['pending_applications'] }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Pending</div>
                </div>
                @endif
                
                @if(isset($activityStats['payments_processed']))
                <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $activityStats['payments_processed'] }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Payments</div>
                </div>
                @endif
                
                @if(isset($activityStats['total_revenue']))
                <div class="text-center p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg">
                    <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">₦{{ number_format($activityStats['total_revenue'], 2) }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Revenue</div>
                </div>
                @endif
                
                @if(empty($activityStats))
                <div class="col-span-full text-center p-8 text-gray-500 dark:text-gray-400">
                    <i class="fas fa-info-circle text-2xl mb-2"></i>
                    <p>No activity statistics available based on your current permissions.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Update Contact Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md border border-gray-200/50 dark:border-gray-700/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                <i class="fas fa-edit mr-3 text-green-600 dark:text-green-400"></i>
                Update Contact Information
            </h3>

            <form action="{{ route('transcript.staff.profile.update') }}" method="POST" id="update-form" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Phone Number Input -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-phone mr-2 text-green-600 dark:text-green-400"></i>
                            Phone Number
                        </label>
                        <input
                            type="text"
                            name="phone"
                            id="phone"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white text-sm"
                            value="{{ old('phone', $staff->phone) }}"
                            placeholder="Enter phone number"/>
                        @error('phone')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address Input -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-envelope mr-2 text-green-600 dark:text-green-400"></i>
                            Email Address
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white text-sm"
                            value="{{ old('email', $staff->email) }}"
                            placeholder="Enter email address"/>
                        @error('email')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                            class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-green-400 to-green-600 hover:from-green-500 hover:to-green-700 text-white rounded-lg transition-all duration-300 flex items-center justify-center font-medium text-sm shadow-md hover:shadow-lg"
                            id="update-button">
                        <span id="spinner" class="hidden animate-spin mr-2">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" stroke-opacity="0.3"/>
                                <path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <span id="button-text">
                            <i class="fas fa-save mr-2"></i>
                            Update Profile
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md border border-gray-200/50 dark:border-gray-700/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                <i class="fas fa-bolt mr-3 text-green-600 dark:text-green-400"></i>
                Quick Actions
            </h3>
            
            <div class="space-y-3">
                <a href="{{ route('transcript.staff.dashboard') }}" 
                   class="flex items-center p-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-tachometer-alt mr-3 text-green-600 dark:text-green-400"></i>
                    Dashboard
                </a>
                
                @can('view_transcript_applications', $staff)
                <a href="{{ route('transcript.staff.applications') }}" 
                   class="flex items-center p-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-file-alt mr-3 text-green-600 dark:text-green-400"></i>
                    Applications
                </a>
                @endcan
                
                @can('view_transcript_payments', $staff)
                <a href="{{ route('transcript.staff.payments') }}" 
                   class="flex items-center p-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-credit-card mr-3 text-green-600 dark:text-green-400"></i>
                    Payments
                </a>
                @endcan
            </div>
        </div>

    <script>
        // Get the form, button, spinner, and text elements
        const updateButton = document.getElementById('update-button');
        const spinner = document.getElementById('spinner');
        const buttonText = document.getElementById('button-text');
        const form = document.getElementById('update-form');

        // Add event listener to the form submission
        form.addEventListener('submit', function(event) {
            // Show the spinner and update button text
            spinner.classList.remove('hidden');
            buttonText.innerHTML = 'Updating...';

            // Disable the button to prevent multiple clicks
            updateButton.disabled = true;
            updateButton.classList.add('opacity-75', 'cursor-not-allowed');
        });
    </script>
@endsection