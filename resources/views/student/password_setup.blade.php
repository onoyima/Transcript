@extends('layouts.app')

@section('title', 'Password Setup')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-key"></i> Password Setup Required</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Welcome {{ $student->fname }} {{ $student->lname }}!</strong><br>
                        To complete your account setup and access the transcript system, you need to set up a password.
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="fas fa-lock"></i> Set Password Now</h5>
                                </div>
                                <div class="card-body">
                                    <p>Set up your password immediately to continue with your transcript application.</p>
                                    
                                    <form method="POST" action="{{ route('student.password.store') }}">
                                        @csrf
                                        
                                        <div class="mb-3">
                                            <label for="password" class="form-label">New Password</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" name="password" required minlength="8">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Password must be at least 8 characters long.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                                   id="password_confirmation" name="password_confirmation" required minlength="8">
                                            @error('password_confirmation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="fas fa-check"></i> Set Password & Continue
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0"><i class="fas fa-envelope"></i> Email Password Link</h5>
                                </div>
                                <div class="card-body">
                                    <p>Prefer to set up your password later? We can send you a secure link via email.</p>
                                    
                                    <form method="POST" action="{{ route('student.password.email.send') }}">
                                        @csrf
                                        
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" value="{{ $student->email }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">We'll send the password setup link to this email.</div>
                                        </div>

                                        <button type="submit" class="btn btn-info w-100">
                                            <i class="fas fa-paper-plane"></i> Send Email Link
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="card border-warning">
                            <div class="card-body">
                                <h6 class="card-title text-warning"><i class="fas fa-user-circle"></i> Your Account Information</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <strong>Name:</strong> {{ $student->fname }} {{ $student->lname }}
                                    </div>
                                    <div class="col-sm-6">
                                        <strong>Username:</strong> {{ $student->username ?: $student->email }}
                                    </div>
                                    <div class="col-sm-6">
                                        <strong>Email:</strong> {{ $student->email }}
                                    </div>
                                    <div class="col-sm-6">
                                        <strong>Phone:</strong> {{ $student->phone }}
                                    </div>
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i> 
                                    After setting up your password, you can log in using your username and password.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Password strength indicator
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const strength = document.getElementById('password-strength');
    
    if (password.length < 8) {
        this.classList.remove('is-valid');
        this.classList.add('is-invalid');
    } else {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    }
});

// Password confirmation validation
document.getElementById('password_confirmation').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmation = this.value;
    
    if (password !== confirmation) {
        this.classList.remove('is-valid');
        this.classList.add('is-invalid');
    } else if (confirmation.length >= 8) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    }
});
</script>
@endsection
