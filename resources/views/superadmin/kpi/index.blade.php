@extends('layouts.app')

@section('title', 'Set New KPI')

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
    
    .target-inputs .form-group {
        margin-bottom: 15px;
    }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="form-container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0 text-primary">
                        <i class="fas fa-plus-circle me-2"></i>Set New KPI
                    </h2>
                    <a href="{{ route('superadmin.kpi.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to KPIs
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

                <form action="{{ route('superadmin.kpi.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <!-- Employee Selection -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Select Employee *</label>
                                <select name="profile_id" class="form-select" required>
                                    <option value="">-- Choose Employee --</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}" 
                                            {{ old('profile_id') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->full_name }} 
                                            ({{ $employee->employee_id }} - {{ $employee->role }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Select the employee for this KPI</div>
                            </div>
                        </div>

                        <!-- KPI Name -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">KPI Name *</label>
                                <input type="text" name="kpi_name" class="form-control" 
                                       value="{{ old('kpi_name') }}" 
                                       placeholder="e.g., Code Completion Rate, Bug Fix Rate" required>
                                <div class="form-text">Enter a clear and descriptive KPI name</div>
                            </div>
                        </div>
                    </div>

                    <!-- KPI Description -->
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="3" 
                                  placeholder="Describe what this KPI measures...">{{ old('description') }}</textarea>
                        <div class="form-text">Provide details about what this KPI tracks and measures</div>
                    </div>

                    <div class="row">
                        <!-- Measurement Unit -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Measurement Unit *</label>
                                <input type="text" name="measurement_unit" class="form-control" 
                                       value="{{ old('measurement_unit') }}" 
                                       placeholder="e.g., tasks, hours, lines, modules" required>
                                <div class="form-text">Unit of measurement (tasks, hours, points, etc.)</div>
                            </div>
                        </div>

                        <!-- Start Date -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Start Date *</label>
                                <input type="date" name="start_date" class="form-control" 
                                       value="{{ old('start_date', date('Y-m-d')) }}" required>
                                <div class="form-text">When should this KPI tracking begin?</div>
                            </div>
                        </div>
                    </div>

                    <!-- End Date -->
                    <div class="form-group mb-4">
                        <label class="form-label fw-bold">End Date (Optional)</label>
                        <input type="date" name="end_date" class="form-control" 
                               value="{{ old('end_date') }}">
                        <div class="form-text">Leave empty for ongoing KPI tracking</div>
                    </div>

                    <!-- Target Settings -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-bullseye me-2"></i>Target Settings
                            </h6>
                        </div>
                        <div class="card-body target-inputs">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Daily Target *</label>
                                        <input type="number" name="daily_target" class="form-control" 
                                               value="{{ old('daily_target', 1) }}" step="0.01" min="0.01" required>
                                        <div class="form-text">Target per day</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Weekly Target *</label>
                                        <input type="number" name="weekly_target" class="form-control" 
                                               value="{{ old('weekly_target', 5) }}" step="0.01" min="0.01" required>
                                        <div class="form-text">Target per week</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Monthly Target *</label>
                                        <input type="number" name="monthly_target" class="form-control" 
                                               value="{{ old('monthly_target', 20) }}" step="0.01" min="0.01" required>
                                        <div class="form-text">Target per month</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Templates -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-magic me-2"></i>Quick KPI Templates
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-outline-info w-100" onclick="fillTemplate('developer')">
                                        <i class="fas fa-code me-1"></i> Developer
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-outline-warning w-100" onclick="fillTemplate('tester')">
                                        <i class="fas fa-bug me-1"></i> Tester
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-outline-success w-100" onclick="fillTemplate('designer')">
                                        <i class="fas fa-palette me-1"></i> Designer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('superadmin.kpi.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <div class="btn-group">
                            <button type="submit" name="action" value="save" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save KPI
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

<script>
function fillTemplate(role) {
    const templates = {
        'developer': {
            kpi_name: 'Code Completion Rate',
            description: 'Measure the rate of completed code modules and features',
            measurement_unit: 'modules',
            daily_target: 2,
            weekly_target: 10,
            monthly_target: 40
        },
        'tester': {
            kpi_name: 'Test Case Execution',
            description: 'Track the number of test cases executed and bugs found',
            measurement_unit: 'test cases',
            daily_target: 15,
            weekly_target: 75,
            monthly_target: 300
        },
        'designer': {
            kpi_name: 'Design Completion',
            description: 'Measure completed design mockups and UI components',
            measurement_unit: 'mockups',
            daily_target: 3,
            weekly_target: 15,
            monthly_target: 60
        }
    };

    const template = templates[role];
    if (template) {
        document.querySelector('input[name="kpi_name"]').value = template.kpi_name;
        document.querySelector('textarea[name="description"]').value = template.description;
        document.querySelector('input[name="measurement_unit"]').value = template.measurement_unit;
        document.querySelector('input[name="daily_target"]').value = template.daily_target;
        document.querySelector('input[name="weekly_target"]').value = template.weekly_target;
        document.querySelector('input[name="monthly_target"]').value = template.monthly_target;
    }
}
</script>
@endsection