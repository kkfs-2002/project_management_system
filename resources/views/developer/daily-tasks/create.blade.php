@extends('layouts.developer')

@section('title', 'Assign Daily Task')

@section('content')
<style>
    .form-container {
        background: white;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        max-width: 800px;
        margin: 0 auto;
    }
    
    .time-inputs {
        display: flex;
        gap: 15px;
        align-items: end;
    }
    
    .time-inputs .form-group {
        flex: 1;
    }
    
    .priority-badges {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }
    
    .priority-badge {
        padding: 8px 15px;
        border-radius: 20px;
        cursor: pointer;
        border: 2px solid #dee2e6;
        transition: all 0.3s;
    }
    
    .priority-badge.active {
        border-color: #007bff;
        background-color: #007bff;
        color: white;
    }
    
    .priority-badge.low { border-color: #6c757d; }
    .priority-badge.medium { border-color: #17a2b8; }
    .priority-badge.high { border-color: #ffc107; }
    .priority-badge.urgent { border-color: #dc3545; }
    
    .template-buttons .btn {
        transition: all 0.3s;
    }
    
    .time-slot {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }
    
    .time-slot h6 {
        color: #495057;
        margin-bottom: 15px;
    }
    
    .work-hours-info {
        background: #e7f3ff;
        border: 1px solid #b3d7ff;
        border-radius: 5px;
        padding: 10px;
        margin-top: 10px;
        font-size: 0.9em;
    }
    
    .working-days-container {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }
    
    .day-checkbox {
        margin-right: 10px;
    }
    
    .day-label {
        margin-right: 15px;
        cursor: pointer;
    }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="form-container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0 text-primary">
                        <i class="fas fa-plus-circle me-2"></i>Daily Task Updates
                    </h2>
                    <a href="{{ route('superadmin.daily-tasks.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Tasks
                    </a>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('superadmin.daily-tasks.store') }}" method="POST">
                    @csrf
                    
                       <div class="row">
                       <!-- Employee Selection -->
<div class="col-md-6">
    <div class="form-group mb-3">
        <label class="form-label fw-bold">Select Employee *</label>
        <select name="profile_id" id="profile_id" class="form-select" required onchange="updateTimeSlots()">
            <option value="">-- Choose Employee --</option>
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}" 
                    {{ old('profile_id') == $employee->id ? 'selected' : '' }}
                    data-role="{{ $employee->role }}"
                    data-work-start="{{ $employee->work_start_time ?? '09:00' }}"
                    data-work-end="{{ $employee->work_end_time ?? '17:00' }}">
                    {{ $employee->full_name }} 
                    ({{ $employee->employee_id }} - {{ $employee->role }})
                    @if($employee->employment_type)
                        - {{ ucfirst($employee->employment_type) }}
                    @endif
                </option>
            @endforeach
        </select>
        <div class="form-text">
            Available employees: {{ $employees->count() }}
            @if($employees->count() == 0)
                <span class="text-danger"> - No employees found! Please add employees first.</span>
            @endif
        </div>
    </div>
</div>
{{-- Debug --}}
<div style="display: none;">
    Employees Count: {{ isset($employees) ? $employees->count() : 'NOT SET' }}
    <br>
    Employees: {{ isset($employees) ? json_encode($employees->pluck('full_name')) : 'NOT SET' }}
</div>
                        <!-- Task Date -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Task Date *</label>
                                <input type="date" name="task_date" id="task_date" class="form-control" 
                                       value="{{ old('task_date', date('Y-m-d')) }}" required>
                                <div class="form-text">Date when this task should be completed</div>
                            </div>
                        </div>
                    </div>

                    <!-- Task Name -->
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">Task Name *</label>
                        <input type="text" name="task_name" class="form-control" 
                               value="{{ old('task_name') }}" 
                               placeholder="e.g., Develop User Authentication Module" required>
                        <div class="form-text">Enter a clear and descriptive task name</div>
                    </div>

                    <!-- Task Description -->
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">Today Completed Tasks</label>
                        <textarea name="description" class="form-control" rows="3" 
                                  placeholder="Describe the task in detail...">{{ old('description') }}</textarea>
                        <div class="form-text">Provide detailed instructions for this task</div>
                    </div>

                    <div class="row">
                        <!-- Task Type (Employee Role) -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Task Type (Role) *</label>
                                <select name="task_type" id="task_type" class="form-select" required onchange="updateWorkingDays()">
                                    <option value="">-- Select Task Type --</option>
                                    <option value="Senior Developer" {{ old('task_type') == 'Senior Developer' ? 'selected' : '' }}>Senior Developer</option>
                                    <option value="Junior Developer" {{ old('task_type') == 'Junior Developer' ? 'selected' : '' }}>Junior Developer</option>
                                    <option value="Intern/Trainee" {{ old('task_type') == 'Intern/Trainee' ? 'selected' : '' }}>Intern/Trainee</option>
                                    <option value="Marketing Manager" {{ old('task_type') == 'Marketing Manager' ? 'selected' : '' }}>Marketing Manager</option>
                                    <option value="Project Manager" {{ old('task_type') == 'Project Manager' ? 'selected' : '' }}>Project Manager</option>
                                </select>
                            </div>
                        </div>

                        <!-- Target Count -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Target Count *</label>
                                <input type="number" name="target_count" class="form-control" 
                                       value="{{ old('target_count', 1) }}" min="1" max="100" required>
                                <div class="form-text">Number of units to complete (e.g., 5 modules, 10 test cases)</div>
                            </div>
                        </div>
                    </div>

                    <!-- Working Days Section -->
                    <div class="working-days-container">
                        <h6><i class="fas fa-calendar me-2"></i>Working Days</h6>
                        <div class="form-group mb-3">
                            <div id="working_days_container">
                                <!-- Dynamic working days will be inserted here -->
                                <div class="form-text">Select a task type to see available working days</div>
                            </div>
                            <input type="hidden" name="working_days" id="working_days" value="{{ old('working_days') }}">
                        </div>
                    </div>

                    <!-- Time Slots Section - Simplified -->
                    <div class="time-slot">
                        <h6><i class="fas fa-clock me-2"></i>Work Time Schedule</h6>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">Start Time *</label>
                                    <input type="time" name="start_time" id="start_time" class="form-control" 
                                           value="{{ old('start_time', '09:00') }}" min="09:00" max="17:00" required onchange="validateTimeRange()">
                                    <div class="form-text">Work start time (9:00 AM - 5:00 PM)</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">End Time *</label>
                                    <input type="time" name="end_time" id="end_time" class="form-control" 
                                           value="{{ old('end_time', '17:00') }}" min="09:00" max="17:00" required onchange="validateTimeRange()">
                                    <div class="form-text">Work end time (9:00 AM - 5:00 PM)</div>
                                </div>
                            </div>
                        </div>

                        <div class="work-hours-info">
                            <small>
                                <i class="fas fa-info-circle me-1"></i>
                                <strong>Standard Working Hours:</strong> 9:00 AM - 5:00 PM
                                <br>
                                <strong>Note:</strong> Break times are automatically included in the schedule
                            </small>
                        </div>
                    </div>

                    <!-- Priority -->
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Priority *</label>
                                <div class="priority-badges">
                                    <div class="priority-badge low {{ old('priority', 'medium') == 'low' ? 'active' : '' }}" 
                                         data-priority="low">
                                        Low
                                    </div>
                                    <div class="priority-badge medium {{ old('priority', 'medium') == 'medium' ? 'active' : '' }}" 
                                         data-priority="medium">
                                        Medium
                                    </div>
                                    <div class="priority-badge high {{ old('priority') == 'high' ? 'active' : '' }}" 
                                         data-priority="high">
                                        High
                                    </div>
                                    <div class="priority-badge urgent {{ old('priority') == 'urgent' ? 'active' : '' }}" 
                                         data-priority="urgent">
                                        Urgent
                                    </div>
                                </div>
                                <input type="hidden" name="priority" id="priority" value="{{ old('priority', 'medium') }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="form-group mb-4">
                        <label class="form-label fw-bold">Additional Notes</label>
                        <textarea name="notes" class="form-control" rows="2" 
                                  placeholder="Any special instructions or notes...">{{ old('notes') }}</textarea>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('superadmin.daily-tasks.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <div class="btn-group">
                            <button type="submit" name="action" value="save" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Task
                            </button>
                            <button type="submit" name="action" value="save_and_new" class="btn btn-success">
                                <i class="fas fa-plus me-1"></i> Save & New
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Quick Templates Section -->
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-magic me-2"></i>Quick Task Templates
                    </h6>
                </div>
                <div class="card-body template-buttons">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-info w-100" onclick="fillTemplate('senior_dev')">
                                <i class="fas fa-code me-1"></i> Senior Dev
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-warning w-100" onclick="fillTemplate('junior_dev')">
                                <i class="fas fa-code me-1"></i> Junior Dev
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-success w-100" onclick="fillTemplate('intern')">
                                <i class="fas fa-user-graduate me-1"></i> Intern
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-secondary w-100" onclick="fillTemplate('project_manager')">
                                <i class="fas fa-tasks me-1"></i> Project Manager
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Priority selection
    const priorityBadges = document.querySelectorAll('.priority-badge');
    const priorityInput = document.getElementById('priority');
    
    priorityBadges.forEach(badge => {
        badge.addEventListener('click', function() {
            // Remove active class from all badges
            priorityBadges.forEach(b => b.classList.remove('active'));
            // Add active class to clicked badge
            this.classList.add('active');
            // Update hidden input value
            priorityInput.value = this.getAttribute('data-priority');
        });
    });

    // Initialize time slots
    updateTimeSlots();
    
    // Initialize working days based on selected task type
    updateWorkingDays();
});

// Update time slots based on selected employee
function updateTimeSlots() {
    const employeeSelect = document.getElementById('profile_id');
    const selectedOption = employeeSelect.options[employeeSelect.selectedIndex];
    
    if (selectedOption.value) {
        const workStart = selectedOption.getAttribute('data-work-start') || '09:00';
        const workEnd = selectedOption.getAttribute('data-work-end') || '17:00';
        const role = selectedOption.getAttribute('data-role');
        
        // Update time inputs with employee's work schedule
        document.getElementById('start_time').value = workStart;
        document.getElementById('start_time').min = workStart;
        document.getElementById('start_time').max = workEnd;
        
        document.getElementById('end_time').value = workEnd;
        document.getElementById('end_time').min = workStart;
        document.getElementById('end_time').max = workEnd;
        
        // Update task type based on employee role
        if (role) {
            document.getElementById('task_type').value = role;
            updateWorkingDays();
        }
    }
}

// Update working days based on selected task type
function updateWorkingDays() {
    const taskType = document.getElementById('task_type').value;
    const container = document.getElementById('working_days_container');
    const workingDaysInput = document.getElementById('working_days');
    
    // Define working days for each role
    const workingDaysByRole = {
        'Senior Developer': ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
        'Junior Developer': ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
        'Intern/Trainee': ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        'Marketing Manager': ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
        'Project Manager': ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']
    };
    
    // All possible days
    const allDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    
    if (taskType && workingDaysByRole[taskType]) {
        const daysForRole = workingDaysByRole[taskType];
        
        // Generate HTML for checkboxes
        let html = '';
        allDays.forEach(day => {
            const isChecked = daysForRole.includes(day);
            html += `
                <input type="checkbox" class="day-checkbox" id="day_${day}" value="${day}" ${isChecked ? 'checked' : ''}>
                <label class="day-label" for="day_${day}">${day}</label>
            `;
        });
        
        container.innerHTML = html;
        
        // Set initial value for working_days input
        workingDaysInput.value = daysForRole.join(',');
        
        // Add event listeners to checkboxes
        allDays.forEach(day => {
            const checkbox = document.getElementById(`day_${day}`);
            if (checkbox) {
                checkbox.addEventListener('change', updateWorkingDaysInput);
            }
        });
    } else {
        container.innerHTML = '<div class="form-text">Select a task type to see available working days</div>';
        workingDaysInput.value = '';
    }
}

// Update working days hidden input when checkboxes change
function updateWorkingDaysInput() {
    const checkboxes = document.querySelectorAll('.day-checkbox:checked');
    const selectedDays = Array.from(checkboxes).map(cb => cb.value);
    document.getElementById('working_days').value = selectedDays.join(',');
}

// Validate time range
function validateTimeRange() {
    const startTime = document.getElementById('start_time').value;
    const endTime = document.getElementById('end_time').value;
    
    if (startTime && endTime) {
        if (startTime >= endTime) {
            alert('End time must be after start time!');
            document.getElementById('end_time').value = addTime(startTime, 60); // Add 1 hour
        }
    }
}

// Add minutes to time
function addTime(time, minutes) {
    const [hours, mins] = time.split(':').map(Number);
    const date = new Date();
    date.setHours(hours);
    date.setMinutes(mins + minutes);
    
    return date.getHours().toString().padStart(2, '0') + ':' + 
           date.getMinutes().toString().padStart(2, '0');
}

// Quick task templates
function fillTemplate(templateType) {
    const templates = {
        'senior_dev': {
            name: 'Architecture Design and Code Review',
            description: 'Design system architecture and review junior developer code',
            type: 'Senior Developer',
            target_count: 2,
            start_time: '09:00',
            end_time: '12:00'
        },
        'junior_dev': {
            name: 'Feature Implementation',
            description: 'Implement assigned features following coding standards',
            type: 'Junior Developer', 
            target_count: 5,
            start_time: '09:00',
            end_time: '12:30'
        },
        'intern': {
            name: 'Learning and Small Tasks',
            description: 'Complete assigned learning modules and small development tasks',
            type: 'Intern/Trainee',
            target_count: 3,
            start_time: '09:00',
            end_time: '13:00'
        },
        'project_manager': {
            name: 'Project Planning and Coordination',
            description: 'Update project plans and coordinate with team members',
            type: 'Project Manager',
            target_count: 1,
            start_time: '09:00',
            end_time: '11:00'
        }
    };

    const template = templates[templateType];
    if (template) {
        document.querySelector('input[name="task_name"]').value = template.name;
        document.querySelector('textarea[name="description"]').value = template.description;
        document.querySelector('select[name="task_type"]').value = template.type;
        document.querySelector('input[name="target_count"]').value = template.target_count;
        document.querySelector('input[name="start_time"]').value = template.start_time;
        document.querySelector('input[name="end_time"]').value = template.end_time;
        
        // Update working days based on selected template
        updateWorkingDays();
    }
}
</script>
@endsection