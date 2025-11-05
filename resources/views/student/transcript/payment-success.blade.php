@extends('layouts.app')

@section('title', 'Payment Successful')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Header -->
        <div class="text-center mb-8">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 dark:bg-green-900/20 mb-4">
                <svg class="h-8 w-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Payment Successful!</h1>
            <p class="mt-2 text-gray-900 dark:text-white">Your transcript application payment has been processed successfully</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Payment Details -->
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Payment Details</h2>
                
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-900 dark:text-white">Transaction Reference:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $payment->rrr }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-900 dark:text-white">Amount Paid:</span>
                        <span class="font-medium text-green-600 dark:text-green-400">₦{{ number_format($payment->amount, 2) }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-900 dark:text-white">Payment Date:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $payment->updated_at->format('M d, Y h:i A') }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-900 dark:text-white">Status:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                            Successful
                        </span>
                    </div>
                </div>
            </div>

            <!-- Application Status -->
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Application Status</h2>
                
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-900 dark:text-white">Application ID:</span>
                        <span class="font-medium text-gray-900 dark:text-white">#{{ $transcriptApplication->id }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-900 dark:text-white">Current Status:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">
                            {{ $transcriptApplication->payment_status }}
                        </span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-900 dark:text-white">Category:</span>
                        <span class="font-medium text-gray-900 dark:text-white capitalize">{{ $transcriptApplication->category }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-900 dark:text-white">Type:</span>
                        <span class="font-medium text-gray-900 dark:text-white capitalize">{{ $transcriptApplication->type }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-900 dark:text-white">Number of Copies:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $transcriptApplication->number_of_copies }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
            <h3 class="text-lg font-medium text-blue-900 dark:text-blue-200 mb-4">What happens next?</h3>
            <div class="space-y-3 text-blue-700 dark:text-blue-300">
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-5 w-5 rounded-full bg-blue-200 dark:bg-blue-800 flex items-center justify-center mt-0.5 mr-3">
                        <span class="text-xs font-medium text-blue-800 dark:text-blue-200">1</span>
                    </div>
                    <p>Your transcript application will be reviewed by our academic records team</p>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-5 w-5 rounded-full bg-blue-200 dark:bg-blue-800 flex items-center justify-center mt-0.5 mr-3">
                        <span class="text-xs font-medium text-blue-800 dark:text-blue-200">2</span>
                    </div>
                    <p>Once approved, your transcript will be prepared and processed</p>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-5 w-5 rounded-full bg-blue-200 dark:bg-blue-800 flex items-center justify-center mt-0.5 mr-3">
                        <span class="text-xs font-medium text-blue-800 dark:text-blue-200">3</span>
                    </div>
                    <p>You will receive email notifications about status updates</p>
                </div>
                @if($transcriptApplication->courier)
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-5 w-5 rounded-full bg-blue-200 dark:bg-blue-800 flex items-center justify-center mt-0.5 mr-3">
                        <span class="text-xs font-medium text-blue-800 dark:text-blue-200">4</span>
                    </div>
                    <p>Your transcript will be delivered via {{ ucfirst($transcriptApplication->courier) }} to your specified address</p>
                </div>
                @else
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-5 w-5 rounded-full bg-blue-200 dark:bg-blue-800 flex items-center justify-center mt-0.5 mr-3">
                        <span class="text-xs font-medium text-blue-800 dark:text-blue-200">4</span>
                    </div>
                    <p>Your transcript will be ready for pickup at the academic records office</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex flex-col sm:flex-row gap-4">
            <a href="{{ route('student.transcript.progress', $transcriptApplication->id) }}" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 text-center">
                Track Application Progress
            </a>
            <a href="{{ route('student.transcript.history') }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 text-center">
                View Application History
            </a>
            <a href="{{ route('student.transcript.create') }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 text-center">
                Apply for Another Transcript
            </a>
            <a href="{{ route('student.dashboard') }}" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 text-center">
                Back to Dashboard
            </a>
        </div>

        <!-- Print Receipt -->
        <div class="mt-6 text-center">
            <button onclick="window.print()" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-black dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200">
                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print Receipt
            </button>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        background: white !important;
    }
    
    .bg-gray-50, .bg-gray-900 {
        background: white !important;
    }
    
    .bg-white, .bg-gray-800 {
        background: white !important;
        border: 1px solid #e5e7eb !important;
    }
    
    .text-gray-900, .text-white {
        color: black !important;
    }
    
    .text-black, .text-black {
        color: #6b7280 !important;
    }
}
</style>
@endsection
