@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <!-- Header Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="position-relative">
                            <div class="bg-gradient-primary rounded-circle p-3 me-3">
                                <i class="fas fa-user-shield text-white fs-4"></i>
                            </div>
                           
                        </div>
                        <div class="flex-grow-1">
                            <h4 class="fw-bold mb-1">Reset Employee Password</h4>
                            <p class="text-muted mb-0">Setting new credentials for <span class="fw-semibold">{{ $profile->full_name }}</span></p>
                        </div>
                        <div class="ms-3">
                            @php
                                $roleColors = [
                                    'manager' => 'primary',
                                    'admin' => 'danger',
                                    'superadmin' => 'purple',
                                    'staff' => 'success',
                                    'employee' => 'info'
                                ];
                                $color = $roleColors[strtolower($profile->role)] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }} px-3 py-2">
                                <i class="fas fa-user-tag me-1"></i> {{ ucfirst($profile->role) }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- User Info -->
                    <div class="row mt-4 g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="bg-white rounded-circle p-2 me-3">
                                    <i class="fas fa-id-card text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Employee ID</small>
                                    <span class="fw-semibold">#{{ $profile->id ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="bg-white rounded-circle p-2 me-3">
                                    <i class="fas fa-envelope text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Email Address</small>
                                    <span class="fw-semibold">{{ $profile->email ?? 'Not provided' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Password Reset Card -->
            <div class="card shadow-lg border-0">
                <div class="card-header bg-white border-0 py-4">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-lock me-2 text-danger"></i>Set New Password
                    </h5>
                    <p class="text-muted mb-0 small">Create a strong password for {{ $profile->full_name }}</p>
                </div>
                
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('superadmin.password.updateOther', $profile->id) }}" id="passwordResetForm">
                        @csrf
                        
                        <!-- Password Strength Indicator -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-semibold">New Password</label>
                                <div class="password-strength">
                                    <small class="text-muted" id="strengthText">Strength: <span id="strengthLevel">None</span></small>
                                </div>
                            </div>
                            <div class="input-group">
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="form-control form-control-lg py-3 border-2"
                                       placeholder="Enter new password" 
                                       required
                                       autocomplete="new-password"
                                       autofocus>
                                <button class="btn btn-outline-secondary border-2 border-start-0" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            
                            <!-- Strength Meter -->
                            <div class="mt-3">
                                <div class="strength-meter d-flex gap-1 mb-2">
                                    <div class="flex-fill rounded" style="height: 6px; background-color: #e9ecef;"></div>
                                    <div class="flex-fill rounded" style="height: 6px; background-color: #e9ecef;"></div>
                                    <div class="flex-fill rounded" style="height: 6px; background-color: #e9ecef;"></div>
                                    <div class="flex-fill rounded" style="height: 6px; background-color: #e9ecef;"></div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted" id="passwordHint">Minimum 8 characters</small>
                                    <small class="text-muted">
                                        <span id="charCount">0</span>/20 characters
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       class="form-control form-control-lg py-3 border-2"
                                       placeholder="Confirm new password" 
                                       required
                                       autocomplete="new-password">
                                <button class="btn btn-outline-secondary border-2 border-start-0" type="button" id="toggleConfirmPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="mt-2">
                                <small id="matchStatus"></small>
                            </div>
                        </div>
                        
                        <!-- Password Requirements -->
                        <div class="mb-4">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <h6 class="fw-semibold mb-3">
                                        <i class="fas fa-shield-alt me-2 text-primary"></i>Password Requirements
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul class="list-unstyled mb-0">
                                                <li class="mb-2 requirement-item" data-requirement="length">
                                                    <i class="fas fa-circle me-2 text-muted small"></i>
                                                    <span>8+ characters</span>
                                                </li>
                                                <li class="mb-2 requirement-item" data-requirement="uppercase">
                                                    <i class="fas fa-circle me-2 text-muted small"></i>
                                                    <span>Uppercase letter</span>
                                                </li>
                                                <li class="requirement-item" data-requirement="lowercase">
                                                    <i class="fas fa-circle me-2 text-muted small"></i>
                                                    <span>Lowercase letter</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="list-unstyled mb-0">
                                                <li class="mb-2 requirement-item" data-requirement="number">
                                                    <i class="fas fa-circle me-2 text-muted small"></i>
                                                    <span>Number (0-9)</span>
                                                </li>
                                                <li class="mb-2 requirement-item" data-requirement="special">
                                                    <i class="fas fa-circle me-2 text-muted small"></i>
                                                    <span>Special character</span>
                                                </li>
                                                <li class="requirement-item" data-requirement="match">
                                                    <i class="fas fa-circle me-2 text-muted small"></i>
                                                    <span>Passwords match</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-danger btn-lg py-3 fw-bold shadow-sm" id="submitBtn">
                                <i class="fas fa-key me-2"></i>
                                Reset Password
                            </button>
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-lg py-3">
                                <i class="fas fa-arrow-left me-2"></i>
                                Back to Employee List
                            </a>
                        </div>
                        
                        <!-- Security Notice -->
                        <div class="mt-4 text-center">
                            <div class="alert alert-warning border-0 bg-warning bg-opacity-10 py-2 px-3 d-inline-flex align-items-center">
                                <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
                                <small class="text-muted">
                                    This action will immediately invalidate the current password
                                </small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Success Message -->
            @if(session('success'))
            <div class="mt-4">
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fas fa-check-circle text-success fs-4"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="alert-heading fw-bold mb-1">Password Reset Successful!</h6>
                            <p class="mb-0">{{ session('success') }}</p>
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    The employee has been notified about the password change.
                                </small>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Error Messages -->
            @if($errors->any())
            <div class="mt-4">
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fas fa-exclamation-triangle text-danger fs-4"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="alert-heading fw-bold mb-1">Please correct the following:</h6>
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
            
            <!-- Reset History Card -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-history me-2 text-muted"></i>Recent Password Resets
                    </h6>
                    <div class="d-flex align-items-center justify-content-center py-3">
                        <div class="text-center">
                            <i class="fas fa-clock fs-1 text-muted mb-2"></i>
                            <p class="text-muted mb-0">No reset history available</p>
                            <small class="text-muted">This feature will track future password resets</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4a6cf7 0%, #6a11cb 100%);
    }
    
    .card {
        border-radius: 1rem;
        overflow: hidden;
        margin-top: 50px;
    }
    
    .card-header {
        border-bottom: 2px solid #f8f9fa;
    }
    
    .form-control:focus {
        border-color: #4a6cf7;
        box-shadow: 0 0 0 0.25rem rgba(74, 108, 247, 0.1);
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #dc3545 0%, #bd2130 100%);
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }
    
    .btn-outline-secondary:hover {
        transform: translateY(-1px);
    }
    
    .input-group .btn-outline-secondary {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
    
    .input-group .btn-outline-secondary:hover {
        background-color: #e9ecef;
    }
    
    .strength-meter div {
        transition: all 0.3s ease;
    }
    
    .requirement-item.valid {
        color: #198754;
    }
    
    .requirement-item.valid i {
        color: #198754;
    }
    
    .requirement-item.invalid {
        color: #6c757d;
    }
    
    .requirement-item.invalid i {
        color: #dee2e6;
    }
    
    #submitBtn:disabled {
        opacity: 0.65;
        transform: none !important;
        box-shadow: none !important;
    }
    
    .badge.bg-purple {
        background-color: #8b5cf6 !important;
    }
    
    .text-purple {
        color: #8b5cf6 !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    const togglePassword = document.getElementById('togglePassword');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const strengthMeter = document.querySelectorAll('.strength-meter div');
    const strengthText = document.getElementById('strengthText');
    const strengthLevel = document.getElementById('strengthLevel');
    const charCount = document.getElementById('charCount');
    const passwordHint = document.getElementById('passwordHint');
    const matchStatus = document.getElementById('matchStatus');
    const requirementItems = document.querySelectorAll('.requirement-item');
    const submitBtn = document.getElementById('submitBtn');
    const form = document.getElementById('passwordResetForm');
    
    // Strength levels
    const strengthLevels = {
        0: { text: 'Very Weak', color: '#dc3545' },
        1: { text: 'Weak', color: '#fd7e14' },
        2: { text: 'Fair', color: '#ffc107' },
        3: { text: 'Good', color: '#20c997' },
        4: { text: 'Strong', color: '#198754' }
    };
    
    // Requirements validation
    const requirements = {
        length: false,
        uppercase: false,
        lowercase: false,
        number: false,
        special: false,
        match: false
    };
    
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
    
    // Password input handler
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        const length = password.length;
        
        // Update character count
        charCount.textContent = length;
        charCount.style.color = length > 20 ? '#dc3545' : '#6c757d';
        
        // Check requirements
        requirements.length = length >= 8;
        requirements.uppercase = /[A-Z]/.test(password);
        requirements.lowercase = /[a-z]/.test(password);
        requirements.number = /[0-9]/.test(password);
        requirements.special = /[^A-Za-z0-9]/.test(password);
        
        // Calculate strength
        let strength = 0;
        if (requirements.length) strength++;
        if (requirements.uppercase && requirements.lowercase) strength++;
        if (requirements.number) strength++;
        if (requirements.special) strength++;
        
        // Update strength meter
        strengthMeter.forEach((bar, index) => {
            if (index < strength) {
                bar.style.backgroundColor = strengthLevels[strength].color;
            } else {
                bar.style.backgroundColor = '#e9ecef';
            }
        });
        
        // Update strength text
        strengthLevel.textContent = strengthLevels[strength].text;
        strengthLevel.style.color = strengthLevels[strength].color;
        strengthText.style.color = length > 0 ? '#495057' : '#6c757d';
        
        // Update requirement indicators
        updateRequirementIndicators();
        
        // Check password match
        checkPasswordMatch();
        
        // Update password hint
        updatePasswordHint(password, strength);
    });
    
    // Confirm password handler
    confirmInput.addEventListener('input', checkPasswordMatch);
    
    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirm = confirmInput.value;
        
        if (password && confirm) {
            if (password === confirm) {
                requirements.match = true;
                matchStatus.innerHTML = '<i class="fas fa-check-circle text-success me-1"></i>Passwords match';
                matchStatus.className = 'text-success';
            } else {
                requirements.match = false;
                matchStatus.innerHTML = '<i class="fas fa-times-circle text-danger me-1"></i>Passwords do not match';
                matchStatus.className = 'text-danger';
            }
        } else {
            requirements.match = false;
            matchStatus.innerHTML = '';
        }
        
        updateRequirementIndicators();
        updateSubmitButton();
    }
    
    function updateRequirementIndicators() {
        requirementItems.forEach(item => {
            const requirement = item.dataset.requirement;
            if (requirements[requirement]) {
                item.classList.add('valid');
                item.classList.remove('invalid');
                item.querySelector('i').className = 'fas fa-check-circle me-2 text-success';
            } else {
                item.classList.add('invalid');
                item.classList.remove('valid');
                item.querySelector('i').className = 'fas fa-circle me-2 text-muted small';
            }
        });
    }
    
    function updatePasswordHint(password, strength) {
        if (password.length === 0) {
            passwordHint.textContent = 'Minimum 8 characters';
            passwordHint.style.color = '#6c757d';
        } else if (strength <= 1) {
            passwordHint.textContent = 'Add uppercase, lowercase letters, numbers & symbols';
            passwordHint.style.color = '#dc3545';
        } else if (strength <= 2) {
            passwordHint.textContent = 'Good start! Add more complexity';
            passwordHint.style.color = '#fd7e14';
        } else if (strength <= 3) {
            passwordHint.textContent = 'Almost there! Add one more complexity type';
            passwordHint.style.color = '#ffc107';
        } else {
            passwordHint.textContent = 'Excellent! Strong password detected';
            passwordHint.style.color = '#198754';
        }
    }
    
    function updateSubmitButton() {
        const allValid = Object.values(requirements).every(value => value === true);
        
        if (allValid) {
            submitBtn.disabled = false;
            submitBtn.title = '';
        } else {
            submitBtn.disabled = true;
            submitBtn.title = 'Please meet all password requirements';
        }
    }
    
    // Form submission confirmation
    form.addEventListener('submit', function(e) {
        if (submitBtn.disabled) {
            e.preventDefault();
            return;
        }
        
        e.preventDefault(); // Remove this line to enable actual submission
        
        // Show confirmation modal (for demonstration)
        Swal.fire({
            title: 'Confirm Password Reset',
            html: `
                <div class="text-start">
                    <p>You are about to reset the password for:</p>
                    <div class="alert alert-info border-0 bg-info bg-opacity-10">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user me-3"></i>
                            <div>
                                <strong>${'{{ $profile->full_name }}'}</strong><br>
                                <small>${'{{ ucfirst($profile->role) }}'}</small>
                            </div>
                        </div>
                    </div>
                    <p class="mb-0"><strong>This action cannot be undone.</strong></p>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Reset Password',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#dc3545',
            reverseButtons: true,
            showLoaderOnConfirm: true,
            preConfirm: () => {
                // For demonstration, simulate submission
                return new Promise((resolve) => {
                    setTimeout(() => {
                        resolve();
                        // Uncomment the next line to actually submit the form
                        // form.submit();
                    }, 1500);
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Actually submit the form (uncomment in production)
                // form.submit();
                
                // For demonstration only
                Swal.fire({
                    title: 'Success!',
                    text: 'Password has been reset successfully',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
    
    // Initialize
    updateSubmitButton();
    
    // Add autofocus effect
    passwordInput.focus();
});
</script>

<!-- Add SweetAlert for confirmation dialogs -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection