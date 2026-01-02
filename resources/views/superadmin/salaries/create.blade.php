@extends('layouts.app')

@section('title', 'Add Salary Record')

@section('content')
<div class="container mt-4">
    <!-- Page Header -->
    <div class="page-header mb-4" style="margin-top: 150px;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">Add New Salary Record</h2>
                <p class="text-muted mb-0">Enter salary details for employee</p>
            </div>
            <a href="{{ route('superadmin.salary.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i>Salary Information</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('superadmin.salary.store') }}" id="salaryForm">
                        @csrf

                        <!-- Employee Selection -->
                        <div class="mb-4">
                            <label for="profile_id" class="form-label fw-semibold">
                                <i class="fas fa-user me-2 text-primary"></i>Select Employee
                                <span class="text-danger">*</span>
                            </label>
                            <select name="profile_id" id="profile_id" class="form-select form-control-lg @error('profile_id') is-invalid @enderror" required>
                                <option value="">-- Select an Employee --</option>
                                @foreach($profiles as $profile)
                                    <option value="{{ $profile->id }}" {{ old('profile_id') == $profile->id ? 'selected' : '' }}>
                                        {{ $profile->full_name }} 
                                        @if($profile->employee_id)
                                            (ID: {{ $profile->employee_id }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('profile_id')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                Select the employee for whom you are adding salary
                            </div>
                        </div>

                        <!-- Salary Amount -->
                        <div class="mb-4">
                            <label for="amount" class="form-label fw-semibold">
                                <i class="fas fa-coins me-2 text-primary"></i>Salary Amount
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-rupee-sign text-muted"></i>
                                </span>
                                <input type="number" 
                                       name="amount" 
                                       id="amount" 
                                       class="form-control @error('amount') is-invalid @enderror" 
                                       step="0.01" 
                                       min="0" 
                                       placeholder="0.00" 
                                       value="{{ old('amount') }}"
                                       required>
                                <span class="input-group-text bg-light">.00</span>
                            </div>
                            @error('amount')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                Enter the salary amount in Sri Lankan Rupees (LKR)
                            </div>
                        </div>

                        <!-- Salary Date -->
                        <div class="mb-4">
                            <label for="salary_month" class="form-label fw-semibold">
                                <i class="fas fa-calendar-alt me-2 text-primary"></i>Salary Date
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-calendar text-muted"></i>
                                </span>
                                <input type="date" 
                                       name="salary_month" 
                                       id="salary_month" 
                                       class="form-control @error('salary_month') is-invalid @enderror" 
                                       value="{{ old('salary_month', date('Y-m-d')) }}"
                                       required>
                            </div>
                            @error('salary_month')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                Select the date for salary payment
                            </div>
                        </div>

                        <!-- Additional Notes (Optional) -->
                        <div class="mb-4">
                            <label for="notes" class="form-label fw-semibold">
                                <i class="fas fa-sticky-note me-2 text-primary"></i>Notes (Optional)
                            </label>
                            <textarea name="notes" 
                                      id="notes" 
                                      class="form-control @error('notes') is-invalid @enderror" 
                                      rows="3" 
                                      placeholder="Any additional notes or remarks...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                Add any remarks or notes about this salary payment
                            </div>
                        </div>

                        <!-- Payment Method (Optional) -->
                        <div class="mb-4">
                            <label for="payment_method" class="form-label fw-semibold">
                                <i class="fas fa-credit-card me-2 text-primary"></i>Payment Method
                            </label>
                            <select name="payment_method" id="payment_method" class="form-select @error('payment_method') is-invalid @enderror">
                                <option value="">-- Select Payment Method --</option>
                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>Online Payment</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                       {{-- create.blade.php file එකේ --}}

<!-- Status Selection -->
<div class="mb-4">
    <label for="status" class="form-label fw-semibold">
        <i class="fas fa-check-circle me-2 text-primary"></i>Payment Status
        <span class="text-danger">*</span>
    </label>
    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
        <option value="">-- Select Status --</option>
        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
    </select>
    @error('status')
        <div class="invalid-feedback d-block">
            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
        </div>
    @enderror
    <div class="form-text">
        Select payment status. "Pending" for future payments, "Paid" for completed payments.
    </div>
</div>

                        <!-- Form Buttons -->
                        <div class="d-flex justify-content-between align-items-center border-top pt-4 mt-4">
                            <a href="{{ route('superadmin.salary.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary px-5">
                                <i class="fas fa-save me-2"></i>Save Salary Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Information Card -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-info-circle text-primary fs-4 me-3"></i>
                        <h6 class="mb-0">Quick Tips</h6>
                    </div>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Ensure all required fields are filled</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Double-check the amount before saving</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Select the correct payment date</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Update status to "Paid" once payment is completed</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .page-header {
        border-bottom: 1px solid #e9ecef;
        padding-bottom: 1rem;
        margin-top: 80px;
    }
    
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
    
    .card-header {
        border-radius: 12px 12px 0 0 !important;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .form-label {
        color: #495057;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
    }
    
    .form-control-lg, .form-select {
        padding: 0.875rem 1rem;
        font-size: 1rem;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .form-control-lg:focus, .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.1);
    }
    
    .input-group-text {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        color: #6c757d;
    }
    
    .form-check-input:checked {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }
    
    .form-check {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-primary {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }
    
    .btn-primary:hover {
        background-color: #2563eb;
        border-color: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    
    .btn-outline-secondary:hover {
        transform: translateY(-1px);
    }
    
    .invalid-feedback {
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
    }
    
    .form-text {
        color: #6c757d;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        font-style: italic;
    }
    
    .border-top {
        border-top: 1px solid #e9ecef !important;
    }
    
    .list-unstyled li {
        display: flex;
        align-items: center;
        color: #6c757d;
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
        const form = document.getElementById('salaryForm');
        form.addEventListener('submit', function(e) {
            const amount = amountInput.value;
            if (amount && parseFloat(amount) <= 0) {
                e.preventDefault();
                alert('Please enter a valid salary amount greater than 0.');
                amountInput.focus();
            }
        });
        
        // Set today's date as default if not set
        const dateInput = document.getElementById('salary_month');
        if (!dateInput.value) {
            dateInput.value = new Date().toISOString().split('T')[0];
        }
    });
</script>
@endsection