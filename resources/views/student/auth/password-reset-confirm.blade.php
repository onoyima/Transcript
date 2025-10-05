@extends('layouts.app')

@section('title', 'Reset Password - Veritas University')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="fas fa-key me-2"></i>
                        Reset Your Password
                    </h4>
                </div>
                <div class="card-body p-4">
                    <!-- Success Message -->
                    <div class="alert alert-success">
                        <h5 class="alert-heading">
                            <i class="fas fa-check-circle me-2"></i>
                            Reset Link Verified!
                        </h5>
                        <p class="mb-0">
                            Your password reset link has been verified. Please enter your new password below.
                        </p>
                    </div>

                    <!-- Student Info -->
                    <div class="alert alert-info">
                        <p class="mb-2">
                            <strong>Name:</strong> {{ $student->title }} {{ $student->lname }}, {{ $student->fname }} {{ $student->mname }}
                        </p>
                        <p class="mb-2">
                            <strong>Matric Number:</strong> {{ $student->matric_number }}
                        </p>
                        <p class="mb-0">
                            <strong>Email:</strong> {{ $student->email }}
                        </p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h6 class="alert-heading">Please correct the following errors:</h6>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Password Reset Form -->
                    <form method="POST" action="{{ route('student.password.update') }}" id="passwordResetForm">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $student->email }}">
                        
                        <div class="mb-4">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-1"></i> 
                                New Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required 
                                       minlength="8"
                                       placeholder="Enter your new password">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <!-- Password Strength Indicator -->
                            <div class="mt-2">
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small class="text-muted" id="strengthText">Password strength: <span id="strengthLevel">None</span></small>
                            </div>
                        </div>

                        <!-- Password Confirmation -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-lock me-1"></i> 
                                Confirm New Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control form-control-lg" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required 
                                       placeholder="Confirm your new password">
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                    <i class="fas fa-eye" id="toggleConfirmIcon"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback" id="confirmError" style="display: none;">
                                Passwords do not match
                            </div>
                        </div>

                        <!-- Password Requirements -->
                        <div class="mb-4">
                            <h6 class="text-primary">
                                <i class="fas fa-shield-alt me-1"></i>
                                Password Requirements:
                            </h6>
                            <ul class="list-unstyled small">
                                <li id="req-length" class="text-muted">
                                    <i class="fas fa-circle me-2"></i>
                                    At least 8 characters long
                                </li>
                                <li id="req-uppercase" class="text-muted">
                                    <i class="fas fa-circle me-2"></i>
                                    Contains uppercase letter (A-Z)
                                </li>
                                <li id="req-lowercase" class="text-muted">
                                    <i class="fas fa-circle me-2"></i>
                                    Contains lowercase letter (a-z)
                                </li>
                                <li id="req-number" class="text-muted">
                                    <i class="fas fa-circle me-2"></i>
                                    Contains number (0-9)
                                </li>
                                <li id="req-special" class="text-muted">
                                    <i class="fas fa-circle me-2"></i>
                                    Contains special character (!@#$%^&*)
                                </li>
                            </ul>
                        </div>

                        <!-- Security Notice -->
                        <div class="alert alert-warning">
                            <h6 class="alert-heading">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Important Security Information
                            </h6>
                            <ul class="mb-0 small">
                                <li>Choose a strong, unique password that you haven't used elsewhere</li>
                                <li>Don't share your password with anyone</li>
                                <li>This reset link will expire after use for security</li>
                                <li>You'll be automatically logged in after setting your password</li>
                            </ul>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-lg" id="submitBtn" disabled>
                                <i class="fas fa-check me-2"></i> 
                                Reset Password & Login
                            </button>
                            
                            <a href="{{ route('student.login') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i> 
                                Back to Login
                            </a>
                        </div>
                    </form>

                    <!-- Expiry Warning -->
                    <div class="mt-4 p-3 bg-light rounded">
                        <h6 class="text-danger mb-2">
                            <i class="fas fa-clock me-1"></i> 
                            Reset Link Expiry
                        </h6>
                        <p class="small mb-0">
                            This password reset link will expire in <strong id="timeRemaining">60 minutes</strong>. 
                            Please complete the password reset process before the link expires.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    const submitBtn = document.getElementById('submitBtn');
    const strengthBar = document.getElementById('passwordStrength');
    const strengthLevel = document.getElementById('strengthLevel');
    const confirmError = document.getElementById('confirmError');
    
    // Password visibility toggles
    document.getElementById('togglePassword').addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        document.getElementById('toggleIcon').classList.toggle('fa-eye');
        document.getElementById('toggleIcon').classList.toggle('fa-eye-slash');
    });
    
    document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
        const type = confirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmInput.setAttribute('type', type);
        document.getElementById('toggleConfirmIcon').classList.toggle('fa-eye');
        document.getElementById('toggleConfirmIcon').classList.toggle('fa-eye-slash');
    });
    
    // Password strength checker
    function checkPasswordStrength(password) {
        let score = 0;
        const requirements = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
        };
        
        // Update requirement indicators
        Object.keys(requirements).forEach(req => {
            const element = document.getElementById(`req-${req}`);
            if (requirements[req]) {
                element.classList.remove('text-muted');
                element.classList.add('text-success');
                element.querySelector('i').classList.remove('fa-circle');
                element.querySelector('i').classList.add('fa-check-circle');
                score++;
            } else {
                element.classList.remove('text-success');
                element.classList.add('text-muted');
                element.querySelector('i').classList.remove('fa-check-circle');
                element.querySelector('i').classList.add('fa-circle');
            }
        });
        
        // Update strength bar
        const percentage = (score / 5) * 100;
        strengthBar.style.width = percentage + '%';
        
        if (score === 0) {
            strengthBar.className = 'progress-bar';
            strengthLevel.textContent = 'None';
        } else if (score <= 2) {
            strengthBar.className = 'progress-bar bg-danger';
            strengthLevel.textContent = 'Weak';
        } else if (score <= 3) {
            strengthBar.className = 'progress-bar bg-warning';
            strengthLevel.textContent = 'Fair';
        } else if (score <= 4) {
            strengthBar.className = 'progress-bar bg-info';
            strengthLevel.textContent = 'Good';
        } else {
            strengthBar.className = 'progress-bar bg-success';
            strengthLevel.textContent = 'Strong';
        }
        
        return score >= 4; // Require at least 4 out of 5 criteria
    }
    
    // Password validation
    function validatePasswords() {
        const password = passwordInput.value;
        const confirm = confirmInput.value;
        
        const isStrong = checkPasswordStrength(password);
        const isMatching = password === confirm && password.length > 0;
        
        // Show/hide confirmation error
        if (confirm.length > 0 && !isMatching) {
            confirmError.style.display = 'block';
            confirmInput.classList.add('is-invalid');
        } else {
            confirmError.style.display = 'none';
            confirmInput.classList.remove('is-invalid');
        }
        
        // Enable/disable submit button
        submitBtn.disabled = !(isStrong && isMatching);
    }
    
    passwordInput.addEventListener('input', validatePasswords);
    confirmInput.addEventListener('input', validatePasswords);
    
    // Form submission
    document.getElementById('passwordResetForm').addEventListener('submit', function(e) {
        if (submitBtn.disabled) {
            e.preventDefault();
            return false;
        }
        
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Resetting Password...';
        submitBtn.disabled = true;
    });
    
    // Countdown timer for link expiry (assuming 60 minutes from page load)
    let timeLeft = 60 * 60; // 60 minutes in seconds
    const timeDisplay = document.getElementById('timeRemaining');
    
    function updateTimer() {
        const hours = Math.floor(timeLeft / 3600);
        const minutes = Math.floor((timeLeft % 3600) / 60);
        const seconds = timeLeft % 60;
        
        if (timeLeft <= 0) {
            timeDisplay.textContent = 'EXPIRED';
            timeDisplay.parentElement.classList.remove('text-danger');
            timeDisplay.parentElement.classList.add('text-danger');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-times me-2"></i> Link Expired';
            return;
        }
        
        if (hours > 0) {
            timeDisplay.textContent = `${hours}h ${minutes}m`;
        } else if (minutes > 0) {
            timeDisplay.textContent = `${minutes}m ${seconds}s`;
        } else {
            timeDisplay.textContent = `${seconds}s`;
        }
        
        timeLeft--;
    }
    
    // Update timer every second
    updateTimer();
    setInterval(updateTimer, 1000);
});
</script>
@endsection
