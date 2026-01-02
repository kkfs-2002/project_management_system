@extends('layouts.marketing')

@section('title', 'Create Client')

@section('content')
<style>
    .client-form-container {
        max-width: 700px;
        margin: 0 auto;
        background: linear-gradient(135deg, #f0f7ff 0%, #e6f0ff 100%);
        min-height: 100vh;
        padding: 40px 20px;
    }

    .client-form-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0, 82, 204, 0.12);
        overflow: hidden;
        transition: transform 0.3s ease;
        border: 1px solid #e1e8ff;
         margin-top: 50px;
    }

    .client-form-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0, 82, 204, 0.15);
    }

    .form-header {
        background: linear-gradient(135deg, #0066cc 0%, #0044aa 100%);
        color: white;
        padding: 30px;
        text-align: center;
        position: relative;
       
    }

    .form-header h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .form-header p {
        opacity: 0.9;
        margin-top: 8px;
        font-size: 14px;
        color: rgba(255, 255, 255, 0.9);
    }

    .form-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 10%;
        width: 80%;
        height: 1px;
        background: rgba(255, 255, 255, 0.2);
    }

    .form-body {
        padding: 40px;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
        margin-bottom: 25px;
    }

    .form-group {
        margin-bottom: 0;
    }

    .form-group.full-width {
        grid-column: span 2;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #1a365d;
        font-size: 14px;
        letter-spacing: 0.3px;
    }

    .form-control, .form-select {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #c5d5ff;
        border-radius: 10px;
        font-size: 15px;
        transition: all 0.3s ease;
        background-color: #f8fbff;
        color: #2d3748;
    }

    .form-control:focus, .form-select:focus {
        outline: none;
        border-color: #0066cc;
        box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.15);
        background-color: white;
    }

    .form-control::placeholder {
        color: #718096;
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%230066cc' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
        background-size: 12px;
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
        line-height: 1.5;
    }

    .form-footer {
        padding: 30px 40px;
        background: #f8fbff;
        border-top: 1px solid #e1e8ff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .btn {
        padding: 12px 32px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 15px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #0066cc 0%, #0052cc 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(0, 102, 204, 0.25);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 102, 204, 0.35);
        background: linear-gradient(135deg, #0052cc 0%, #0044aa 100%);
    }

    .btn-secondary {
        background: #e1e8ff;
        color: #1a365d;
        border: 1px solid #c5d5ff;
    }

    .btn-secondary:hover {
        background: #d0dcff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 102, 204, 0.15);
    }

    .required::after {
        content: ' *';
        color: #e53e3e;
        font-weight: bold;
    }

    .form-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #0066cc;
        opacity: 0.7;
    }

    .input-with-icon {
        position: relative;
    }

    .input-with-icon .form-control {
        padding-left: 45px;
    }

    .form-hint {
        font-size: 12px;
        color: #718096;
        margin-top: 4px;
        display: block;
    }

    /* Status indicators */
    .status-indicator {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        margin-left: 8px;
    }

    .status-no-payment {
        background: #fff5f5;
        color: #c53030;
    }

    .status-advance {
        background: #fefcbf;
        color: #975a16;
    }

    .status-full {
        background: #c6f6d5;
        color: #22543d;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .form-group.full-width {
            grid-column: span 1;
        }
        
        .form-body {
            padding: 30px 25px;
        }
        
        .form-footer {
            padding: 25px;
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
        
        .client-form-container {
            padding: 20px 15px;
        }
    }

    @media (max-width: 480px) {
        .form-header {
            padding: 25px 20px;
        }
        
        .form-header h2 {
            font-size: 24px;
        }
        
        .form-body {
            padding: 25px 20px;
        }
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .client-form-card {
        animation: fadeInUp 0.5s ease-out;
    }

    /* Floating label effect */
    .float-label {
        position: relative;
        margin-bottom: 24px;
    }

    .float-label label {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        background: white;
        padding: 0 8px;
        color: #718096;
        transition: all 0.3s ease;
        pointer-events: none;
    }

    .float-label .form-control:focus + label,
    .float-label .form-control:not(:placeholder-shown) + label {
        top: 0;
        font-size: 12px;
        color: #0066cc;
        background: #f8fbff;
        padding: 0 8px;
    }

    .float-label .form-control {
        padding: 18px 16px 10px 16px;
    }
</style>

<div class="client-form-container">
    <div class="client-form-card">
        <div class="form-header">
            <h2>Create New Client</h2>
            <p>Add a new client to your marketing database</p>
        </div>

        <form method="POST" action="{{ route('marketing.clients.store') }}">
            @csrf
            
            <div class="form-body">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label required">Client Name</label>
                        <div class="input-with-icon">
                            <svg class="form-icon" width="18" height="18" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                            </svg>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter client name" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Contact Number</label>
                        <div class="input-with-icon">
                            <svg class="form-icon" width="18" height="18" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                            <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number') }}" placeholder="+94 77 123 4567">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Project Name</label>
                        <div class="input-with-icon">
                            <svg class="form-icon" width="18" height="18" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                            </svg>
                            <input type="text" name="project_name" class="form-control" value="{{ old('project_name') }}" placeholder="Enter project name">
                            <span class="form-hint">Optional project identifier</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Project Type</label>
                        <select name="project_type" class="form-select" required>
                            <option value="" disabled selected>Select Project Type</option>
                            <option value="Website" {{ old('project_type') == 'Website' ? 'selected' : '' }}>Website</option>
                            <option value="System" {{ old('project_type') == 'System' ? 'selected' : '' }}>System</option>
                            <option value="Mobile App" {{ old('project_type') == 'Mobile App' ? 'selected' : '' }}>Mobile App</option>
                            <option value="Other" {{ old('project_type') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Technology</label>
                        <div class="input-with-icon">
                            <svg class="form-icon" width="18" height="18" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                            <input type="text" name="technology" class="form-control" value="{{ old('technology') }}" placeholder="e.g., Laravel, React, Node.js">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Reminder Date</label>
                        <div class="input-with-icon">
                            <svg class="form-icon" width="18" height="18" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            <input type="date" name="reminder_date" class="form-control" value="{{ old('reminder_date') }}">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group full-width">
                        <label class="form-label">Note</label>
                        <textarea name="note" class="form-control" rows="3" placeholder="Add any important notes or client requirements...">{{ old('note') }}</textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Amount</label>
                        <div class="input-with-icon">
                            <svg class="form-icon" width="18" height="18" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                            </svg>
                            <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount') }}" placeholder="0.00">
                            <span class="form-hint">Enter amount in LKR</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Payment Status</label>
                        <select name="payment_status" class="form-select" required>
                            <option value="" disabled selected>Select Payment Status</option>
                            <option value="No Payment" {{ old('payment_status') == 'No Payment' ? 'selected' : '' }}>
                                No Payment <span class="status-indicator status-no-payment">Pending</span>
                            </option>
                            <option value="Advance" {{ old('payment_status') == 'Advance' ? 'selected' : '' }}>
                                Advance <span class="status-indicator status-advance">Partial</span>
                            </option>
                            <option value="Full" {{ old('payment_status') == 'Full' ? 'selected' : '' }}>
                                Full <span class="status-indicator status-full">Complete</span>
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    Create Client
                </button>
                <a href="{{ route('marketing.clients.index') }}" class="btn btn-secondary">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                    </svg>
                    Back to Clients
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set today's date as default for reminder date
        const reminderDateInput = document.querySelector('input[name="reminder_date"]');
        if (!reminderDateInput.value) {
            const today = new Date();
            today.setDate(today.getDate() + 7); // Set default to 7 days from now
            const formattedDate = today.toISOString().split('T')[0];
            reminderDateInput.value = formattedDate;
        }

        // Format amount field with currency
        const amountInput = document.querySelector('input[name="amount"]');
        amountInput.addEventListener('blur', function() {
            if (this.value) {
                const formattedValue = parseFloat(this.value).toFixed(2);
                this.value = formattedValue;
            }
        });

        // Add smooth focus effects
        const formControls = document.querySelectorAll('.form-control, .form-select');
        formControls.forEach(control => {
            control.addEventListener('focus', function() {
                this.style.borderColor = '#0066cc';
                this.style.boxShadow = '0 0 0 3px rgba(0, 102, 204, 0.2)';
            });
            
            control.addEventListener('blur', function() {
                this.style.boxShadow = 'none';
            });
        });

        // Show payment status hints
        const paymentSelect = document.querySelector('select[name="payment_status"]');
        paymentSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const statusText = selectedOption.textContent;
            
            // You could add more sophisticated logic here if needed
            console.log('Payment status changed to:', statusText);
        });
    });
</script>

@endsection