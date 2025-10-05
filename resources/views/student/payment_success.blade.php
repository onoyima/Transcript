{{-- resources/views/student/payment_success.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Payment Successful!</h2>

        <div class="alert alert-success">
            Your payment has been successfully processed.
        </div>

        <a href="{{ route('student.dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
    </div>
@endsection
