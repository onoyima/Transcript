@extends('layouts.app')

@section('title', 'Payment Failed - Transcript Application')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Error Header -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-6 text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Payment Failed</h1>
            <p class="text-lg text-gray-600 mb-4">We couldn't process your payment for the transcript application.</p>
            @if(isset($transcriptApplication))
            <div class="inline-flex items-center px-4 py-2 bg-red-100 border border-red-200 rounded-md">
                <span class="text-sm font-medium text-red-800">Application ID: #{{ $transcriptApplication->id }}</span>
            </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Error Details -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">What Happened?</h2>
                
                <div class="space-y-4">
                    @if(isset($errorMessage))
                    <div class="bg-red-50 border border-red-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Error Details</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    {{ $errorMessage }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="text-sm text-gray-600">
                        <h4 class="font-medium text-gray-800 mb-2">Common reasons for payment failure:</h4>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Insufficient funds in your account</li>
                            <li>Network connectivity issues</li>
                            <li>Card declined by your bank</li>
                            <li>Incorrect card details</li>
                            <li>Transaction timeout</li>
                        </ul>
                    </div>

                    @if(isset($paymentTransaction))
                    <div class="border-t pt-4">
                        <h4 class="font-medium text-gray-800 mb-2">Transaction Details:</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Reference:</span>
                                <span class="font-medium">{{ $paymentTransaction->transaction_reference }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Amount:</span>
                                <span class="font-medium">₦{{ number_format($paymentTransaction->amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="text-red-600 font-medium">{{ $paymentTransaction->transaction_status }}</span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Next Steps -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">What's Next?</h2>
                
                <div class="space-y-4">
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                        <h3 class="text-sm font-medium text-blue-800 mb-2">Try Again</h3>
                        <p class="text-sm text-blue-700 mb-3">
                            You can retry the payment for your transcript application. Make sure you have sufficient funds and a stable internet connection.
                        </p>
                        @if(isset($transcriptApplication))
                        <a href="{{ route('student.transcript.paystack.payment.form', $transcriptApplication->id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Retry Payment
                        </a>
                        @endif
                    </div>

                    <div class="bg-gray-50 border border-gray-200 rounded-md p-4">
                        <h3 class="text-sm font-medium text-gray-800 mb-2">Check Your Application</h3>
                        <p class="text-sm text-gray-600 mb-3">
                            View your transcript application history and payment status.
                        </p>
                        <a href="{{ route('student.transcript.history') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            View Applications
                        </a>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                        <h3 class="text-sm font-medium text-yellow-800 mb-2">Need Help?</h3>
                        <p class="text-sm text-yellow-700 mb-3">
                            If you continue to experience issues, please contact our support team.
                        </p>
                        <div class="flex space-x-3">
                            <a href="mailto:transcript@university.edu.ng" 
                               class="inline-flex items-center px-3 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Email Support
                            </a>
                            <a href="tel:+234-803-123-4567" 
                               class="inline-flex items-center px-3 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                Call Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Important Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Payment Security</h3>
                    <p class="text-sm text-gray-600">
                        Your payment information is secure and encrypted. No charges will be made to your account for failed transactions.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Application Status</h3>
                    <p class="text-sm text-gray-600">
                        Your transcript application is saved and will remain active. You can complete the payment at any time to proceed with processing.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection