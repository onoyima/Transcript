{{-- resources/views/student/payment_failed.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Payment Failed</h2>

        <div class="alert alert-danger">
            Unfortunately, your payment could not be processed. Please try again later.
        </div>

        <a href="{{ route('student.payment.form', ['transId' => $payment->id]) }}" class="btn btn-primary">Try Again</a>
    </div>
@endsection
