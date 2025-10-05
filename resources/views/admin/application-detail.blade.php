@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Application Details</h2>
    <h3>Student Information</h3>
    <p>Name: {{ $application->student->first_name }} {{ $application->student->surname }}</p>
    <p>Email: {{ $application->student->email }}</p>
    <p>Phone: {{ $application->student->phone }}</p>
    <h3>Application Information</h3>
    <p>Application Type: {{ $application->application_type }}</p>
    <p>Status: {{ $application->application_status }}</p>
    <p>Payment Status: {{ $application->payment_status }}</p>

    <h3>Payment Information</h3>
    <p>Amount Paid: ${{ $application->amount_paid }}</p>
    <p>Payment Method: {{ $application->payment_method }}</p>

    <form method="POST" action="{{ url('/admin/application/update-status/' . $application->id) }}">
        @csrf
        <div class="form-group">
            <label for="status">Update Application Status</label>
            <select name="status" class="form-control" required>
                <option value="In Progress" {{ $application->application_status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                <option value="Completed" {{ $application->application_status == 'Completed' ? 'selected' : '' }}>Completed</option>
                <option value="Cancelled" {{ $application->application_status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Status</button>
    </form>
</div>
@endsection
