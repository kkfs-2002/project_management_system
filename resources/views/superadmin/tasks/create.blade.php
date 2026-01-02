@extends('layouts.app')

@section('title', 'Assign Task')

@section('content')
<style>
    :root {
        --primary: #2c5aa0;
        --primary-light: #e8eff7;
        --secondary: #6c757d;
        --success: #28a745;
        --warning: #ffc107;
        --danger: #dc3545;
        --info: #17a2b8;
        --light: #f8f9fa;
        --dark: #343a40;
        --border: #dee2e6;
        --shadow: 0 4px 12px rgba(0,0,0,0.08);
        --radius: 12px;
    }
    
    .task-assign-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .page-header {
        background: linear-gradient(135deg, var(--primary) 0%, #1e3d72 100%);
        border-radius: var(--radius);
        padding: 30px;
        color: white;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        margin-top: 100px;
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        transform: translate(40px, -40px);
    }
    
    .page-title {
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        z-index: 2;
    }
    
    .page-title i {
        font-size: 36px;
        background: rgba(255,255,255,0.2);
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
    }
    
    .page-title h1 {
        margin: 0;
        font-weight: 700;
        font-size: 28px;
    }
    
    .page-title p {
        margin: 8px 0 0 0;
        opacity: 0.9;
        font-size: 16px;
    }
    
    .form-card {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }
    
    .form-header {
        background: var(--primary-light);
        padding: 25px 30px;
        border-bottom: 1px solid var(--border);
    }
    
    .form-header h2 {
        margin: 0;
        color: var(--primary);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .form-body {
        padding: 30px;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }
    
    .form-group {
        margin-bottom: 0;
    }
    
    .form-group.full-width {
        grid-column: 1 / -1;
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
        color: var(--primary);
        width: 20px;
        text-align: center;
    }
    
    .form-control {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid var(--border);
        border-radius: 8px;
        font-size: 15px;
        transition: all 0.3s;
        background: white;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(44, 90, 160, 0.1);
        background: white;
    }
    
    .form-control:hover {
        border-color: #adb5bd;
    }
    
    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%236c757d' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
        background-size: 16px;
        padding-right: 45px;
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 120px;
        line-height: 1.5;
    }
    
    .date-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
    }
    
    .date-card {
        background: var(--primary-light);
        border: 2px dashed var(--primary);
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s;
    }
    
    .date-card:hover {
        background: white;
        border-color: var(--primary);
        transform: translateY(-2px);
    }
    
    .date-card .form-label {
        justify-content: center;
        color: var(--primary);
        margin-bottom: 15px;
    }
    
    .date-card .form-control {
        text-align: center;
        font-weight: 600;
        border: 2px solid transparent;
        background: rgba(255,255,255,0.9);
    }
    
    .date-card .form-control:focus {
        border-color: var(--primary);
        background: white;
    }
    
    .form-hint {
        display: block;
        margin-top: 6px;
        font-size: 13px;
        color: var(--secondary);
    }
    
    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        padding-top: 25px;
        border-top: 1px solid var(--border);
        flex-wrap: wrap;
    }
    
    .btn {
        padding: 14px 28px;
        border-radius: 8px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        text-decoration: none;
        font-size: 15px;
        min-width: 140px;
        justify-content: center;
    }
    
    .btn-primary {
        background: var(--primary);
        color: white;
    }
    
    .btn-primary:hover {
        background: #1e3d72;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(44, 90, 160, 0.3);
        color: white;
    }
    
    .btn-outline {
        background: white;
        color: var(--primary);
        border: 2px solid var(--primary);
    }
    
    .btn-outline:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
        color: var(--primary);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .task-preview {
        background: var(--light);
        border-radius: var(--radius);
        padding: 25px;
        margin-top: 30px;
        border-left: 4px solid var(--primary);
    }
    
    .preview-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }
    
    .preview-header i {
        color: var(--primary);
        font-size: 20px;
    }
    
    .preview-header h3 {
        margin: 0;
        color: var(--dark);
        font-weight: 600;
    }
    
    .preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }
    
    .preview-item {
        background: white;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid var(--border);
    }
    
    .preview-label {
        font-size: 13px;
        color: var(--secondary);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }
    
    .preview-value {
        font-weight: 600;
        color: var(--dark);
        font-size: 15px;
    }
    
    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
        margin-right: 10px;
    }
    
    .user-display {
        display: flex;
        align-items: center;
    }
    
    .required::after {
        content: " *";
        color: var(--danger);
    }
    
    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        border-radius: var(--radius);
        padding: 15px 20px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .alert-success i {
        font-size: 18px;
    }
    
    @media (max-width: 768px) {
        .task-assign-container {
            padding: 15px;
        }
        
        .page-header {
            padding: 25px 20px;
        }
        
        .page-title {
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }
        
        .form-body {
            padding: 25px 20px;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .date-grid {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            justify-content: stretch;
        }
        
        .form-actions .btn {
            flex: 1;
            min-width: auto;
        }
        
        .preview-grid {
            grid-template-columns: 1fr;
        }
    }
    
    /* Animation for form interactions */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .form-group {
        animation: fadeIn 0.5s ease-out;
    }
    
    .form-group:nth-child(1) { animation-delay: 0.1s; }
    .form-group:nth-child(2) { animation-delay: 0.2s; }
    .form-group:nth-child(3) { animation-delay: 0.3s; }
    .form-group:nth-child(4) { animation-delay: 0.4s; }
    .form-group:nth-child(5) { animation-delay: 0.5s; }
</style>

<div class="task-assign-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <i class="fas fa-tasks"></i>
            <div>
                <h1>Assign New Project</h1>
                <p>Create and assign projects to your team members efficiently</p>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Task Form -->
    <div class="form-card">
        <div class="form-header">
            <h2><i class="fas fa-clipboard-list"></i> Projects Details</h2>
        </div>
        
        <form action="{{ route('tasks.store') }}" method="POST" id="taskForm">
            @csrf
            
            <div class="form-body">
                <div class="form-grid">
                    <!-- Project Selection -->
                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-project-diagram"></i>Project
                        </label>
                        <select name="project_id" id="project_id" class="form-control" required>
                            <option value="">-- Choose Project --</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                        <span class="form-hint">Select the project this task belongs to</span>
                    </div>

                    <!-- Project Manager -->
                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-user-tie"></i>Project Manager
                        </label>
                        <select name="project_manager_id" id="project_manager_id" class="form-control" required>
                            <option value="">-- Choose Project Manager --</option>
                            @foreach($projectManagers as $pm)
                                <option value="{{ $pm->id }}">{{ $pm->full_name }}</option>
                            @endforeach
                        </select>
                        <span class="form-hint">Select the responsible project manager</span>
                    </div>

                    <!-- Developer -->
                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-code"></i>Developer
                        </label>
                        <select name="developer_id" id="developer_id" class="form-control" required>
                            <option value="">-- Choose Developer --</option>
                            @foreach($developers as $dev)
                                <option value="{{ $dev->id }}">{{ $dev->full_name }}</option>
                            @endforeach
                        </select>
                        <span class="form-hint">Select the developer assigned to this task</span>
                    </div>

                    <!-- Task Title -->
                    <div class="form-group full-width">
                        <label class="form-label required">
                            <i class="fas fa-heading"></i>Task Title
                        </label>
                        <input type="text" name="title" id="title" class="form-control" 
                               placeholder="Enter a clear and descriptive task title" required maxlength="255">
                        <span class="form-hint">Be specific about what needs to be done</span>
                    </div>

                    <!-- Task Description -->
                    <div class="form-group full-width">
                        <label class="form-label required">
                            <i class="fas fa-align-left"></i>Task Description
                        </label>
                        <textarea name="description" id="description" class="form-control" 
                                  placeholder="Provide detailed description of the task, requirements, and expectations..." 
                                  rows="4" required></textarea>
                        <span class="form-hint">Include any specific requirements or acceptance criteria</span>
                    </div>

                    <!-- Date Section -->
                    <div class="form-group full-width">
                        <label class="form-label">
                            <i class="fas fa-calendar-alt"></i>Task Timeline
                        </label>
                        <div class="date-grid">
                            <div class="date-card">
                                <label class="form-label required">
                                    <i class="fas fa-play-circle"></i>Start Date
                                </label>
                                <input type="date" name="start_date" id="start_date" class="form-control" required>
                                <span class="form-hint">When work should begin</span>
                            </div>
                            
                            <div class="date-card">
                                <label class="form-label required">
                                    <i class="fas fa-flag-checkered"></i>End Date
                                </label>
                                <input type="date" name="deadline" id="deadline" class="form-control" required>
                                <span class="form-hint">When task should be completed</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="javascript:history.back()" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i>Assign Task
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Task Preview -->
    <div class="task-preview">
        <div class="preview-header">
            <i class="fas fa-eye"></i>
            <h3>Projects Preview</h3>
        </div>
        <div class="preview-grid">
            <div class="preview-item">
                <div class="preview-label">Project</div>
                <div class="preview-value" id="preview-project">-</div>
            </div>
            <div class="preview-item">
                <div class="preview-label">Project Manager</div>
                <div class="preview-value" id="preview-pm">-</div>
            </div>
            <div class="preview-item">
                <div class="preview-label">Developer</div>
                <div class="preview-value" id="preview-developer">-</div>
            </div>
            <div class="preview-item">
                <div class="preview-label">Task Title</div>
                <div class="preview-value" id="preview-title">-</div>
            </div>
            <div class="preview-item">
                <div class="preview-label">Start Date</div>
                <div class="preview-value" id="preview-start">-</div>
            </div>
            <div class="preview-item">
                <div class="preview-label">End Date</div>
                <div class="preview-value" id="preview-deadline">-</div>
            </div>
        </div>
        <div class="preview-item full-width" style="grid-column: 1 / -1; margin-top: 15px;">
            <div class="preview-label">Description</div>
            <div class="preview-value" id="preview-description" style="font-weight: normal; line-height: 1.5;">-</div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Real-time preview updates
        const projectSelect = document.getElementById('project_id');
        const pmSelect = document.getElementById('project_manager_id');
        const developerSelect = document.getElementById('developer_id');
        const titleInput = document.getElementById('title');
        const descriptionInput = document.getElementById('description');
        const startDateInput = document.getElementById('start_date');
        const deadlineInput = document.getElementById('deadline');
        
        // Update project preview
        projectSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            document.getElementById('preview-project').textContent = selectedOption.text || '-';
        });
        
        // Update project manager preview
        pmSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            document.getElementById('preview-pm').textContent = selectedOption.text || '-';
        });
        
        // Update developer preview
        developerSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            document.getElementById('preview-developer').textContent = selectedOption.text || '-';
        });
        
        // Update title preview
        titleInput.addEventListener('input', function() {
            document.getElementById('preview-title').textContent = this.value || '-';
        });
        
        // Update description preview
        descriptionInput.addEventListener('input', function() {
            document.getElementById('preview-description').textContent = this.value || '-';
        });
        
        // Update start date preview
        startDateInput.addEventListener('change', function() {
            if (this.value) {
                const date = new Date(this.value);
                document.getElementById('preview-start').textContent = date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            } else {
                document.getElementById('preview-start').textContent = '-';
            }
        });
        
        // Update deadline preview
        deadlineInput.addEventListener('change', function() {
            if (this.value) {
                const date = new Date(this.value);
                document.getElementById('preview-deadline').textContent = date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            } else {
                document.getElementById('preview-deadline').textContent = '-';
            }
        });
        
        // Form validation
        const form = document.getElementById('taskForm');
        form.addEventListener('submit', function(e) {
            const startDate = new Date(startDateInput.value);
            const deadline = new Date(deadlineInput.value);
            
            if (deadline <= startDate) {
                e.preventDefault();
                alert('Task deadline must be after the start date.');
                deadlineInput.focus();
            }
        });
        
        // Set minimum date for deadline to start date
        startDateInput.addEventListener('change', function() {
            if (this.value) {
                deadlineInput.min = this.value;
            }
        });
        
        // Set minimum date for start date to today
        const today = new Date().toISOString().split('T')[0];
        startDateInput.min = today;
        
        // Initialize preview with current values if any
        if (projectSelect.value) {
            projectSelect.dispatchEvent(new Event('change'));
        }
        if (pmSelect.value) {
            pmSelect.dispatchEvent(new Event('change'));
        }
        if (developerSelect.value) {
            developerSelect.dispatchEvent(new Event('change'));
        }
        if (titleInput.value) {
            titleInput.dispatchEvent(new Event('input'));
        }
        if (descriptionInput.value) {
            descriptionInput.dispatchEvent(new Event('input'));
        }
        if (startDateInput.value) {
            startDateInput.dispatchEvent(new Event('change'));
        }
        if (deadlineInput.value) {
            deadlineInput.dispatchEvent(new Event('change'));
        }
    });
</script>

<!-- Font Awesome for icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

@endsection