<!-- resources/views/student/payment.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Payment Details</h2>

    <p><strong>Student Name:</strong> {{ $remita->payerName }}</p>
    <p><strong>Amount:</strong> {{ $remita->amount }}</p>
    <p><strong>Description:</strong> {{ $remita->description }}</p>

    <form action="{{ route('remita.payment.redirect') }}" method="POST">
        @csrf
        <input type="hidden" name="orderId" value="{{ $remita->orderId }}">
        <input type="hidden" name="amount" value="{{ $remita->amount }}">
        <input type="hidden" name="rrr" value="{{ $remita->rrr }}">
        <button type="submit" class="btn btn-primary">Proceed to Payment</button>
    </form>
</div>
@endsection



{{-- resources/views/student/payment_form.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Payment Form</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form id="payment-form" method="POST" action="{{ route('student.payment.process', ['transId' => $student->id]) }}">
            @csrf
            <div class="form-group">
                <label for="fee_type">Select Fee Type</label>
                <select name="fee_type_id" id="fee_type" class="form-control" required>
                    @foreach ($feeTypes as $feeType)
                        <option value="{{ $feeType->id }}" data-amount="{{ $feeType->amount }}" data-description="{{ $feeType->descriptions }}" data-name="{{ $feeType->name }}">
                            {{ $feeType->name }} - ₦{{ number_format($feeType->amount, 2) }} - {{ $feeType->descriptions }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Hidden student details --}}
            <div id="student-details" style="display:none;">
                <input type="hidden" name="student_id" value="{{ $student->id }}">
                <input type="hidden" name="student_name" value="{{ $student->fname }} {{ $student->lname }}">
                <input type="hidden" name="student_email" value="{{ $student->email }}">
                <input type="hidden" name="student_phone" value="{{ $student->phone }}">
                <input type="hidden" name="student_matric_no" value="{{ $student->StudentAcademic->matric_no }}">
            </div>

            <button type="button" class="btn btn-primary" id="openModal" data-toggle="modal" data-target="#confirmationModal">
                Proceed to Payment
            </button>
        </form>
    </div>

    {{-- Confirmation Modal --}}
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Fee Type:</strong> <span id="fee-type-name"></span></p>
                    <p><strong>Amount:</strong> ₦<span id="fee-type-amount"></span></p>
                    <p><strong>Description:</strong> <span id="fee-type-description"></span></p>
                    <hr>
                    <p>Are you sure you want to proceed with the payment?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" id="confirm-payment" class="btn btn-primary">Yes, Proceed</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // Function to update modal content with fee type details when fee type is selected
        document.getElementById('fee_type').addEventListener('change', function () {
            var selectedOption = this.options[this.selectedIndex];

            // Get the fee type details from the selected option
            var feeTypeName = selectedOption.getAttribute('data-name');
            var feeTypeAmount = selectedOption.getAttribute('data-amount');
            var feeTypeDescription = selectedOption.getAttribute('data-description');

            // Log the values to ensure they are correct
            console.log("Selected Fee Type: ", feeTypeName);
            console.log("Amount: ", feeTypeAmount);
            console.log("Description: ", feeTypeDescription);

            // Update the modal content with the selected fee type details
            document.getElementById('fee-type-name').textContent = feeTypeName;
            document.getElementById('fee-type-amount').textContent = feeTypeAmount; // Ensure the amount is displayed correctly
            document.getElementById('fee-type-description').textContent = feeTypeDescription;
        });

        // Handle the confirmation before submitting the form
        document.getElementById('confirm-payment').addEventListener('click', function () {
            // Close the modal
            $('#confirmationModal').modal('hide');

            // Submit the form
            document.getElementById('payment-form').submit();
        });

        // Ensure the change event is triggered when the page loads
        document.addEventListener('DOMContentLoaded', function () {
            var feeTypeSelect = document.getElementById('fee_type');
            var selectedOption = feeTypeSelect.options[feeTypeSelect.selectedIndex];

            // Manually trigger the change event if a fee type is already selected on page load
            if (selectedOption) {
                // Trigger the change event to populate the modal with details
                var event = new Event('change');
                feeTypeSelect.dispatchEvent(event);
            }
        });
    </script>
@endsection
