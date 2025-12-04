@extends('layouts.app')

@section('title', 'Edit Salary - ' . $salary->profile->full_name)

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-block">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}" class="text-muted text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('superadmin.salary.index') }}" class="text-muted text-decoration-none">Salary Records</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('superadmin.salary.show', $salary->id) }}" class="text-muted text-decoration-none">Salary Details</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Salary</li>
                </ol>
            </nav>
            <div class="d-flex align-items-center">
                <div class="icon-wrapper bg-gradient-warning rounded-3 p-3 me-3">
                    <i class="fas fa-edit fa-lg text-white"></i>
                </div>
                <div>
                    <h1 class="h3 fw-bold mb-1">Edit Salary Record</h1>
                    <p class="text-muted mb-0">{{ $salary->profile->full_name }} | {{ \Carbon\Carbon::parse($salary->salary_month)->format('F Y') }}</p>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('superadmin.salary.show', $salary->id) }}" class="btn btn-outline-secondary d-flex align-items-center">
                <i class="fas fa-arrow-left me-2"></i>Back to Details
            </a>
        </div>
    </div>

    <!-- Edit Form Card -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-semibold"><i class="fas fa-edit me-2 text-warning"></i>Edit Salary Information</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('superadmin.salary.update', $salary->id) }}" id="editSalaryForm">
                        @csrf
                        @method('PUT')

                        <!-- Employee Selection -->
                        <div class="mb-4">
                            <label for="profile_id" class="form-label fw-semibold">
                                <i class="fas fa-user me-2 text-primary"></i>Employee
                                <span class="text-danger">*</span>
                            </label>
                            <select name="profile_id" id="profile_id" class="form-select @error('profile_id') is-invalid @enderror" required>
                                <option value="">-- Select an Employee --</option>
                                @foreach($profiles as $profile)
                                    <option value="{{ $profile->id }}" {{ old('profile_id', $salary->profile_id) == $profile->id ? 'selected' : '' }}>
                                        {{ $profile->full_name }}
                                        @if($profile->employee_id)
                                            (ID: {{ $profile->employee_id }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('profile_id')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Salary Amount -->
                        <div class="mb-4">
                            <label for="amount" class="form-label fw-semibold">
                                <i class="fas fa-coins me-2 text-primary"></i>Salary Amount (Rs)
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-rupee-sign"></i>
                                </span>
                                <input type="number" 
                                       name="amount" 
                                       id="amount" 
                                       class="form-control @error('amount') is-invalid @enderror" 
                                       step="0.01" 
                                       min="0" 
                                       placeholder="0.00" 
                                       value="{{ old('amount', $salary->amount) }}"
                                       required>
                            </div>
                            @error('amount')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Salary Date -->
                        <div class="mb-4">
                            <label for="salary_month" class="form-label fw-semibold">
                                <i class="fas fa-calendar-alt me-2 text-primary"></i>Salary Date
                                <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   name="salary_month" 
                                   id="salary_month" 
                                   class="form-control @error('salary_month') is-invalid @enderror" 
                                   value="{{ old('salary_month', $salary->salary_month) }}"
                                   required>
                            @error('salary_month')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Status Selection -->
                        <div class="mb-4">
                            <label for="status" class="form-label fw-semibold">
                                <i class="fas fa-check-circle me-2 text-primary"></i>Payment Status
                                <span class="text-danger">*</span>
                            </label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="">-- Select Status --</option>
                                <option value="pending" {{ old('status', $salary->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ old('status', $salary->status) == 'paid' ? 'selected' : '' }}>Paid</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Payment Method (Optional) -->
                        <div class="mb-4">
                            <label for="payment_method" class="form-label fw-semibold">
                                <i class="fas fa-credit-card me-2 text-primary"></i>Payment Method
                            </label>
                            <select name="payment_method" id="payment_method" class="form-select @error('payment_method') is-invalid @enderror">
                                <option value="">-- Select Payment Method --</option>
                                <option value="bank_transfer" {{ old('payment_method', $salary->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="cash" {{ old('payment_method', $salary->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="cheque" {{ old('payment_method', $salary->payment_method) == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                <option value="online" {{ old('payment_method', $salary->payment_method) == 'online' ? 'selected' : '' }}>Online Payment</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Notes (Optional) -->
                        <div class="mb-4">
                            <label for="notes" class="form-label fw-semibold">
                                <i class="fas fa-sticky-note me-2 text-primary"></i>Notes
                            </label>
                            <textarea name="notes" 
                                      id="notes" 
                                      class="form-control @error('notes') is-invalid @enderror" 
                                      rows="3" 
                                      placeholder="Any additional notes...">{{ old('notes', $salary->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Form Buttons -->
                        <div class="d-flex justify-content-between align-items-center border-top pt-4 mt-4">
                            <a href="{{ route('superadmin.salary.show', $salary->id) }}" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-warning px-5">
                                <i class="fas fa-save me-2"></i>Update Salary
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .icon-wrapper {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 60px;
    }
    
    .bg-gradient-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
    
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
    
    .form-label {
        color: #495057;
        margin-bottom: 0.75rem;

    }
    
    .form-control, .form-select {
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.1);
    }
    
    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
        padding: 0.75rem 1.5rem;
    }
    
    .btn-warning {
        background-color: #f59e0b;
        border-color: #f59e0b;
        color: white;
    }
    
    .btn-warning:hover {
        background-color: #d97706;
        border-color: #d97706;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }
    
    .invalid-feedback {
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-format amount input
    const amountInput = document.getElementById('amount');
    amountInput.addEventListener('blur', function() {
        if (this.value) {
            this.value = parseFloat(this.value).toFixed(2);
        }
    });
    
    // Form validation
    const form = document.getElementById('editSalaryForm');
    form.addEventListener('submit', function(e) {
        const amount = amountInput.value;
        if (amount && parseFloat(amount) <= 0) {
            e.preventDefault();
            alert('Please enter a valid salary amount greater than 0.');
            amountInput.focus();
        }
    });
});
</script>
@endsection