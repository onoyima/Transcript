@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-green-400 to-green-600 dark:from-green-600 dark:to-green-800 bg-gray-50 dark:bg-gray-800  rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6 relative overflow-hidden">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-100 dark:text-white mb-2">
                        Welcome back, {{ $student->fname }} {{ $student->lname }}! 👋
                    </h1>
                <p class="text-gray-900 dark:text-gray-100 mb-4">
                    Here's an overview of your transcript application status and account information.
                </p>
                @if($academicInfo)
                <div class="flex flex-wrap gap-4 text-sm text-gray-600 dark:text-primary-400">
                    <div class="flex items-center">
                        <i class="fas fa-id-card mr-2 text-primary-600"></i>
                        <span class="font-medium">{{ $academicInfo->matric_no }}</span>
                    </div>
                    @if($academicInfo->program)
                    <div class="flex items-center">
                        <i class="fas fa-graduation-cap mr-2 text-primary-600"></i>
                        <span>{{ $academicInfo->program->name ?? 'N/A' }}</span>
                    </div>
                    @endif
                    <div class="flex items-center">
                        <i class="fas fa-layer-group mr-2 text-primary-600"></i>
                        <span>Level {{ $academicInfo->level ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope mr-2 text-primary-600"></i>
                        <span>{{ $student->username }}</span>
                    </div>
                </div>
                @endif
            </div>
            <div class="hidden md:block ml-6">
                <div class="w-20 h-20 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-3xl text-primary-600 dark:text-primary-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Applications -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Total Applications</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_applications'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-alt text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
        </div>

        <!-- Pending Applications -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Pending</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['pending_applications'] }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 dark:text-yellow-400"></i>
                </div>
            </div>
        </div>

        <!-- Completed Applications -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Completed</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['completed_applications'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                </div>
            </div>
        </div>

        <!-- Total Paid -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Total Paid</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">₦{{ number_format($stats['total_paid'], 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-naira-sign text-purple-600 dark:text-purple-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('student.transcript.create') }}" 
               class="flex items-center p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-200/50 dark:border-gray-700/50 hover:shadow-md transition-all duration-200 group">
                <div class="w-10 h-10 bg-primary-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                    <i class="fas fa-plus text-white"></i>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900 dark:text-white">New Application</h3>
                    <p class="text-sm text-gray-900 dark:text-gray-100">Start a new transcript request</p>
                </div>
            </a>

            <a href="{{ route('student.transcript.history') }}" 
               class="flex items-center p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-200/50 dark:border-gray-700/50 hover:shadow-md transition-all duration-200 group">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                    <i class="fas fa-history text-white"></i>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900 dark:text-white">View History</h3>
                    <p class="text-sm text-gray-900 dark:text-gray-100">Check application status</p>
                </div>
            </a>

            <a href="{{ route('student.profile') }}" 
               class="flex items-center p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-200/50 dark:border-gray-700/50 hover:shadow-md transition-all duration-200 group">
                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                    <i class="fas fa-user text-white"></i>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900 dark:text-white">Update Profile</h3>
                    <p class="text-sm text-gray-900 dark:text-gray-100">Manage your information</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Applications -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200/50 dark:border-gray-700/50">
        <div class="p-6 border-b border-gray-200/50 dark:border-gray-700/50">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Applications</h2>
                <a href="{{ route('student.transcript.history') }}" 
                   class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 text-sm font-medium">
                    View All
                </a>
            </div>
        </div>
        
        <div class="p-6">
            @if($studentTrans->count() > 0)
                <div class="space-y-4">
                    @foreach($studentTrans->take(5) as $transaction)
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center
                                    @if($transaction->status == 'completed') bg-green-100 dark:bg-green-900/20
                                    @elseif($transaction->status == 'processing') bg-blue-100 dark:bg-blue-900/20
                                    @elseif($transaction->status == 'pending') bg-yellow-100 dark:bg-yellow-900/20
                                    @else bg-gray-100 dark:bg-gray-900/20
                                    @endif">
                                    <i class="fas fa-file-alt 
                                        @if($transaction->status == 'completed') text-green-600 dark:text-green-400
                                        @elseif($transaction->status == 'processing') text-blue-600 dark:text-blue-400
                                        @elseif($transaction->status == 'pending') text-yellow-600 dark:text-yellow-400
                                        @else text-gray-800 dark:text-gray-300
                                        @endif"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900 dark:text-white">{{ $transaction->transcript_type ?? 'Official Transcript' }}</h3>
                                    <p class="text-sm text-gray-900 dark:text-gray-100">Applied on {{ $transaction->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($transaction->status == 'completed') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400
                                    @elseif($transaction->status == 'processing') bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400
                                    @elseif($transaction->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400
                                    @else bg-gray-100 text-gray-900 dark:bg-gray-900/20 dark:text-gray-100
                                    @endif">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                                <p class="text-sm text-gray-900 dark:text-gray-100 mt-1">₦{{ number_format($transaction->amount, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-file-alt text-gray-800 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Applications Yet</h3>
                    <p class="text-gray-900 dark:text-gray-100 mb-6">You haven't submitted any transcript applications yet.</p>
                    <a href="{{ route('student.transcript.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Start Your First Application
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
