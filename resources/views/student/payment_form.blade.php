@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 lg:p-12">

    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-lg dark:border-gray-800 dark:bg-white/[0.03] lg:p-8">

        <!-- Payment Page-->
        <div class="p-5 mb-8 border-b border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                <div class="container">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Payment Form</h2>

                    @if (session('success'))
                        <div class="mt-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded-lg">
                           <span>{{ $student->fname }}! Your {{ $student->phone }} and  {{ $student->email }}  {{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mt-4 p-4 bg-red-100 text-red-700 border border-red-300 rounded-lg">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" id="paymentForm" action="{{ route('student.payment.process', ['transId' => $student->id]) }}">
                        @csrf
                        <input type="hidden" name="student_id" value="{{ $student->id }}">

                        <div class="mb-6">
                            <label for="fee_type" class="block text-sm font-medium text-gray-900 dark:text-white">Select Fee Type</label>
                            <select name="fee_type_id" id="fee_type" class="w-full p-3 mt-2 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500" required>
                                <option value="" disabled selected>Select a fee type</option>
                                @foreach ($feeTypes as $feeType)
                                    <option value="{{ $feeType->id }}" data-amount="{{ $feeType->amount }}">
                                        {{ $feeType->name }} - ₦{{ number_format($feeType->amount, 2) }} - {{ $feeType->descriptions }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-6">
                            <label for="amount" class="block text-sm font-medium text-gray-900 dark:text-white">Amount to Pay</label>
                            <input type="text" name="amount" id="amount" class="w-full p-3 mt-2 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500" readonly required />
                        </div>

                        <button type="button" id="confirmPaymentButton" class="w-full py-3 px-6 mt-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                            Proceed to Payment
                        </button>
                    </form>

                    <!-- Loader for processing state -->
                    <div id="loading" style="display:none; text-align:center;" class="mt-4">
                        <span class="text-lg text-black dark:text-white">Processing payment...</span>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>


<script>
    // When a fee type is selected, update the amount field
    document.getElementById('fee_type').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var amount = selectedOption.getAttribute('data-amount');
        document.getElementById('amount').value = amount;
    });

    // Submit the form on button click
    document.getElementById('confirmPaymentButton').addEventListener('click', function() {
        var feeType = document.getElementById('fee_type').value;
        var amount = document.getElementById('amount').value;

        if (!feeType) {
            alert('Please select a fee type.');
            return;
        }

        if (!amount) {
            alert('Please ensure the amount is valid.');
            return;
        }

        // Show loading indicator
        document.getElementById('loading').style.display = 'block';

        // Submit the form
        document.getElementById('paymentForm').submit();
    });
</script>

@endsection
