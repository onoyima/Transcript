@extends('layouts.app')

@section('title', 'Application History')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Application History</h1>
                    <p class="text-gray-900 dark:text-gray-300 mt-1">Track your transcript application status</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('student.transcript.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-plus mr-2"></i>
                        New Application
                    </a>
                    <a href="{{ route('student.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-900 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Filter and Search -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="status_filter" class="block text-sm font-medium text-gray-900 mb-2">Status</label>
                    <select id="status_filter" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="ready">Ready</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div>
                    <label for="type_filter" class="block text-sm font-medium text-gray-900 mb-2">Type</label>
                    <select id="type_filter" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Types</option>
                        <option value="undergraduate">Undergraduate</option>
                        <option value="postgraduate">Postgraduate</option>
                    </select>
                </div>
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-900 mb-2">From Date</label>
                    <input type="date" id="date_from" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-900 mb-2">To Date</label>
                    <input type="date" id="date_to" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
        </div>

        <!-- Applications List -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6">
                <div class="space-y-4" id="applicationsList">
                    @forelse($applications as $application)
                    @php
                        $statusColors = [
                            'Started' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon' => 'bg-yellow-100 text-yellow-600'],
                            'In Progress' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => 'bg-blue-100 text-blue-600'],
                            'Completed' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => 'bg-green-100 text-green-600']
                        ];
                        $currentStatus = $statusColors[$application->application_status] ?? $statusColors['Started'];
                        
                        $progressPercentage = match($application->application_status) {
                            'Started' => 25,
                            'In Progress' => 60,
                            'Completed' => 100,
                            default => 25
                        };
                    @endphp
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 {{ $currentStatus['icon'] }} rounded-full flex items-center justify-center">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-3">
                                            <h3 class="text-lg font-medium text-gray-900 capitalize">{{ $application->application_type }} Transcript</h3>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $currentStatus['bg'] }} {{ $currentStatus['text'] }}">
                                                {{ $application->application_status }}
                                            </span>
                                        </div>
                                        <div class="mt-1 flex items-center space-x-4 text-sm text-gray-600">
                                            <span><i class="fas fa-calendar mr-1"></i>Applied: {{ $application->created_at->format('M d, Y') }}</span>
                                            <span><i class="fas fa-{{ $application->type === 'physical' ? 'truck' : 'download' }} mr-1"></i>{{ ucfirst(str_replace('_', ' ', $application->destination)) }}</span>
                                            <span><i class="fas fa-copy mr-1"></i>{{ $application->number_of_copies }} {{ $application->number_of_copies == 1 ? 'Copy' : 'Copies' }}</span>
                                            <span><i class="fas fa-naira-sign mr-1"></i>₦{{ number_format($application->total_amount, 2) }}</span>
                                        </div>
                                        @if($application->purpose)
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-900">Purpose: {{ $application->purpose }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('student.transcript.progress', $application->id) }}" class="inline-flex items-center px-3 py-1.5 border border-indigo-300 rounded-md text-sm font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <i class="fas fa-chart-line mr-1"></i>
                                    Track Progress
                                </a>
                                <a href="{{ route('student.transcript.show', $application->id) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-sm font-medium text-gray-900 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-eye mr-1"></i>
                                    View Details
                                </a>
                                @if($application->payment_status === 'Pending')
                                <a href="{{ route('student.transcript.paystack.payment.form', $application->id) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-credit-card mr-1"></i>
                                    Pay Now
                                </a>
                                @endif
                            </div>
                        </div>
                        <!-- Progress Bar -->
                        <div class="mt-4">
                            <div class="flex items-center justify-between text-sm text-gray-900 mb-2">
                                <span>Application Progress</span>
                                <span>{{ $progressPercentage }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="h-2 rounded-full {{ $application->application_status === 'Completed' ? 'bg-green-600' : 'bg-blue-600' }}" style="width: {{ $progressPercentage }}%"></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                <span>Submitted</span>
                                <span>Processing</span>
                                <span>Ready</span>
                                <span>{{ $application->type === 'physical' ? 'Collected' : 'Downloaded' }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-file-alt text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No applications found</h3>
                        <p class="text-gray-600 mb-6">You haven't submitted any transcript applications yet.</p>
                        <a href="{{ route('student.transcript.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-plus mr-2"></i>
                            Submit Your First Application
                        </a>
                    </div>
                    @endforelse
                </div>

                <!-- Empty State (hidden by default) -->
                <div id="emptyState" class="text-center py-12 hidden">
                    <div class="w-24 h-24 mx-auto bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-file-alt text-gray-700 dark:text-gray-300 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No applications found</h3>
                    <p class="text-gray-700 dark:text-gray-300 mb-6">You haven't submitted any transcript applications yet.</p>
                    <a href="{{ route('student.transcript.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-plus mr-2"></i>
                        Submit Your First Application
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const statusFilter = document.getElementById('status_filter');
    const typeFilter = document.getElementById('type_filter');
    const dateFromFilter = document.getElementById('date_from');
    const dateToFilter = document.getElementById('date_to');
    
    // Add event listeners for filters
    [statusFilter, typeFilter, dateFromFilter, dateToFilter].forEach(filter => {
        filter.addEventListener('change', applyFilters);
    });
    
    function applyFilters() {
        // This would typically make an AJAX request to filter applications
        console.log('Applying filters...');
    }
});
</script>
@endsection
