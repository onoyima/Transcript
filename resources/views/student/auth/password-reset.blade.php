@extends('layouts.app')

@section('title', 'Reset Password - Veritas University')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="fas fa-key me-2"></i>
                        Reset Your Password
                    </h4>
                </div>
                <div class="card-body p-4">
                    <!-- Instructions -->
                    <div class="alert alert-info">
                        <h6 class="alert-heading">
                            <i class="fas fa-info-circle me-2"></i>
                            Forgot Your Password?
                        </h6>
                        <p class="mb-0">
                            Enter your matriculation number or email address below, and we'll send you a link to reset your password.
                        </p>
                    </div>

                    @if(session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Password Reset Form -->
                    <form method="POST" action="{{ route('student.password.email') }}">
                        @csrf
                        
                        <!-- Tab Navigation -->
                        <ul class="nav nav-tabs mb-3" id="resetTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="matric-tab" data-bs-toggle="tab" data-bs-target="#matric-pane" type="button" role="tab">
                                    <i class="fas fa-id-card me-1"></i> Matric Number
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="email-tab" data-bs-toggle="tab" data-bs-target="#email-pane" type="button" role="tab">
                                    <i class="fas fa-envelope me-1"></i> Email Address
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="resetTabContent">
                            <!-- Matric Number Tab -->
                            <div class="tab-pane fade show active" id="matric-pane" role="tabpanel">
                                <div class="mb-4">
                                    <label for="matric_number" class="form-label">
                                        <i class="fas fa-id-card me-1"></i> 
                                        Matriculation Number <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control form-control-lg @error('matric_number') is-invalid @enderror" 
                                           id="matric_number" 
                                           name="matric_number" 
                                           value="{{ old('matric_number') }}" 
                                           placeholder="Enter your matriculation number"
                                           style="text-transform: uppercase;">
                                    @error('matric_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Enter your matriculation number (e.g., VU/2020/CSC/001)
                                    </div>
                                </div>
                            </div>

                            <!-- Email Tab -->
                            <div class="tab-pane fade" id="email-pane" role="tabpanel">
                                <div class="mb-4">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-1"></i> 
                                        Email Address <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" 
                                           class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           placeholder="Enter your email address">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Enter the email address associated with your account
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Security Check -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="security_check" name="security_check" required>
                                <label class="form-check-label" for="security_check">
                                    I confirm that I am the rightful owner of this account and I have access to the associated email address.
                                </label>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-lg" id="submitBtn">
                                <i class="fas fa-paper-plane me-2"></i> 
                                Send Reset Link
                            </button>
                            
                            <a href="{{ route('student.login') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i> 
                                Back to Login
                            </a>
                            
                            <a href="{{ route('student.home') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-home me-2"></i> 
                                Back to Home
                            </a>
                        </div>
                    </form>

                    <!-- Help Section -->
                    <div class="mt-4 p-3 bg-light rounded">
                        <h6 class="text-primary mb-2">
                            <i class="fas fa-question-circle me-1"></i> 
                            Need Help?
                        </h6>
                        <p class="mb-2 small">
                            If you're having trouble resetting your password:
                        </p>
                        <ul class="small mb-0">
                            <li>Make sure you're using the correct matriculation number format</li>
                            <li>Check your spam/junk folder for the reset email</li>
                            <li>Contact IT Support: <strong>support@veritas.edu.ng</strong></li>
                            <li>Visit the Student Affairs Office for assistance</li>
                        </ul>
                    </div>

                    <!-- Security Notice -->
                    <div class="mt-3 p-3 border border-warning rounded">
                        <h6 class="text-warning mb-2">
                            <i class="fas fa-shield-alt me-1"></i> 
                            Security Notice
                        </h6>
                        <p class="small mb-0">
                            For your security, password reset links expire after 1 hour. 
                            If you didn't request this reset, please ignore this email or contact support immediately.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const matricInput = document.getElementById('matric_number');
    const emailInput = document.getElementById('email');
    const submitBtn = document.getElementById('submitBtn');
    const form = document.querySelector('form');
    
    // Auto-uppercase matric number
    matricInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
    
    // Tab switching logic
    const tabs = document.querySelectorAll('#resetTabs button');
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Clear the other input when switching tabs
            if (this.id === 'matric-tab') {
                emailInput.value = '';
                emailInput.removeAttribute('required');
                matricInput.setAttribute('required', 'required');
            } else {
                matricInput.value = '';
                matricInput.removeAttribute('required');
                emailInput.setAttribute('required', 'required');
            }
        });
    });
    
    // Form submission
    form.addEventListener('submit', function(e) {
        const activeTab = document.querySelector('#resetTabs .nav-link.active');
        
        // Validate that the correct field is filled
        if (activeTab.id === 'matric-tab' && !matricInput.value.trim()) {
            e.preventDefault();
            alert('Please enter your matriculation number.');
            matricInput.focus();
            return false;
        }
        
        if (activeTab.id === 'email-tab' && !emailInput.value.trim()) {
            e.preventDefault();
            alert('Please enter your email address.');
            emailInput.focus();
            return false;
        }
        
        // Clear the inactive field to avoid validation conflicts
        if (activeTab.id === 'matric-tab') {
            emailInput.value = '';
        } else {
            matricInput.value = '';
        }
        
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Sending...';
        submitBtn.disabled = true;
    });
    
    // Set initial required attribute
    matricInput.setAttribute('required', 'required');
});
</script>
@endsection
