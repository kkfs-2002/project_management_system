@extends('layouts.marketing')

@section('title', 'Edit Client')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12"   style="margin-top: 50px;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-0">
                        <i class="fas fa-user-edit text-primary me-2"></i>
                        Edit Client
                    </h4>
                    <p class="text-muted mb-0">Update client details and information</p>
                </div>
                <div>
                    <a href="{{ route('marketing.clients.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Client Card -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fas fa-user text-primary"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Client Information</h5>
                            <small class="text-muted">ID: #{{ $client->id }}</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('marketing.clients.update', $client->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Client Name -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-user text-primary me-1"></i>
                                    Client Name
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-user text-muted"></i>
                                    </span>
                                    <input type="text" 
                                           name="name" 
                                           class="form-control border-start-0 py-3"
                                           value="{{ old('name', $client->name) }}" 
                                           required
                                           placeholder="Enter client name">
                                </div>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Contact Number -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-phone text-primary me-1"></i>
                                    Contact Number
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-phone text-muted"></i>
                                    </span>
                                    <input type="text" 
                                           name="contact_number" 
                                           class="form-control border-start-0 py-3"
                                           value="{{ old('contact_number', $client->contact_number) }}"
                                           placeholder="Enter contact number">
                                </div>
                            </div>

                            <!-- Project Name -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-project-diagram text-primary me-1"></i>
                                    Project Name
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-project-diagram text-muted"></i>
                                    </span>
                                    <input type="text" 
                                           name="project_name" 
                                           class="form-control border-start-0 py-3"
                                           value="{{ old('project_name', $client->project_name) }}"
                                           placeholder="Enter project name">
                                </div>
                            </div>

                            <!-- Project Type -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-tasks text-primary me-1"></i>
                                    Project Type
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-tasks text-muted"></i>
                                    </span>
                                    <select name="project_type" class="form-select border-start-0 py-3">
                                        <option value="" disabled>Select Project Type</option>
                                        <option value="Website" {{ old('project_type', $client->project_type) == 'Website' ? 'selected' : '' }}>Website</option>
                                        <option value="System" {{ old('project_type', $client->project_type) == 'System' ? 'selected' : '' }}>System</option>
                                        <option value="Mobile App" {{ old('project_type', $client->project_type) == 'Mobile App' ? 'selected' : '' }}>Mobile App</option>
                                        <option value="Other" {{ old('project_type', $client->project_type) == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Technology -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-code text-primary me-1"></i>
                                    Technology
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-code text-muted"></i>
                                    </span>
                                    <input type="text" 
                                           name="technology" 
                                           class="form-control border-start-0 py-3"
                                           value="{{ old('technology', $client->technology) }}"
                                           placeholder="e.g., Laravel, React, etc.">
                                </div>
                            </div>

                            <!-- Reminder Date -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar-alt text-primary me-1"></i>
                                    Reminder Date
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-calendar-alt text-muted"></i>
                                    </span>
                                    <input type="date" 
                                           name="reminder_date" 
                                           class="form-control border-start-0 py-3"
                                           value="{{ old('reminder_date', $client->reminder_date) }}">
                                </div>
                            </div>

                            <!-- Note -->
                            <div class="col-12 mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-sticky-note text-primary me-1"></i>
                                    Note
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light align-items-start pt-3">
                                        <i class="fas fa-sticky-note text-muted"></i>
                                    </span>
                                    <textarea name="note" 
                                              class="form-control"
                                              rows="4"
                                              placeholder="Add any additional notes or comments">{{ old('note', $client->note) }}</textarea>
                                </div>
                            </div>

                            <!-- Amount -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-dollar-sign text-primary me-1"></i>
                                    Amount
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-dollar-sign text-muted"></i>
                                    </span>
                                    <input type="number" 
                                           step="0.01" 
                                           name="amount" 
                                           class="form-control border-start-0 py-3"
                                           value="{{ old('amount', $client->amount) }}"
                                           placeholder="0.00">
                                </div>
                            </div>

                            <!-- Payment Status -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-credit-card text-primary me-1"></i>
                                    Payment Status
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-credit-card text-muted"></i>
                                    </span>
                                    <select name="payment_status" class="form-select border-start-0 py-3" required>
                                        <option value="No Payment" {{ old('payment_status', $client->payment_status) == 'No Payment' ? 'selected' : '' }}>No Payment</option>
                                        <option value="Advance" {{ old('payment_status', $client->payment_status) == 'Advance' ? 'selected' : '' }}>Advance</option>
                                        <option value="Full" {{ old('payment_status', $client->payment_status) == 'Full' ? 'selected' : '' }}>Full</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                            <div>
                                <button type="submit" class="btn btn-primary px-4 py-3 fw-semibold">
                                    <i class="fas fa-save me-2"></i> Update Client
                                </button>
                                <button type="reset" class="btn btn-outline-secondary px-4 py-3 ms-2">
                                    <i class="fas fa-redo me-2"></i> Reset
                                </button>
                            </div>
                            <div>
                                <a href="{{ route('marketing.clients.index') }}" class="btn btn-outline-secondary px-4 py-3">
                                    <i class="fas fa-times me-2"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 0.75rem;
        overflow: hidden;
      
    }
    
    .card-header {
        border-bottom: 1px solid rgba(0,0,0,0.1);
        
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #4a6cf7;
        box-shadow: 0 0 0 0.2rem rgba(74, 108, 247, 0.25);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #4a6cf7 0%, #6a11cb 100%);
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 108, 247, 0.3);
    }
    
    .btn-outline-secondary:hover {
        transform: translateY(-1px);
    }
    
    .input-group-text {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
    
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    .border-top {
        border-top: 1px solid #e9ecef !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-format amount on blur
        const amountInput = document.querySelector('input[name="amount"]');
        if (amountInput && amountInput.value) {
            amountInput.addEventListener('blur', function() {
                if (this.value) {
                    this.value = parseFloat(this.value).toFixed(2);
                }
            });
        }
        
        // Auto-format phone number
        const phoneInput = document.querySelector('input[name="contact_number"]');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 3 && value.length <= 6) {
                    value = value.replace(/(\d{3})(\d{0,3})/, '$1 $2');
                } else if (value.length > 6) {
                    value = value.replace(/(\d{3})(\d{3})(\d{0,4})/, '$1 $2 $3');
                }
                e.target.value = value;
            });
        }
        
        // Set today as default for reminder date if empty
        const reminderInput = document.querySelector('input[name="reminder_date"]');
        if (reminderInput && !reminderInput.value) {
            const today = new Date().toISOString().split('T')[0];
            reminderInput.value = today;
        }
    });
</script>
@endsection