@extends('layouts.app')

@section('title', 'Add New Expense')

@section('content')
<style>
    :root {
        --primary: #2c5aa0;
        --primary-dark: #1e3d72;
        --primary-light: #e8eff7;
        --primary-extra-light: #f5f8fd;
        --secondary: #6c757d;
        --success: #28a745;
        --success-light: #d4edda;
        --warning: #ffc107;
        --warning-light: #fff3cd;
        --danger: #dc3545;
        --danger-light: #f8d7da;
        --info: #17a2b8;
        --info-light: #d1ecf1;
        --light: #f8f9fa;
        --dark: #343a40;
        --dark-light: #495057;
        --border: #dee2e6;
        --border-light: #eff2f7;
        --shadow: 0 4px 12px rgba(0,0,0,0.08);
        --shadow-light: 0 2px 6px rgba(0,0,0,0.05);
        --shadow-hover: 0 6px 20px rgba(0,0,0,0.12);
        --radius: 12px;
        --radius-sm: 8px;
        --radius-lg: 16px;
    }

    .expense-form-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        margin-top: 20px;
    }

    /* Page Header Styling */
    .page-header {
        background: white;
        border-radius: var(--radius-lg);
        padding: 30px 35px;
        color: var(--dark);
        margin-bottom: 30px;
        box-shadow: var(--shadow);
        border-left: 5px solid var(--danger);
        position: relative;
        overflow: hidden;
        margin-top: 50px;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.05) 0%, transparent 70%);
        border-radius: 0 0 0 100%;
    }

    .page-title {
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        z-index: 2;
    }

    .page-title-icon {
        width: 70px;
        height: 70px;
        border-radius: var(--radius);
        background: linear-gradient(135deg, var(--danger) 0%, #c82333 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 28px;
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    }

    .page-title-text h1 {
        margin: 0;
        font-weight: 700;
        font-size: 32px;
        background: linear-gradient(135deg, var(--danger) 0%, #c82333 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .page-title-text p {
        margin: 8px 0 0 0;
        color: var(--dark-light);
        font-size: 15px;
        line-height: 1.5;
    }

    /* Form Container */
    .form-card {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        overflow: hidden;
        border: 1px solid var(--border-light);
        margin-bottom: 30px;
    }

    .form-header {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.05) 0%, #fdf5f6 100%);
        padding: 25px 30px;
        border-bottom: 1px solid var(--border);
    }

    .form-header h3 {
        margin: 0;
        color: var(--danger);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 20px;
    }

    .form-body {
        padding: 30px;
    }

    /* Form Groups */
    .form-group {
        margin-bottom: 25px;
        position: relative;
    }

    .form-label {
        display: block;
        margin-bottom: 10px;
        font-weight: 600;
        color: var(--dark);
        font-size: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-label i {
        color: var(--danger);
        width: 18px;
        text-align: center;
        font-size: 16px;
    }

    .form-label .required {
        color: var(--danger);
        margin-left: 4px;
    }

    .form-control {
        width: 100%;
        padding: 14px 18px;
        border: 2px solid var(--border);
        border-radius: var(--radius-sm);
        font-size: 15px;
        transition: all 0.3s;
        background: white;
        color: var(--dark);
        font-family: inherit;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--danger);
        box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
        background: white;
    }

    .form-control::placeholder {
        color: var(--secondary);
        opacity: 0.7;
    }

    .form-control:disabled {
        background: var(--light);
        cursor: not-allowed;
    }

    /* Textarea specific styles */
    textarea.form-control {
        min-height: 120px;
        resize: vertical;
        line-height: 1.6;
    }

    /* Input groups */
    .input-group {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-group-prepend {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        display: flex;
        align-items: center;
        padding: 0 15px;
        background: var(--primary-light);
        border-right: 1px solid var(--border);
        border-radius: var(--radius-sm) 0 0 var(--radius-sm);
        color: var(--primary-dark);
        font-weight: 600;
        z-index: 4;
    }

    .input-group .form-control {
        padding-left: 60px;
    }

    /* Form hints and validation */
    .form-hint {
        display: block;
        margin-top: 6px;
        font-size: 13px;
        color: var(--secondary);
    }

    .form-hint i {
        margin-right: 5px;
    }

    .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: 6px;
        font-size: 13px;
        color: var(--danger);
    }

    .form-control.is-invalid {
        border-color: var(--danger);
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
    }

    .form-control.is-invalid ~ .invalid-feedback {
        display: block;
    }

    /* Action Buttons */
    .form-actions {
        display: flex;
        gap: 15px;
        align-items: center;
        justify-content: flex-end;
        padding-top: 25px;
        border-top: 1px solid var(--border-light);
        margin-top: 30px;
    }

    .btn {
        padding: 14px 28px;
        border-radius: var(--radius-sm);
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        text-decoration: none;
        font-size: 15px;
        min-width: 140px;
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--danger) 0%, #c82333 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(220, 53, 69, 0.3);
    }

    .btn-outline-secondary {
        background: white;
        color: var(--secondary);
        border: 2px solid var(--border);
        box-shadow: 0 2px 8px rgba(108, 117, 125, 0.1);
    }

    .btn-outline-secondary:hover {
        background: var(--light);
        color: var(--dark);
        border-color: var(--secondary);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.2);
    }

    .btn-success {
        background: linear-gradient(135deg, var(--success) 0%, #218838 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #218838 0%, #1e7e34 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.3);
    }

    /* Loading state */
    .btn.loading {
        position: relative;
        color: transparent;
    }

    .btn.loading::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Form Preview Section */
    .preview-card {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        overflow: hidden;
        border: 1px solid var(--border-light);
        margin-top: 30px;
    }

    .preview-header {
        background: linear-gradient(135deg, rgba(44, 90, 160, 0.05) 0%, #f0f5ff 100%);
        padding: 20px 25px;
        border-bottom: 1px solid var(--border);
    }

    .preview-header h4 {
        margin: 0;
        color: var(--primary-dark);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 18px;
    }

    .preview-body {
        padding: 25px;
    }

    .preview-item {
        display: flex;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--border-light);
    }

    .preview-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .preview-label {
        flex: 0 0 150px;
        font-weight: 600;
        color: var(--dark);
        font-size: 14px;
    }

    .preview-value {
        flex: 1;
        color: var(--dark-light);
        font-size: 14px;
        word-break: break-word;
    }

    .preview-value.empty {
        color: var(--secondary);
        font-style: italic;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .expense-form-container {
            padding: 15px;
        }
        
        .page-header {
            padding: 25px;
        }
        
        .page-title {
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }
        
        .page-title-icon {
            width: 60px;
            height: 60px;
            font-size: 24px;
        }
        
        .page-title-text h1 {
            font-size: 24px;
        }
        
        .form-body {
            padding: 20px;
        }
        
        .form-actions {
            flex-direction: column;
            align-items: stretch;
        }
        
        .btn {
            width: 100%;
            margin-bottom: 10px;
        }
        
        .preview-item {
            flex-direction: column;
            gap: 5px;
        }
        
        .preview-label {
            flex: none;
            margin-bottom: 5px;
        }
    }

    @media (max-width: 576px) {
        .expense-form-container {
            padding: 10px;
        }
        
        .page-header {
            padding: 20px;
            border-left-width: 3px;
        }
        
        .form-header, .preview-header {
            padding: 20px;
        }
        
        .form-body, .preview-body {
            padding: 15px;
        }
        
        .form-label {
            font-size: 14px;
        }
        
        .form-control {
            padding: 12px 15px;
            font-size: 14px;
        }
    }

    /* Form validation animation */
    .shake {
        animation: shake 0.5s;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }

    /* Success message */
    .success-message {
        background: linear-gradient(135deg, var(--success-light) 0%, #e8f7ed 100%);
        border: 1px solid var(--success);
        border-radius: var(--radius);
        padding: 20px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 15px;
        color: var(--success);
        font-weight: 600;
        display: none;
    }

    .success-message i {
        font-size: 24px;
    }
</style>

<div class="expense-form-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <div class="page-title-icon">
                <i class="fas fa-plus-circle"></i>
            </div>
            <div class="page-title-text">
                <h1>Add New Expense</h1>
                <p>Record new expenses with detailed information for better financial tracking</p>
            </div>
        </div>
    </div>

    <!-- Success Message (Hidden by default) -->
    <div class="success-message" id="successMessage">
        <i class="fas fa-check-circle"></i>
        <div>
            <div style="font-size: 16px; margin-bottom: 5px;">Expense Added Successfully!</div>
            <div style="font-size: 14px; font-weight: normal;">The expense has been recorded in the system.</div>
        </div>
    </div>

    <!-- Form Container -->
    <form method="POST" action="{{ route('superadmin.expenses.store') }}" id="expenseForm">
        @csrf
        
        <div class="form-card">
            <div class="form-header">
                <h3><i class="fas fa-file-invoice-dollar"></i> Expense Details</h3>
            </div>
            
            <div class="form-body">
                <!-- Title Field -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-heading"></i>
                        Expense Title
                        <span class="required">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           class="form-control" 
                           required
                           placeholder="Enter expense title (e.g., Office Supplies, Internet Bill)"
                           maxlength="200"
                           autofocus>
                    <span class="form-hint">
                        <i class="fas fa-info-circle"></i>
                        Be specific and descriptive for better tracking
                    </span>
                    <div class="invalid-feedback">
                        Please enter a valid expense title.
                    </div>
                </div>

                <!-- Description Field -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-align-left"></i>
                        Description
                    </label>
                    <textarea name="description" 
                              class="form-control" 
                              rows="4"
                              placeholder="Provide additional details about this expense (optional)"
                              maxlength="1000"></textarea>
                    <span class="form-hint">
                        <i class="fas fa-info-circle"></i>
                        Optional: Include details like vendor name, purpose, etc.
                    </span>
                    <div class="invalid-feedback">
                        Description must be less than 1000 characters.
                    </div>
                </div>

                <!-- Amount Field -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-money-bill-wave"></i>
                        Amount (LKR)
                        <span class="required">*</span>
                    </label>
                    <div class="input-group">
                        <div class="input-group-prepend">Rs.</div>
                        <input type="number" 
                               name="amount" 
                               step="0.01" 
                               min="0.01" 
                               max="99999999.99"
                               class="form-control" 
                               required
                               placeholder="0.00">
                    </div>
                    <span class="form-hint">
                        <i class="fas fa-info-circle"></i>
                        Enter the amount in Sri Lankan Rupees (LKR)
                    </span>
                    <div class="invalid-feedback">
                        Please enter a valid amount greater than 0.
                    </div>
                </div>

                <!-- Expense Date Field -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-calendar-alt"></i>
                        Expense Date
                        <span class="required">*</span>
                    </label>
                    <input type="date" 
                           name="expense_date" 
                           class="form-control" 
                           required
                           value="{{ date('Y-m-d') }}"
                           max="{{ date('Y-m-d') }}">
                    <span class="form-hint">
                        <i class="fas fa-info-circle"></i>
                        Select the date when the expense occurred
                    </span>
                    <div class="invalid-feedback">
                        Please select a valid date (cannot be in the future).
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('superadmin.expenses.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Back to Expenses
                    </a>
                    <button type="reset" class="btn btn-outline-secondary" id="resetBtn">
                        <i class="fas fa-redo"></i>
                        Reset Form
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save"></i>
                        Add Expense
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Live Preview Card -->
    <div class="preview-card">
        <div class="preview-header">
            <h4><i class="fas fa-eye"></i> Live Preview</h4>
        </div>
        <div class="preview-body">
            <div class="preview-item">
                <div class="preview-label">Expense Title:</div>
                <div class="preview-value" id="previewTitle">-</div>
            </div>
            <div class="preview-item">
                <div class="preview-label">Description:</div>
                <div class="preview-value empty" id="previewDescription">No description provided</div>
            </div>
            <div class="preview-item">
                <div class="preview-label">Amount:</div>
                <div class="preview-value" id="previewAmount">Rs. 0.00</div>
            </div>
            <div class="preview-item">
                <div class="preview-label">Date:</div>
                <div class="preview-value" id="previewDate">{{ date('M d, Y') }}</div>
            </div>
            <div class="preview-item">
                <div class="preview-label">Status:</div>
                <div class="preview-value">
                    <span class="badge bg-warning">Pending Submission</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome for icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('expenseForm');
        const submitBtn = document.getElementById('submitBtn');
        const resetBtn = document.getElementById('resetBtn');
        const successMessage = document.getElementById('successMessage');
        
        // Preview elements
        const previewTitle = document.getElementById('previewTitle');
        const previewDescription = document.getElementById('previewDescription');
        const previewAmount = document.getElementById('previewAmount');
        const previewDate = document.getElementById('previewDate');
        
        // Form elements
        const titleInput = document.querySelector('input[name="title"]');
        const descriptionInput = document.querySelector('textarea[name="description"]');
        const amountInput = document.querySelector('input[name="amount"]');
        const dateInput = document.querySelector('input[name="expense_date"]');
        
        // Live preview update function
        function updatePreview() {
            // Update title
            const title = titleInput.value.trim();
            previewTitle.textContent = title || '-';
            previewTitle.className = 'preview-value ' + (title ? '' : 'empty');
            
            // Update description
            const description = descriptionInput.value.trim();
            if (description) {
                previewDescription.textContent = description.length > 100 ? 
                    description.substring(0, 100) + '...' : description;
                previewDescription.className = 'preview-value';
            } else {
                previewDescription.textContent = 'No description provided';
                previewDescription.className = 'preview-value empty';
            }
            
            // Update amount
            const amount = parseFloat(amountInput.value) || 0;
            previewAmount.textContent = 'Rs. ' + amount.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            
            // Update date
            const date = new Date(dateInput.value);
            if (dateInput.value && !isNaN(date.getTime())) {
                previewDate.textContent = date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });
            }
        }
        
        // Add event listeners for live preview
        titleInput.addEventListener('input', updatePreview);
        descriptionInput.addEventListener('input', updatePreview);
        amountInput.addEventListener('input', updatePreview);
        dateInput.addEventListener('change', updatePreview);
        
        // Initial preview update
        updatePreview();
        
        // Reset button functionality
        resetBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Ask for confirmation
            if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
                form.reset();
                updatePreview();
                
                // Add animation to reset button
                this.classList.add('shake');
                setTimeout(() => this.classList.remove('shake'), 500);
            }
        });
        
        // Form submission
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Validate title
            if (!titleInput.value.trim()) {
                titleInput.classList.add('is-invalid');
                isValid = false;
            } else {
                titleInput.classList.remove('is-invalid');
            }
            
            // Validate amount
            const amount = parseFloat(amountInput.value);
            if (!amount || amount <= 0 || amount > 99999999.99) {
                amountInput.classList.add('is-invalid');
                isValid = false;
            } else {
                amountInput.classList.remove('is-invalid');
            }
            
            // Validate date
            const selectedDate = new Date(dateInput.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (!dateInput.value || selectedDate > today) {
                dateInput.classList.add('is-invalid');
                isValid = false;
            } else {
                dateInput.classList.remove('is-invalid');
            }
            
            if (!isValid) {
                e.preventDefault();
                
                // Add shake animation to form
                form.classList.add('shake');
                setTimeout(() => form.classList.remove('shake'), 500);
                
                // Scroll to first invalid field
                const firstInvalid = form.querySelector('.is-invalid');
                if (firstInvalid) {
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstInvalid.focus();
                }
                
                return;
            }
            
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            submitBtn.disabled = true;
            
            // In a real application, this would be handled by the form submission
            // For demo purposes, show success message after delay
            setTimeout(() => {
                successMessage.style.display = 'flex';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }, 1500);
        });
        
        // Real-time validation
        titleInput.addEventListener('blur', function() {
            if (!this.value.trim()) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
        
        amountInput.addEventListener('blur', function() {
            const amount = parseFloat(this.value);
            if (!amount || amount <= 0 || amount > 99999999.99) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
        
        dateInput.addEventListener('blur', function() {
            const selectedDate = new Date(this.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (!this.value || selectedDate > today) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
        
        // Auto-format amount on blur
        amountInput.addEventListener('blur', function() {
            const value = parseFloat(this.value);
            if (!isNaN(value) && value >= 0) {
                this.value = value.toFixed(2);
            }
        });
        
        // Auto-suggest title based on amount
        amountInput.addEventListener('input', function() {
            const amount = parseFloat(this.value) || 0;
            if (amount > 10000 && !titleInput.value.trim()) {
                titleInput.placeholder = "Enter title (large expense detected)";
            }
        });
        
        // Set today's date as default if not set
        if (!dateInput.value) {
            const today = new Date().toISOString().split('T')[0];
            dateInput.value = today;
            updatePreview();
        }
        
        // Focus on title input when page loads
        titleInput.focus();
        
        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl + Enter to submit
            if (e.ctrlKey && e.key === 'Enter') {
                e.preventDefault();
                submitBtn.click();
            }
            
            // Esc to reset
            if (e.key === 'Escape') {
                e.preventDefault();
                resetBtn.click();
            }
        });
        
        // Add character counter for description
        const descriptionCounter = document.createElement('div');
        descriptionCounter.className = 'form-hint';
        descriptionCounter.innerHTML = '<i class="fas fa-text-height"></i> <span id="charCount">0</span>/1000 characters';
        descriptionInput.parentNode.insertBefore(descriptionCounter, descriptionInput.nextSibling);
        
        descriptionInput.addEventListener('input', function() {
            const charCount = document.getElementById('charCount');
            charCount.textContent = this.value.length;
            
            if (this.value.length > 1000) {
                this.classList.add('is-invalid');
                charCount.style.color = 'var(--danger)';
            } else {
                this.classList.remove('is-invalid');
                charCount.style.color = '';
            }
        });
    });
</script>

@endsection