@extends('layouts.app')

@section('title', 'Edit Marketing Project')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    :root {
        --primary: #2c5aa0;
        --primary-dark: #1e3d72;
        --secondary: #6c757d;
        --success: #28a745;
        --warning: #ffc107;
        --danger: #dc3545;
        --light: #f8f9fa;
        --dark: #343a40;
        --border: #dee2e6;
        --shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    
    .container {
        max-width: 1200px;
        margin: 90px auto 20px;
        padding: 20px;
    }
    
    .card {
        background: white;
        border-radius: 10px;
        box-shadow: var(--shadow);
        padding: 30px;
        margin-bottom: 30px;
    }
    
    .card-header {
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e9ecef;
    }
    
    .card-title {
        display: flex;
        align-items: center;
        color: var(--primary);
        font-weight: 600;
        font-size: 22px;
        margin: 0;
    }
    
    .card-title i {
        margin-right: 10px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: var(--dark);
        font-size: 14px;
    }
    
    .form-label.required::after {
        content: ' *';
        color: var(--danger);
    }
    
    .form-control {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid var(--border);
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.1);
    }
    
    .form-control.is-invalid {
        border-color: var(--danger);
        background-color: #fff8f8;
    }
    
    .invalid-feedback {
        color: var(--danger);
        font-size: 12px;
        margin-top: 5px;
        display: none;
    }
    
    .form-control.is-invalid ~ .invalid-feedback {
        display: block;
    }
    
    .form-row {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
    }
    
    .form-col {
        flex: 1;
    }
    
    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }
    
    .btn {
        padding: 10px 25px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .btn-primary {
        background-color: var(--primary);
        color: white;
    }
    
    .btn-primary:hover {
        background-color: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .btn-secondary {
        background-color: var(--secondary);
        color: white;
    }
    
    .btn-secondary:hover {
        background-color: #5a6268;
    }
    
    .btn-danger {
        background-color: var(--danger);
        color: white;
    }
    
    .btn-danger:hover {
        background-color: #c82333;
    }
    
    .alert {
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
        border-left: 4px solid;
    }
    
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border-color: var(--success);
    }
    
    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border-color: var(--danger);
    }
    
    .alert-warning {
        background-color: #fff3cd;
        color: #856404;
        border-color: var(--warning);
    }
    
    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
        }
        
        .form-actions {
            flex-direction: column;
        }
    }
</style>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">
                <i class="fas fa-edit"></i> Edit Marketing Project
            </h1>
            <p style="color: var(--secondary); margin-top: 5px; font-size: 14px;">
                Project ID: #{{ $project->id }} | Created: {{ $project->created_at->format('d M Y') }}
            </p>
        </div>
        
        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
        @endif
        
        <form action="{{ route('superadmin.marketing.projects.update', $project->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-row">
                <div class="form-col">
                    <label for="client_name" class="form-label required">Client Name</label>
                    <input type="text" name="client_name" id="client_name" 
                           class="form-control @error('client_name') is-invalid @enderror" 
                           value="{{ old('client_name', $project->client_name) }}" required>
                    @error('client_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-col">
                    <label for="phone_number" class="form-label required">Phone Number</label>
                    <input type="text" name="phone_number" id="phone_number" 
                           class="form-control @error('phone_number') is-invalid @enderror" 
                           value="{{ old('phone_number', $project->phone_number) }}" required>
                    @error('phone_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-col">
                    <label for="date" class="form-label required">Date</label>
                    <input type="date" name="date" id="date" 
                           class="form-control @error('date') is-invalid @enderror" 
                           value="{{ old('date', $project->date) }}" required>
                    @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-col">
                    <label for="reminder_date" class="form-label">Reminder Date</label>
                    <input type="date" name="reminder_date" id="reminder_date" 
                           class="form-control @error('reminder_date') is-invalid @enderror" 
                           value="{{ old('reminder_date', $project->reminder_date) }}">
                    @error('reminder_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-col">
                    <label for="project_type" class="form-label required">Project Type</label>
                    <select name="project_type" id="project_type" 
                            class="form-control @error('project_type') is-invalid @enderror" required>
                        <option value="">Select Project Type</option>
                        <option value="web" {{ old('project_type', $project->project_type) == 'web' ? 'selected' : '' }}>Web Development</option>
                        <option value="mobile_app" {{ old('project_type', $project->project_type) == 'mobile_app' ? 'selected' : '' }}>Mobile App</option>
                        <option value="graphic_design" {{ old('project_type', $project->project_type) == 'graphic_design' ? 'selected' : '' }}>Graphic Design</option>
                        <option value="social_media" {{ old('project_type', $project->project_type) == 'social_media' ? 'selected' : '' }}>Social Media</option>
                        <option value="seo" {{ old('project_type', $project->project_type) == 'seo' ? 'selected' : '' }}>SEO Services</option>
                        <option value="branding" {{ old('project_type', $project->project_type) == 'branding' ? 'selected' : '' }}>Branding</option>
                        <option value="video_production" {{ old('project_type', $project->project_type) == 'video_production' ? 'selected' : '' }}>Video Production</option>
                        <option value="content_writing" {{ old('project_type', $project->project_type) == 'content_writing' ? 'selected' : '' }}>Content Writing</option>
                    </select>
                    @error('project_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-col">
                    <label for="project_category" class="form-label required">Project Category</label>
                    <input type="text" name="project_category" id="project_category" 
                           class="form-control @error('project_category') is-invalid @enderror" 
                           value="{{ old('project_category', $project->project_category) }}" required>
                    @error('project_category')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-col">
                    <label for="contact_method" class="form-label required">Contact Method</label>
                    <select name="contact_method" id="contact_method" 
                            class="form-control @error('contact_method') is-invalid @enderror" required>
                        <option value="">Select Contact Method</option>
                        <option value="phone" {{ old('contact_method', $project->contact_method) == 'phone' ? 'selected' : '' }}>Phone Call</option>
                        <option value="email" {{ old('contact_method', $project->contact_method) == 'email' ? 'selected' : '' }}>Email</option>
                        <option value="whatsapp" {{ old('contact_method', $project->contact_method) == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                        <option value="in_person" {{ old('contact_method', $project->contact_method) == 'in_person' ? 'selected' : '' }}>In Person</option>
                        <option value="social_media" {{ old('contact_method', $project->contact_method) == 'social_media' ? 'selected' : '' }}>Social Media</option>
                    </select>
                    @error('contact_method')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-col">
                    <label for="call_sequence" class="form-label required">Call Sequence</label>
                    <select name="call_sequence" id="call_sequence" 
                            class="form-control @error('call_sequence') is-invalid @enderror" required>
                        <option value="">Select Call Sequence</option>
                        <option value="1st" {{ old('call_sequence', $project->call_sequence) == '1st' ? 'selected' : '' }}>1st Call</option>
                        <option value="2nd" {{ old('call_sequence', $project->call_sequence) == '2nd' ? 'selected' : '' }}>2nd Call</option>
                        <option value="3rd" {{ old('call_sequence', $project->call_sequence) == '3rd' ? 'selected' : '' }}>3rd Call</option>
                    </select>
                    @error('call_sequence')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-col">
                    <label for="first_call_date" class="form-label">First Call Date</label>
                    <input type="date" name="first_call_date" id="first_call_date" 
                           class="form-control @error('first_call_date') is-invalid @enderror" 
                           value="{{ old('first_call_date', $project->first_call_date) }}">
                    @error('first_call_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-col">
                    <label for="second_call_date" class="form-label">Second Call Date</label>
                    <input type="date" name="second_call_date" id="second_call_date" 
                           class="form-control @error('second_call_date') is-invalid @enderror" 
                           value="{{ old('second_call_date', $project->second_call_date) }}">
                    @error('second_call_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-col">
                    <label for="third_call_date" class="form-label">Third Call Date</label>
                    <input type="date" name="third_call_date" id="third_call_date" 
                           class="form-control @error('third_call_date') is-invalid @enderror" 
                           value="{{ old('third_call_date', $project->third_call_date) }}">
                    @error('third_call_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-col">
                    <label for="project_price" class="form-label required">Project Price (LKR)</label>
                    <input type="number" name="project_price" id="project_price" 
                           class="form-control @error('project_price') is-invalid @enderror" 
                           value="{{ old('project_price', $project->project_price) }}" 
                           step="0.01" min="0" required>
                    @error('project_price')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-col">
                    <label for="marketing_manager_id" class="form-label required">Marketing Manager</label>
                    <select name="marketing_manager_id" id="marketing_manager_id" 
                            class="form-control @error('marketing_manager_id') is-invalid @enderror" required>
                        <option value="">Select Marketing Manager</option>
                        @foreach($managers as $manager)
                            <option value="{{ $manager->employee_id }}" 
                                {{ old('marketing_manager_id', $project->marketing_manager_id) == $manager->employee_id ? 'selected' : '' }}>
                                {{ $manager->user->name ?? $manager->full_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('marketing_manager_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-col">
                    <label for="status" class="form-label required">Status</label>
                    <select name="status" id="status" 
                            class="form-control @error('status') is-invalid @enderror" required>
                        <option value="pending" {{ old('status', $project->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ old('status', $project->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="hold" {{ old('status', $project->status) == 'hold' ? 'selected' : '' }}>Hold</option>
                        <option value="cancelled" {{ old('status', $project->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label for="comments" class="form-label required">Comments</label>
                <textarea name="comments" id="comments" rows="4" 
                          class="form-control @error('comments') is-invalid @enderror" 
                          required>{{ old('comments', $project->comments) }}</textarea>
                @error('comments')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Project
                </button>
                <a href="{{ route('superadmin.marketing.projects.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                    <i class="fas fa-trash"></i> Delete Project
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="confirmDeleteModal" class="confirm-modal">
    <div class="confirm-modal-content">
        <div class="confirm-modal-header">
            <i class="fas fa-exclamation-triangle"></i>
            <h2 class="confirm-modal-title">Confirm Deletion</h2>
        </div>
        <div class="confirm-modal-body">
            <p>Are you sure you want to delete the project for <strong>{{ $project->client_name }}</strong>?</p>
            <p style="color: #dc3545; font-size: 14px; margin-top: 10px;">
                <i class="fas fa-exclamation-circle"></i> This action cannot be undone.
            </p>
        </div>
        <div class="confirm-modal-buttons">
            <button class="btn-cancel" onclick="closeConfirmModal()">Cancel</button>
            <form action="{{ route('superadmin.marketing.projects.destroy', $project->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-confirm-delete">
                    <i class="fas fa-trash"></i> Delete Project
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        document.getElementById('confirmDeleteModal').classList.add('active');
    }
    
    function closeConfirmModal() {
        document.getElementById('confirmDeleteModal').classList.remove('active');
    }
    
    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('confirmDeleteModal');
        if (event.target === modal) {
            closeConfirmModal();
        }
    });
    
    // Phone number duplicate check
    document.getElementById('phone_number').addEventListener('blur', function() {
        const phone = this.value;
        const managerId = document.getElementById('marketing_manager_id').value;
        const projectId = {{ $project->id }};
        
        if (phone && managerId) {
            fetch(`/superadmin/marketing/projects/check-phone?phone=${phone}&manager_id=${managerId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        alert(`Warning: This phone number is already assigned to another marketing manager.`);
                    }
                });
        }
    });
</script>

<!-- Add the same confirm-modal styles from the index page -->
<style>
    .confirm-modal {
        display: none;
        position: fixed;
        z-index: 1100;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        animation: fadeIn 0.3s;
    }

    .confirm-modal.active {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .confirm-modal-content {
        background: white;
        border-radius: 10px;
        padding: 30px;
        max-width: 450px;
        width: 90%;
        animation: slideUp 0.3s;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .confirm-modal-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }

    .confirm-modal-header i {
        font-size: 24px;
        color: var(--danger);
        margin-right: 15px;
    }

    .confirm-modal-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--danger);
    }

    .confirm-modal-body {
        margin-bottom: 25px;
        line-height: 1.6;
        color: #555;
    }

    .confirm-modal-buttons {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
    }

    .btn-cancel {
        padding: 10px 25px;
        background-color: var(--secondary);
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-cancel:hover {
        background-color: #5a6268;
    }

    .btn-confirm-delete {
        padding: 10px 25px;
        background-color: var(--danger);
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-confirm-delete:hover {
        background-color: #c82333;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from {
            transform: translateY(50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>
@endsection