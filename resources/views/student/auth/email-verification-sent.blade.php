@extends('layouts.app')

@section('title', 'Email Verification Sent - Veritas University')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-envelope-open me-2"></i>
                        Email Verification Sent
                    </h4>
                </div>
                <div class="card-body p-4 text-center">
                    <!-- Success Icon -->
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>

                    <!-- Main Message -->
                    <h5 class="text-success mb-3">Verification Email Sent Successfully!</h5>
                    
                    <div class="alert alert-info">
                        <p class="mb-2">
                            <strong>We've sent a verification email to:</strong>
                        </p>
                        <p class="h6 text-primary">{{ $email }}</p>
                    </div>

                    <!-- Instructions -->
                    <div class="text-start mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-list-check me-2"></i>
                            Next Steps:
                        </h6>
                        <ol class="list-group list-group-numbered">
                            <li class="list-group-item d-flex align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Check Your Email</div>
                                    Look for an email from Veritas University in your inbox
                                </div>
                                <span class="badge bg-primary rounded-pill">1</span>
                            </li>
                            <li class="list-group-item d-flex align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Click Verification Link</div>
                                    Click the verification link in the email to verify your account
                                </div>
                                <span class="badge bg-primary rounded-pill">2</span>
                            </li>
                            <li class="list-group-item d-flex align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Set Your Password</div>
                                    You'll be prompted to set a secure password for your account
                                </div>
                                <span class="badge bg-primary rounded-pill">3</span>
                            </li>
                            <li class="list-group-item d-flex align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Login & Apply</div>
                                    Login with your credentials and proceed with your transcript application
                                </div>
                                <span class="badge bg-primary rounded-pill">4</span>
                            </li>
                        </ol>
                    </div>

                    <!-- Important Notes -->
                    <div class="alert alert-warning text-start">
                        <h6 class="alert-heading">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Important Notes:
                        </h6>
                        <ul class="mb-0">
                            <li>The verification link will expire in <strong>24 hours</strong></li>
                            <li>Check your spam/junk folder if you don't see the email</li>
                            <li>You can request a new verification email if needed</li>
                            <li>Keep your login credentials secure</li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2 mt-4">
                        <form method="POST" action="{{ route('student.verification.resend') }}" class="d-inline">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">
                            <button type="submit" class="btn btn-outline-primary btn-lg w-100" id="resendBtn">
                                <i class="fas fa-redo me-2"></i>
                                Resend Verification Email
                            </button>
                        </form>
                        
                        <a href="{{ route('student.login') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Go to Login Page
                        </a>
                        
                        <a href="{{ route('student.home') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-home me-2"></i>
                            Back to Home
                        </a>
                    </div>

                    <!-- Help Section -->
                    <div class="mt-4 p-3 bg-light rounded text-start">
                        <h6 class="text-primary mb-2">
                            <i class="fas fa-question-circle me-1"></i> 
                            Need Help?
                        </h6>
                        <p class="mb-2 small">
                            If you're having trouble receiving the verification email or accessing your account:
                        </p>
                        <ul class="small mb-0">
                            <li>Contact IT Support: <strong>support@veritas.edu.ng</strong></li>
                            <li>Call: <strong>+234-XXX-XXX-XXXX</strong></li>
                            <li>Visit the Student Affairs Office during business hours</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle resend button
    const resendBtn = document.getElementById('resendBtn');
    const resendForm = resendBtn.closest('form');
    
    resendForm.addEventListener('submit', function(e) {
        resendBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Sending...';
        resendBtn.disabled = true;
        
        // Re-enable button after 30 seconds to prevent spam
        setTimeout(function() {
            resendBtn.innerHTML = '<i class="fas fa-redo me-2"></i> Resend Verification Email';
            resendBtn.disabled = false;
        }, 30000);
    });
    
    // Auto-refresh page every 30 seconds to check if user has verified
    let refreshCount = 0;
    const maxRefresh = 10; // Stop after 5 minutes
    
    function checkVerificationStatus() {
        if (refreshCount < maxRefresh) {
            refreshCount++;
            // You could add an AJAX call here to check verification status
            // For now, we'll just show a message
            console.log('Checking verification status...');
        }
    }
    
    // Check every 30 seconds
    setInterval(checkVerificationStatus, 30000);
});
</script>
@endsection
