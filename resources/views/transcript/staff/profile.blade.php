@extends('layouts.app')

@section('title', 'Staff Profile')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Staff Profile</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Manage your profile information and view your activity</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Profile Information -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Profile Header -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
                <div class="flex items-center space-x-6">
                    <!-- Avatar -->
                    <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr($staff->first_name, 0, 1) . substr($staff->last_name, 0, 1)) }}
                    </div>
                    
                    <!-- Basic Info -->
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $staff->first_name }} {{ $staff->last_name }}
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400">{{ $staff->email }}</p>
                        @if($staff->username)
                            <p class="text-sm text-gray-500 dark:text-gray-500">Username: {{ $staff->username }}</p>
                        @endif
                    </div>
                    
                    <!-- Status Badge -->
                    <div>
                        <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full
                            @if($staff->status === 'active') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                            @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                            @endif">
                            {{ ucfirst($staff->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Personal Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">First Name</label>
                        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-900 dark:text-white">
                            {{ $staff->first_name }}
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Surname</label>
                        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-900 dark:text-white">
                            {{ $staff->surname ?? 'Not provided' }}
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-900 dark:text-white">
                            {{ $staff->email }}
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-900 dark:text-white">
                            {{ $staff->phone ?? 'Not provided' }}
                        </div>
                    </div>
                    
                    @if($staff->username)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Username</label>
                        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-900 dark:text-white">
                            {{ $staff->username }}
                        </div>
                    </div>
                    @endif
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Member Since</label>
                        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-900 dark:text-white">
                            {{ $staff->created_at->format('F j, Y') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Work Information -->
            @if($workProfile)
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Work Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($workProfile->staff_no)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Staff Number</label>
                        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-900 dark:text-white">
                            {{ $workProfile->staff_no }}
                        </div>
                    </div>
                    @endif
                    
                    @if($workProfile->department)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Department</label>
                        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-900 dark:text-white">
                            {{ $workProfile->department->name ?? 'Not assigned' }}
                        </div>
                    </div>
                    @endif
                    
                    @if($workProfile->position)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Position</label>
                        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-900 dark:text-white">
                            {{ $workProfile->position->name ?? 'Not assigned' }}
                        </div>
                    </div>
                    @endif
                    
                    @if($workProfile->appointment_date)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Appointment Date</label>
                        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-900 dark:text-white">
                            {{ \Carbon\Carbon::parse($workProfile->appointment_date)->format('F j, Y') }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Update Contact Information -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Update Contact Information</h3>
                
                <form action="{{ route('transcript.staff.profile.update') }}" method="POST" id="update-form" class="space-y-6">
                    @csrf
                    
                    <!-- Phone Number Input -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                        <input
                            type="text" 
                            name="phone" 
                            id="phone"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                            value="{{ old('phone', $staff->phone) }}"
                            placeholder="Enter your phone number"/>
                        @error('phone')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address Input -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                        <input
                            type="email" 
                            name="email" 
                            id="email"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                            value="{{ old('email', $staff->email) }}"
                            placeholder="Enter your email address"/>
                        @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full py-3 px-6 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition duration-300 flex items-center justify-center font-medium"
                            id="update-button">
                        <!-- Spinner -->
                        <span id="spinner" class="hidden animate-spin mr-2">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" stroke-opacity="0.3"/>
                                <path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <!-- Button Text -->
                        <span id="button-text">
                            <i class="fas fa-save mr-2"></i>
                            Update Profile
                        </span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Roles & Permissions -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Roles & Permissions</h3>
                
                @if($roles->count() > 0)
                    <div class="space-y-3">
                        @foreach($roles as $role)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $role->display_name }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $role->description }}</p>
                                </div>
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                    Active
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400">No roles assigned</p>
                @endif
            </div>

            <!-- Activity Statistics -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Activity Overview</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @if(isset($activityStats['applications_handled']))
                    <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $activityStats['applications_handled'] }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Total Applications</div>
                    </div>
                    @endif
                    
                    @if(isset($activityStats['pending_applications']))
                    <div class="text-center p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                        <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $activityStats['pending_applications'] }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Pending Applications</div>
                    </div>
                    @endif
                    
                    @if(isset($activityStats['payments_processed']))
                    <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $activityStats['payments_processed'] }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Payments Processed</div>
                    </div>
                    @endif
                    
                    @if(isset($activityStats['total_revenue']))
                    <div class="text-center p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg">
                        <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">₦{{ number_format($activityStats['total_revenue'], 2) }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Total Revenue</div>
                    </div>
                    @endif
                    
                    @if(isset($activityStats['reports_generated']))
                    <div class="text-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $activityStats['reports_generated'] }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Reports Generated</div>
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

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('transcript.staff.dashboard') }}" 
                       class="flex items-center p-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        <i class="fas fa-tachometer-alt mr-3 text-gray-500"></i>
                        Dashboard
                    </a>
                    
                    @can('view_transcript_applications', $staff)
                    <a href="{{ route('transcript.staff.applications') }}" 
                       class="flex items-center p-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        <i class="fas fa-file-alt mr-3 text-gray-500"></i>
                        Applications
                    </a>
                    @endcan
                    
                    @can('view_transcript_payments', $staff)
                    <a href="{{ route('transcript.staff.payments') }}" 
                       class="flex items-center p-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        <i class="fas fa-credit-card mr-3 text-gray-500"></i>
                        Payments
                    </a>
                    @endcan
                </div>
            </div>
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