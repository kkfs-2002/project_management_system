@extends('layouts.app')

@section('title', 'Employee List')

@section('content')
<style>
    :root {
        --primary: #2c5aa0;
        --primary-light: #e8eff7;
        --secondary: #6c757d;
        --success: #28a745;
        --warning: #ffc107;
        --danger: #dc3545;
        --light: #f8f9fa;
        --dark: #343a40;
        --border: #dee2e6;
        --shadow: 0 4px 12px rgba(0,0,0,0.08);
        --radius: 8px;
    }
    
    .employee-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding: 25px;
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        margin-top: 60px;
    }
    
    .page-title {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .page-title i {
        font-size: 32px;
        color: var(--primary);
        background: var(--primary-light);
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .page-title h1 {
        margin: 0;
        color: var(--dark);
        font-weight: 700;
    }
    
    .page-title p {
        margin: 5px 0 0 0;
        color: var(--secondary);
    }
    
    .filter-section {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .filter-label {
        font-weight: 600;
        color: var(--dark);
        white-space: nowrap;
    }
    
    .filter-select {
        min-width: 200px;
        padding: 10px 15px;
        border: 1px solid var(--border);
        border-radius: 6px;
        background: white;
        font-size: 14px;
    }
    
    .clear-filter {
        padding: 10px 15px;
        background: var(--light);
        border: 1px solid var(--border);
        border-radius: 6px;
        color: var(--secondary);
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .clear-filter:hover {
        background: var(--danger);
        color: white;
        border-color: var(--danger);
    }
    
    .alert-success {
        padding: 15px 20px;
        background: #d4edda;
        color: #155724;
        border-radius: var(--radius);
        margin-bottom: 25px;
        border-left: 4px solid var(--success);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .employee-card {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        margin-bottom: 20px;
    }
    
    .card-header {
        background: var(--primary-light);
        padding: 20px 25px;
        border-bottom: 1px solid var(--border);
    }
    
    .card-header h3 {
        margin: 0;
        color: var(--primary);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .table-container {
        overflow-x: auto;
    }
    
    .employee-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1000px;
    }
    
    .employee-table thead {
        background: var(--light);
    }
    
    .employee-table th {
        padding: 18px 20px;
        text-align: left;
        font-weight: 600;
        color: var(--dark);
        border-bottom: 2px solid var(--border);
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.5px;
    }
    
    .employee-table td {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }
    
    .employee-table tbody tr {
        transition: all 0.3s ease;
    }
    
    .employee-table tbody tr:hover {
        background: var(--primary-light);
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .employee-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 16px;
    }
    
    .employee-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .employee-details h5 {
        margin: 0;
        font-weight: 600;
        color: var(--dark);
    }
    
    .employee-details p {
        margin: 2px 0 0 0;
        color: var(--secondary);
        font-size: 13px;
    }
    
    .badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .badge-department {
        background: #e8f4ff;
        color: var(--primary);
    }
    
    .badge-role {
        background: #fff3cd;
        color: #856404;
    }
    
    .action-buttons {
        display: flex;
        gap: 8px;
    }
    
    .btn-action {
        width: 36px;
        height: 36px;
        border: none;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        cursor: pointer;
        font-size: 14px;
    }
    
    .btn-view {
        background: var(--primary-light);
        color: var(--primary);
    }
    
    .btn-view:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-edit {
        background: #fff3cd;
        color: var(--warning);
    }
    
    .btn-edit:hover {
        background: var(--warning);
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-delete {
        background: #f8d7da;
        color: var(--danger);
    }
    
    .btn-delete:hover {
        background: var(--danger);
        color: white;
        transform: translateY(-2px);
    }
    
    .edit-form-container {
        background: #f8f9fa;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 25px;
        margin: 10px 0;
    }
    
    .edit-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        align-items: end;
    }
    
    .form-group {
        margin-bottom: 0;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: var(--dark);
        font-size: 13px;
    }
    
    .form-control {
        width: 100%;
        padding: 10px 12px;
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
    
    .form-actions {
        display: flex;
        gap: 10px;
        grid-column: 1 / -1;
        margin-top: 10px;
    }
    
    .btn-save {
        background: var(--success);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-save:hover {
        background: #218838;
        transform: translateY(-2px);
    }
    
    .btn-cancel {
        background: var(--secondary);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-cancel:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }
    
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 30px;
    }
    
    .pagination {
        display: flex;
        gap: 8px;
    }
    
    .page-item {
        list-style: none;
    }
    
    .page-link {
        padding: 10px 16px;
        border: 1px solid var(--border);
        border-radius: 6px;
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .page-link:hover {
        background: var(--primary-light);
        border-color: var(--primary);
    }
    
    .page-item.active .page-link {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: white;
        padding: 25px;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        text-align: center;
    }
    
    .stat-number {
        font-size: 32px;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 5px;
    }
    
    .stat-label {
        color: var(--secondary);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.5px;
    }
    
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: 20px;
            align-items: flex-start;
        }
        
        .filter-section {
            width: 100%;
            justify-content: space-between;
        }
        
        .edit-form {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="employee-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <i class="fas fa-users"></i>
            <div>
                <h1>Employee Management</h1>
                <p>Manage your organization's employees efficiently</p>
            </div>
        </div>
        
        <div class="filter-section">
            <span class="filter-label">Filter by Job Title:</span>
            <form method="GET" action="{{ route('superadmin.employee.index') }}" class="d-flex align-items-center" style="gap: 10px;">
                <select name="job_title" id="job_title" class="filter-select" onchange="this.form.submit()">
                    <option value="">All Job Titles</option>
                    @foreach($jobTitles as $title)
                        <option value="{{ $title }}" {{ request('job_title') == $title ? 'selected' : '' }}>
                            {{ $title }}
                        </option>
                    @endforeach
                </select>
                @if(request('job_title'))
                    <a href="{{ route('superadmin.employee.index') }}" class="clear-filter" title="Clear Filter">
                        <i class="fas fa-times"></i> Clear
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Statistics Row -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-number">{{ $employees->total() }}</div>
            <div class="stat-label">Total Employees</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $jobTitles->count() }}</div>
            <div class="stat-label">Job Titles</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $employees->unique('department')->count() }}</div>
            <div class="stat-label">Departments</div>
        </div>
    </div>

    <!-- Employee Table -->
    <div class="employee-card">
        <div class="card-header">
            <h3><i class="fas fa-list"></i> Employee Directory</h3>
        </div>
        
        <div class="table-container">
            <table class="employee-table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Contact</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $emp)
                        <tr id="employee-row-{{ $emp->id }}">
                            <td>
                                <div class="employee-info">
                                    <div class="employee-avatar">
                                        {{ substr($emp->full_name, 0, 1) }}
                                    </div>
                                    <div class="employee-details">
                                        <h5>{{ $emp->full_name }}</h5>
                                        <p>ID: {{ $emp->employee_id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div style="font-weight: 500;">{{ $emp->email }}</div>
                                    <div style="color: var(--secondary); font-size: 13px;">{{ $emp->phone }}</div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-department">{{ $emp->department }}</span>
                            </td>
                            <td>
                                <span class="badge badge-role">{{ $emp->job_title }}</span>
                            </td>
                            <td>
                                <span class="badge" style="background: #d4edda; color: #155724;">
                                    Active
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('superadmin.employee.show', $emp->id) }}" class="btn-action btn-view" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn-action btn-edit btn-edit-row" data-id="{{ $emp->id }}" title="Edit Employee">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('superadmin.employee.destroy', $emp->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" title="Delete Employee">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Form Row -->
                        <tr id="edit-form-row-{{ $emp->id }}" style="display:none;">
                            <td colspan="6">
                                <div class="edit-form-container">
                                    <h4 style="margin-bottom: 20px; color: var(--primary);">
                                        <i class="fas fa-edit me-2"></i>Edit Employee: {{ $emp->full_name }}
                                    </h4>
                                    <form method="POST" action="{{ route('superadmin.employee.update', $emp->id) }}" class="edit-form">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-group">
                                            <label>Full Name</label>
                                            <input type="text" name="full_name" value="{{ $emp->full_name }}" class="form-control" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Employee ID</label>
                                            <input type="text" name="employee_id" value="{{ $emp->employee_id }}" class="form-control" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" value="{{ $emp->email }}" class="form-control" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input type="text" name="phone" value="{{ $emp->phone }}" class="form-control" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Department</label>
                                            <input type="text" name="department" value="{{ $emp->department }}" class="form-control" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Job Title</label>
                                            <input type="text" name="job_title" value="{{ $emp->job_title }}" class="form-control" required>
                                        </div>

                                        <div class="form-actions">
                                            <button type="submit" class="btn-save">
                                                <i class="fas fa-save me-2"></i>Save Changes
                                            </button>
                                            <button type="button" class="btn-cancel btn-cancel-edit" data-id="{{ $emp->id }}">
                                                <i class="fas fa-times me-2"></i>Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="pagination-container">
        {{ $employees->links() }}
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.btn-edit-row').click(function() {
            var id = $(this).data('id');
            $('tr[id^="edit-form-row-"]').hide();
            $('#edit-form-row-' + id).show();
            $('html, body').animate({
                scrollTop: $('#edit-form-row-' + id).offset().top - 100
            }, 500);
        });

        $('.btn-cancel-edit').click(function() {
            var id = $(this).data('id');
            $('#edit-form-row-' + id).hide();
        });
    });
</script>

@endsection