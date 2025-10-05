@extends('layouts.app')

@section('title', 'Update Email - Veritas University')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-envelope me-2"></i>
                        Update Your Email Address
                    </h4>
                </div>
                <div class="card-body p-4">
                    <!-- Student Info Display -->
                    <div class="alert alert-success">
                        <h5 class="alert-heading">
                            <i class="fas fa-check-circle me-2"></i>
                            Matriculation Number Verified!
                        </h5>
                        <p class="mb-2">
                            <strong>Name:</strong> {{ $student->title }} {{ $student->lname }}, {{ $student->fname }} {{ $student->mname }}
                        </p>
                        <p class="mb-0">
                            <strong>Current Email:</strong> 
                            @if($student->email)
                                {{ $student->email }}
                            @else
                                <span class="text-muted">No email on record</span>
                            @endif
                        </p>
                    </div>

                    <!-- Security Notice -->
                    <div class="alert alert-warning">
                        <h6 class="alert-heading">
                            <i class="fas fa-shield-alt me-2"></i>
                            Security Requirement
                        </h6>
                        <p class="mb-0">
                            For security purposes, you must verify your email address before proceeding with your transcript application. 
                            Please provide a valid email address where you can receive verification instructions.
                        </p>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Email Update Form -->
                    <form method="POST" action="{{ route('student.email.update') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-1"></i> 
                                Email Address <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $student->email) }}" 
                                   required 
                                   placeholder="Enter your email address">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Make sure you have access to this email address. We'll send a verification link here.
                            </div>
                        </div>

                        <!-- Email Confirmation -->
                        <div class="mb-4">
                            <label for="email_confirmation" class="form-label">
                                <i class="fas fa-envelope-open me-1"></i> 
                                Confirm Email Address <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control form-control-lg" 
                                   id="email_confirmation" 
                                   name="email_confirmation" 
                                   required 
                                   placeholder="Confirm your email address">
                            <div class="form-text">
                                Please re-enter your email address to confirm.
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">
                                    I confirm that this email address belongs to me and I have access to it. 
                                    I understand that I will need to verify this email before proceeding.
                                </label>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                                <i class="fas fa-paper-plane me-2"></i> 
                                Update Email & Send Verification
                            </button>
                            
                            <a href="{{ route('student.home') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i> 
                                Back to Home
                            </a>
                        </div>
                    </form>

                    <!-- What Happens Next -->
                    <div class="mt-4 p-3 bg-light rounded">
                        <h6 class="text-primary mb-2">
                            <i class="fas fa-list-ol me-1"></i> What happens next?
                        </h6>
                        <ol class="mb-0 small">
                            <li>We'll send a verification email to your provided address</li>
                            <li>Click the verification link in the email</li>
                            <li>Once verified, you can log in and proceed with your transcript application</li>
                            <li>You can then apply for multiple transcripts as needed (each requires payment)</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    const confirmInput = document.getElementById('email_confirmation');
    const submitBtn = document.getElementById('submitBtn');
    
    function validateEmails() {
        if (emailInput.value && confirmInput.value) {
            if (emailInput.value !== confirmInput.value) {
                confirmInput.setCustomValidity('Email addresses do not match');
                confirmInput.classList.add('is-invalid');
            } else {
                confirmInput.setCustomValidity('');
                confirmInput.classList.remove('is-invalid');
            }
        }
    }
    
    emailInput.addEventListener('input', validateEmails);
    confirmInput.addEventListener('input', validateEmails);
    
    // Form submission handling
    document.querySelector('form').addEventListener('submit', function(e) {
        if (emailInput.value !== confirmInput.value) {
            e.preventDefault();
            alert('Email addresses do not match. Please check and try again.');
            return false;
        }
        
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Sending...';
        submitBtn.disabled = true;
    });
});
</script>
@endsection
