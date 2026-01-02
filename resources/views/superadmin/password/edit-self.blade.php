@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary rounded-circle p-3 me-3">
                            <i class="fas fa-key text-white" style="font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <h4 class="card-title mb-1 fw-bold text-dark">Change Your Password</h4>
                            <p class="text-muted mb-0">Create a strong, secure password</p>
                        </div>
                    </div>
                </div>
                
                <div class="card-body px-4 px-md-5 pt-4">
                    <form method="POST" action="{{ route('superadmin.password.updateSelf') }}" id="passwordForm">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold text-dark mb-2">
                                New Password
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="form-control form-control-lg border-2 py-3"
                                       placeholder="Enter new password" 
                                       required
                                       autocomplete="new-password">
                                <button class="btn btn-outline-secondary border-2 border-start-0" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="mt-2">
                                <div class="password-strength">
                                    <div class="strength-bar d-flex gap-1 mb-1">
                                        <div class="flex-fill" style="height: 4px; background-color: #e9ecef;"></div>
                                        <div class="flex-fill" style="height: 4px; background-color: #e9ecef;"></div>
                                        <div class="flex-fill" style="height: 4px; background-color: #e9ecef;"></div>
                                        <div class="flex-fill" style="height: 4px; background-color: #e9ecef;"></div>
                                    </div>
                                    <small class="text-muted" id="passwordHint">
                                        Use 8+ characters with mix of letters, numbers & symbols
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold text-dark mb-2">
                                Confirm Password
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       class="form-control form-control-lg border-2 py-3"
                                       placeholder="Confirm your password" 
                                       required
                                       autocomplete="new-password">
                                <button class="btn btn-outline-secondary border-2 border-start-0" type="button" id="toggleConfirmPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div id="passwordMatch" class="mt-2"></div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <h6 class="fw-semibold mb-3">Password Requirements</h6>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span>Minimum 8 characters</span>
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span>Include uppercase & lowercase letters</span>
                                        </li>
                                        <li>
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span>Include numbers or special characters</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-primary btn-lg py-3 fw-semibold shadow-sm">
                                <i class="fas fa-save me-2"></i>
                                Update Password
                            </button>
                        </div>
                        
                        <div class="text-center">
                            <a href="#" class="text-decoration-none text-muted">
                                <i class="fas fa-question-circle me-1"></i>
                                Need help?
                            </a>
                        </div>
                    </form>
                </div>
                
                @if(session('success'))
                    <div class="card-footer bg-white border-0 pb-4">
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-0" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-3" style="font-size: 1.2rem;"></i>
                                <div class="flex-grow-1">
                                    <h6 class="alert-heading mb-1">Success!</h6>
                                    <p class="mb-0">{{ session('success') }}</p>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            @if($errors->any())
                <div class="mt-4">
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-3" style="font-size: 1.2rem;"></i>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading mb-1">Please correct the following:</h6>
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 1rem;
        overflow: hidden;
        margin-top: 90px;
    }
    
    .card-header {
        border-bottom: 2px solid #f8f9fa;
    }
    
    .form-control:focus {
        border-color: #4a6cf7;
        box-shadow: 0 0 0 0.25rem rgba(74, 108, 247, 0.1);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #4a6cf7 0%, #6a11cb 100%);
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(74, 108, 247, 0.3);
    }
    
    .input-group .btn-outline-secondary {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
    
    .input-group .btn-outline-secondary:hover {
        background-color: #e9ecef;
    }
    
    .strength-bar div {
        border-radius: 2px;
        transition: all 0.3s ease;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const togglePassword = document.getElementById('togglePassword');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const strengthBars = document.querySelectorAll('.strength-bar div');
        const passwordHint = document.getElementById('passwordHint');
        const passwordMatch = document.getElementById('passwordMatch');
        
        // Toggle password visibility
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });
        
        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });
        
        // Password strength indicator
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password) && /[a-z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            // Update strength bars
            strengthBars.forEach((bar, index) => {
                if (index < strength) {
                    let color;
                    switch(strength) {
                        case 1: color = '#dc3545'; break;
                        case 2: color = '#fd7e14'; break;
                        case 3: color = '#ffc107'; break;
                        case 4: color = '#28a745'; break;
                        default: color = '#e9ecef';
                    }
                    bar.style.backgroundColor = color;
                } else {
                    bar.style.backgroundColor = '#e9ecef';
                }
            });
            
            // Update hint text
            if (password.length === 0) {
                passwordHint.textContent = 'Use 8+ characters with mix of letters, numbers & symbols';
                passwordHint.className = 'text-muted';
            } else if (strength <= 1) {
                passwordHint.textContent = 'Weak password - try adding more characters';
                passwordHint.className = 'text-danger';
            } else if (strength <= 2) {
                passwordHint.textContent = 'Fair password - could be stronger';
                passwordHint.className = 'text-warning';
            } else if (strength <= 3) {
                passwordHint.textContent = 'Good password - almost there';
                passwordHint.className = 'text-info';
            } else {
                passwordHint.textContent = 'Strong password - excellent!';
                passwordHint.className = 'text-success';
            }
        });
        
        // Password confirmation check
        confirmInput.addEventListener('input', function() {
            if (passwordInput.value && this.value) {
                if (passwordInput.value === this.value) {
                    passwordMatch.innerHTML = '<small class="text-success"><i class="fas fa-check-circle me-1"></i>Passwords match</small>';
                } else {
                    passwordMatch.innerHTML = '<small class="text-danger"><i class="fas fa-times-circle me-1"></i>Passwords do not match</small>';
                }
            } else {
                passwordMatch.innerHTML = '';
            }
        });
    });
</script>
@endsection