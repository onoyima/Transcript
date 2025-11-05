@extends('layouts.app')

@section('title', 'Transcript Payment')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Transcript Payment</h1>
            <p class="mt-2 text-gray-900 dark:text-white">Complete your payment to process your transcript application</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Application Details -->
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Application Details</h2>
                
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-900 dark:text-white">Application ID:</span>
                        <span class="font-medium text-gray-900 dark:text-white">#{{ $transcriptApplication->id }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-900 dark:text-white">Category:</span>
                        <span class="font-medium text-gray-900 dark:text-white capitalize">{{ $transcriptApplication->category }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-900 dark:text-white">Type:</span>
                        <span class="font-medium text-gray-900 dark:text-white capitalize">{{ $transcriptApplication->type }}</span>
                    </div>
                    
                    @if($transcriptApplication->destination)
                    <div class="flex justify-between">
                        <span class="text-gray-900 dark:text-white">Destination:</span>
                        <span class="font-medium text-gray-900 dark:text-white capitalize">{{ $transcriptApplication->destination }}</span>
                    </div>
                    @endif
                    
                    @if($transcriptApplication->courier)
                    <div class="flex justify-between">
                        <span class="text-gray-900 dark:text-white">Courier:</span>
                        <span class="font-medium text-gray-900 dark:text-white capitalize">{{ $transcriptApplication->courier }}</span>
                    </div>
                    @endif
                    
                    <div class="flex justify-between">
                        <span class="text-gray-900 dark:text-white">Number of Copies:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $transcriptApplication->number_of_copies }}</span>
                    </div>
                    
                    @if($transcriptApplication->institution_name)
                    <div class="flex justify-between">
                        <span class="text-gray-900 dark:text-white">Institution:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $transcriptApplication->institution_name }}</span>
                    </div>
                    @endif
                    
                    <div class="border-t pt-4">
                        <div class="flex justify-between text-lg font-semibold">
                            <span class="text-gray-900 dark:text-white">Total Amount:</span>
                            <span class="text-blue-600 dark:text-blue-400">₦{{ number_format($transcriptApplication->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Payment Information</h2>
                
                @if($existingPayment && $existingPayment->transaction_status === 'RRR_Generated')
                    <!-- Show existing RRR -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
                        <h3 class="text-lg font-medium text-blue-900 dark:text-blue-200 mb-2">Payment Reference Generated</h3>
                        <p class="text-blue-700 dark:text-blue-300 mb-4">Your payment reference (RRR) has been generated. Use this reference to make payment through any of the available channels.</p>
                        
                        <div class="bg-white dark:bg-gray-700 rounded-lg p-4 border">
                            <div class="text-center">
                                <p class="text-sm text-gray-900 dark:text-white mb-1">Payment Reference (RRR)</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white tracking-wider">{{ $existingPayment->rrr }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <p class="text-sm text-blue-700 dark:text-blue-300 mb-2">Payment Options:</p>
                            <ul class="text-sm text-blue-600 dark:text-blue-400 space-y-1">
                                <li>• Online Banking</li>
                                <li>• Bank Branch</li>
                                <li>• ATM</li>
                                <li>• Mobile Banking</li>
                                <li>• POS Terminal</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="flex space-x-4">
                        <a href="{{ route('student.transcript.history') }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 text-center">
                            Back to History
                        </a>
                        <a href="{{ route('student.transcript.payment.verify', $existingPayment->rrr) }}" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 text-center">
                            Verify Payment
                        </a>
                    </div>
                @else
                    <!-- Generate RRR Form -->
                    <form method="POST" action="{{ route('student.transcript.payment.process', $transcriptApplication->id) }}" id="paymentForm">
                        @csrf
                        <input type="hidden" name="transcript_id" value="{{ $transcriptApplication->id }}">
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-black dark:text-gray-300 mb-2">Student Name</label>
                                <p class="text-gray-900 dark:text-white font-medium">{{ $student->fname }} {{ $student->mname }} {{ $student->lname }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-black dark:text-gray-300 mb-2">Email</label>
                                <p class="text-gray-900 dark:text-white">{{ $transcriptApplication->email }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-black dark:text-gray-300 mb-2">Phone</label>
                                <p class="text-gray-900 dark:text-white">{{ $transcriptApplication->phone }}</p>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-medium text-gray-900 dark:text-white">Amount to Pay:</span>
                                    <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">₦{{ number_format($transcriptApplication->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8 flex space-x-4">
                            <a href="{{ route('student.transcript.history') }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200 text-center">
                                Cancel
                            </a>
                            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200" id="generateRRRBtn">
                                <span id="btnText">Generate Payment Reference</span>
                                <span id="btnSpinner" class="hidden">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Generating...
                                </span>
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('paymentForm')?.addEventListener('submit', function() {
    const btn = document.getElementById('generateRRRBtn');
    const btnText = document.getElementById('btnText');
    const btnSpinner = document.getElementById('btnSpinner');
    
    btn.disabled = true;
    btnText.classList.add('hidden');
    btnSpinner.classList.remove('hidden');
});
</script>
@endsection
