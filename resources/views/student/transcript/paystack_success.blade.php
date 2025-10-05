@extends('layouts.app')

@section('title', 'Payment Successful - Transcript Application')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Success Header -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-6 text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Payment Successful!</h1>
            <p class="text-lg text-gray-600 mb-4">Your transcript application has been submitted and payment confirmed.</p>
            <div class="inline-flex items-center px-4 py-2 bg-green-100 border border-green-200 rounded-md">
                <span class="text-sm font-medium text-green-800">Application ID: #{{ $transcriptApplication->id }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Payment Details -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Payment Details</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Transaction Reference</span>
                        <span class="text-sm font-medium text-gray-900">{{ $paymentTransaction->transaction_reference }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Amount Paid</span>
                        <span class="text-sm font-medium text-green-600">₦{{ number_format($paymentTransaction->amount, 2) }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Payment Method</span>
                        <span class="text-sm font-medium text-gray-900 capitalize">{{ $paymentTransaction->payment_method }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Payment Date</span>
                        <span class="text-sm font-medium text-gray-900">{{ $paymentTransaction->payment_date->format('M d, Y \a\t H:i A') }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2">
                        <span class="text-sm text-gray-600">Status</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            {{ ucfirst($paymentTransaction->transaction_status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Application Summary -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Application Summary</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Application Type</span>
                        <span class="text-sm font-medium text-gray-900 capitalize">{{ $transcriptApplication->application_type }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Category</span>
                        <span class="text-sm font-medium text-gray-900 capitalize">{{ $transcriptApplication->category }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Delivery Type</span>
                        <span class="text-sm font-medium text-gray-900 capitalize">{{ $transcriptApplication->type }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Destination</span>
                        <span class="text-sm font-medium text-gray-900 capitalize">{{ $transcriptApplication->destination }}</span>
                    </div>
                    
                    @if($transcriptApplication->courier)
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Courier Service</span>
                        <span class="text-sm font-medium text-gray-900 uppercase">{{ $transcriptApplication->courier }}</span>
                    </div>
                    @endif
                    
                    @if($transcriptApplication->institution_name)
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Institution</span>
                        <span class="text-sm font-medium text-gray-900">{{ $transcriptApplication->institution_name }}</span>
                    </div>
                    @endif
                    
                    <div class="flex justify-between py-2">
                        <span class="text-sm text-gray-600">Application Status</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ ucfirst(str_replace('_', ' ', $transcriptApplication->application_status)) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Information -->
        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Student Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Full Name</label>
                        <p class="text-sm text-gray-900">{{ $student->first_name }} {{ $student->middle_name }} {{ $student->surname }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600">Matriculation Number</label>
                        <p class="text-sm text-gray-900">{{ $student->matric_number }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600">Email Address</label>
                        <p class="text-sm text-gray-900">{{ $transcriptApplication->email }}</p>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Phone Number</label>
                        <p class="text-sm text-gray-900">{{ $transcriptApplication->phone }}</p>
                    </div>
                    
                    @if($transcriptApplication->purpose)
                    <div>
                        <label class="text-sm font-medium text-gray-600">Purpose</label>
                        <p class="text-sm text-gray-900">{{ $transcriptApplication->purpose }}</p>
                    </div>
                    @endif
                    
                    @if($transcriptApplication->number_of_copies)
                    <div>
                        <label class="text-sm font-medium text-gray-600">Number of Copies</label>
                        <p class="text-sm text-gray-900">{{ $transcriptApplication->number_of_copies }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-3">What happens next?</h3>
            <div class="space-y-2">
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-5 w-5 rounded-full bg-blue-200 flex items-center justify-center mt-0.5">
                        <span class="text-xs font-medium text-blue-800">1</span>
                    </div>
                    <p class="ml-3 text-sm text-blue-800">Your application will be reviewed by the academic office</p>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-5 w-5 rounded-full bg-blue-200 flex items-center justify-center mt-0.5">
                        <span class="text-xs font-medium text-blue-800">2</span>
                    </div>
                    <p class="ml-3 text-sm text-blue-800">You will receive email updates on the processing status</p>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-5 w-5 rounded-full bg-blue-200 flex items-center justify-center mt-0.5">
                        <span class="text-xs font-medium text-blue-800">3</span>
                    </div>
                    <p class="ml-3 text-sm text-blue-800">Your transcript will be prepared and delivered according to your selected option</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 mt-8">
            <a href="{{ route('student.home') }}" 
               class="flex-1 bg-blue-600 text-white text-center py-3 px-6 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 font-medium">
                Return to Dashboard
            </a>
            
            <button onclick="window.print()" 
                    class="flex-1 bg-gray-600 text-white py-3 px-6 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200 font-medium">
                Print Receipt
            </button>
            
            <a href="mailto:{{ config('mail.from.address') }}?subject=Transcript Application Inquiry - {{ $transcriptApplication->id }}" 
               class="flex-1 bg-green-600 text-white text-center py-3 px-6 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200 font-medium">
                Contact Support
            </a>
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
    
    .shadow-md {
        box-shadow: none !important;
        border: 1px solid #e5e7eb !important;
    }
}
</style>
@endsection