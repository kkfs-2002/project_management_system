@extends('layouts.app')

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
    
    .project-container {
        max-width: 800px;
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
    
    .form-hint {
        display: block;
        margin-top: 6px;
        font-size: 13px;
        color: var(--secondary);
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
    
    .project-preview {
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
    
    .type-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }
    
    .type-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        border: 2px solid transparent;
    }
    
    .type-badge:hover {
        transform: translateY(-1px);
    }
    
    .type-badge.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    
    .type-badge:not(.active) {
        background: var(--light);
        color: var(--secondary);
        border: 2px solid var(--border);
    }
    
    .type-badge:not(.active):hover {
        background: var(--primary-light);
        color: var(--primary);
        border-color: var(--primary);
    }
    
    .required::after {
        content: " *";
        color: var(--danger);
    }
    
    @media (max-width: 768px) {
        .project-container {
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
</style>

<div class="project-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <i class="fas fa-plus-circle"></i>
            <div>
                <h1>Create New Project</h1>
                <p>Add a new project to your portfolio and start tracking progress</p>
            </div>
        </div>
    </div>

    <!-- Project Form -->
    <div class="form-card">
        <div class="form-header">
            <h2><i class="fas fa-project-diagram"></i> Project Information</h2>
        </div>
        
        <form method="POST" action="{{ route('superadmin.project.store') }}" id="projectForm">
            @csrf
            
            <div class="form-body">
                <div class="form-grid">
                    <!-- Project Name -->
                    <div class="form-group full-width">
                        <label class="form-label required">
                            <i class="fas fa-heading"></i>Project Name
                        </label>
                        <input type="text" name="name" class="form-control" 
                               placeholder="Enter project name (e.g., E-Commerce Website, Mobile Banking App)" 
                               required maxlength="100">
                        <span class="form-hint">Choose a descriptive name that clearly identifies the project</span>
                    </div>

                    <!-- Project Type -->
                    <div class="form-group full-width">
                        <label class="form-label required">
                            <i class="fas fa-tags"></i>Project Type
                        </label>
                        <div class="type-badges">
                            <div class="type-badge active" data-value="Website">
                                <i class="fas fa-globe me-2"></i>Website
                            </div>
                            <div class="type-badge" data-value="System">
                                <i class="fas fa-server me-2"></i>System
                            </div>
                            <div class="type-badge" data-value="Mobile App">
                                <i class="fas fa-mobile-alt me-2"></i>Mobile App
                            </div>
                            <div class="type-badge" data-value="Other">
                                <i class="fas fa-cube me-2"></i>Other
                            </div>
                        </div>
                        <select name="type" class="form-control mt-3" required style="display: none;">
                            <option value="">Select Type</option>
                            <option value="Website" selected>Website</option>
                            <option value="System">System</option>
                            <option value="Mobile App">Mobile App</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- Date Section -->
                    <div class="form-group full-width">
                        <label class="form-label">
                            <i class="fas fa-calendar-alt"></i>Project Timeline
                        </label>
                        <div class="date-grid">
                            <div class="date-card">
                                <label class="form-label required">
                                    <i class="fas fa-play-circle"></i>Start Date
                                </label>
                                <input type="date" name="start_date" class="form-control" required>
                                <span class="form-hint">Project commencement date</span>
                            </div>
                            
                            <div class="date-card">
                                <label class="form-label required">
                                    <i class="fas fa-flag-checkered"></i>Project Deadline
                                </label>
                                <input type="date" name="deadline" class="form-control" required>
                                <span class="form-hint">Project completion deadline</span>
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
                        <i class="fas fa-save"></i>Create Project
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Project Preview -->
    <div class="project-preview">
        <div class="preview-header">
            <i class="fas fa-eye"></i>
            <h3>Project Preview</h3>
        </div>
        <div class="preview-grid">
            <div class="preview-item">
                <div class="preview-label">Project Name</div>
                <div class="preview-value" id="preview-name">-</div>
            </div>
            <div class="preview-item">
                <div class="preview-label">Project Type</div>
                <div class="preview-value" id="preview-type">Website</div>
            </div>
            <div class="preview-item">
                <div class="preview-label">Start Date</div>
                <div class="preview-value" id="preview-start">-</div>
            </div>
            <div class="preview-item">
                <div class="preview-label">Deadline</div>
                <div class="preview-value" id="preview-deadline">-</div>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize type badges
    document.addEventListener('DOMContentLoaded', function() {
        const typeBadges = document.querySelectorAll('.type-badge');
        const typeSelect = document.querySelector('select[name="type"]');
        
        typeBadges.forEach(badge => {
            badge.addEventListener('click', function() {
                // Remove active class from all badges
                typeBadges.forEach(b => b.classList.remove('active'));
                // Add active class to clicked badge
                this.classList.add('active');
                // Update hidden select value
                const value = this.getAttribute('data-value');
                typeSelect.value = value;
                // Update preview
                document.getElementById('preview-type').textContent = value;
            });
        });
        
        // Real-time preview updates
        const nameInput = document.querySelector('input[name="name"]');
        const startDateInput = document.querySelector('input[name="start_date"]');
        const deadlineInput = document.querySelector('input[name="deadline"]');
        
        nameInput.addEventListener('input', function() {
            document.getElementById('preview-name').textContent = this.value || '-';
        });
        
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
        const form = document.getElementById('projectForm');
        form.addEventListener('submit', function(e) {
            const startDate = new Date(startDateInput.value);
            const deadline = new Date(deadlineInput.value);
            
            if (deadline <= startDate) {
                e.preventDefault();
                alert('Project deadline must be after the start date.');
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
        
        // Initialize preview with current date values if any
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