@extends('layouts.app')

@section('title', 'Marketing Managers Attendance')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4" style="margin-top: 90px;">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Marketing Managers
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $marketingManagerProfiles->count() ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Present Today
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPresentToday ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Late Arrivals
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lateArrivals ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Early Leaves
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $earlyLeaves ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sign-out-alt fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow border-0">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="fas fa-bullhorn me-2 text-primary"></i>
                            Marketing Managers Attendance Records
                        </h5>
                        <div class="d-flex gap-2">
                            <!-- Export Button -->
                            <a href="{{ route('superadmin.attendance.export') }}?type=marketingmanager{{ request('date') ? '&date=' . request('date') : '' }}" 
                               class="btn btn-sm btn-success">
                                <i class="fas fa-file-export me-1"></i> Export
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Filters -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('attendance.marketingmanager') }}" class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold text-muted">Marketing Manager</label>
                                    <select name="profile_id" class="form-select form-select-sm">
                                        <option value="">All Marketing Managers</option>
                                        @foreach($marketingManagerProfiles as $mm)
                                            <option value="{{ $mm->id }}" {{ request('profile_id') == $mm->id ? 'selected' : '' }}>
                                                {{ $mm->full_name }} ({{ $mm->employee_id }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-2">
                                    <label class="form-label small fw-bold text-muted">Date</label>
                                    <input type="date" name="date" class="form-control form-control-sm" 
                                           value="{{ request('date', date('Y-m-d')) }}">
                                </div>
                                
                                <div class="col-md-2">
                                    <label class="form-label small fw-bold text-muted">Month</label>
                                    <select name="month" class="form-select form-select-sm">
                                        <option value="">All Months</option>
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                                {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                
                                <div class="col-md-2">
                                    <label class="form-label small fw-bold text-muted">Year</label>
                                    <select name="year" class="form-select form-select-sm">
                                        <option value="">All Years</option>
                                        @for($y = date('Y'); $y >= 2020; $y--)
                                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                                {{ $y }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                
                                <div class="col-md-3 d-flex align-items-end gap-2">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fas fa-filter me-1"></i> Apply Filters
                                    </button>
                                    
                                    <a href="{{ route('attendance.marketingmanager') }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-redo me-1"></i> Reset
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Attendance Table -->
                    @if($attendances->isEmpty())
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-clipboard-list fa-4x text-muted mb-4 opacity-25"></i>
                                <h4 class="text-muted mb-3">No Attendance Records</h4>
                                <p class="text-muted mb-4">No marketing managers have recorded attendance for the selected filters</p>
                                <a href="{{ route('attendance.marketingmanager') }}" class="btn btn-primary">
                                    <i class="fas fa-redo me-2"></i> Clear Filters
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="attendanceTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 text-uppercase text-secondary text-xs font-weight-bolder">
                                            #
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                            Marketing Manager
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                            Date
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                            Check In
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                            Check Out
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                            Hours
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                            Status
                                        </th>
                                        <th class="text-end pe-4 text-uppercase text-secondary text-xs font-weight-bolder">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="border-top-0">
                                    @foreach($attendances as $index => $attendance)
                                    @php
                                        $checkInHour = $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H') : null;
                                        $checkOutHour = $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H') : null;
                                        $isLate = $checkInHour && $checkInHour >= 9;
                                        $isEarly = $checkOutHour && $checkOutHour < 17;
                                    @endphp
                                    <tr class="border-bottom">
                                        <td class="ps-4">
                                            <span class="text-sm fw-semibold">
                                                {{ ($attendances->currentPage() - 1) * $attendances->perPage() + $index + 1 }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <div class="avatar-wrapper">
                                                        <img src="{{ $attendance->profile->profile_picture ?? asset('assets/img/default-avatar.png') }}" 
                                                             class="avatar rounded-circle" 
                                                             alt="{{ $attendance->profile->full_name ?? 'N/A' }}">
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 text-sm fw-semibold">{{ $attendance->profile->full_name ?? 'N/A' }}</h6>
                                                    <p class="text-xs text-muted mb-0">
                                                        <i class="fas fa-id-card me-1"></i>
                                                        {{ $attendance->profile->employee_id ?? 'N/A' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-sm">
                                                <div class="fw-semibold">{{ $attendance->date->format('d M Y') }}</div>
                                                <div class="text-muted">{{ $attendance->date->format('l') }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($attendance->check_in)
                                                <div class="text-sm">
                                                    <div class="fw-semibold {{ $isLate ? 'text-warning' : 'text-success' }}">
                                                        <i class="fas fa-sign-in-alt me-1"></i>
                                                        {{ \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') }}
                                                    </div>
                                                    <div class="text-xs">
                                                        @if($isLate)
                                                            <span class="badge bg-warning-light text-warning">Late</span>
                                                        @else
                                                            <span class="badge bg-success-light text-success">On Time</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <span class="badge bg-warning-light text-warning">
                                                    <i class="fas fa-times me-1"></i> Not Checked In
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($attendance->check_out)
                                                <div class="text-sm">
                                                    <div class="fw-semibold {{ $isEarly ? 'text-info' : 'text-success' }}">
                                                        <i class="fas fa-sign-out-alt me-1"></i>
                                                        {{ \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') }}
                                                    </div>
                                                    <div class="text-xs">
                                                        @if($isEarly)
                                                            <span class="badge bg-info-light text-info">Early Leave</span>
                                                        @else
                                                            <span class="badge bg-success-light text-success">Full Day</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                @if($attendance->check_in)
                                                    <span class="badge bg-info-light text-info">
                                                        <i class="fas fa-clock me-1"></i> Still Working
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary-light text-secondary">
                                                        <i class="fas fa-user-slash me-1"></i> Not Checked In
                                                    </span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if($attendance->total_hours)
                                                <div class="text-center">
                                                    <span class="fw-bold text-dark">{{ number_format($attendance->total_hours, 2) }}</span>
                                                    <div class="text-xs text-muted">hours</div>
                                                </div>
                                            @elseif($attendance->check_in && !$attendance->check_out)
                                                <span class="badge bg-warning-light text-warning">
                                                    <i class="fas fa-clock me-1"></i> In Progress
                                                </span>
                                            @else
                                                <span class="text-muted fst-italic">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($attendance->check_in && $attendance->check_out)
                                                <span class="badge bg-success text-white">
                                                    <i class="fas fa-check-circle me-1"></i> Completed
                                                </span>
                                            @elseif($attendance->check_in && !$attendance->check_out)
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-clock me-1"></i> On Duty
                                                </span>
                                            @else
                                                <span class="badge bg-danger text-white">
                                                    <i class="fas fa-user-slash me-1"></i> Absent
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-primary rounded-start"
                                                        onclick="viewAttendanceDetails({{ $attendance->id }})"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                @if($attendance->check_in && !$attendance->check_out)
                                                    <button type="button" class="btn btn-sm btn-outline-warning"
                                                            onclick="markAsCheckedOut({{ $attendance->id }})"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Mark Check Out">
                                                        <i class="fas fa-sign-out-alt"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        @if($attendances->hasPages())
                        <div class="card-footer bg-white border-top py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-sm text-muted">
                                    Showing <span class="fw-semibold">{{ $attendances->firstItem() }}</span> to 
                                    <span class="fw-semibold">{{ $attendances->lastItem() }}</span> of 
                                    <span class="fw-semibold">{{ $attendances->total() }}</span> records
                                </div>
                                <div>
                                    {{ $attendances->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Average Hours Card -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Average Working Hours Today
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $averageHours ?? '0.00' }} hours</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-line fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Attendance Details -->
<div class="modal fade" id="attendanceDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-clipboard-check me-2"></i>
                    Attendance Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="attendanceDetailsContent">
                <!-- Details will be loaded here via AJAX -->
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function viewAttendanceDetails(id) {
    const modalContent = document.getElementById('attendanceDetailsContent');
    modalContent.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>`;
    
    fetch(`/superadmin/attendance/${id}/details`)
        .then(response => response.json())
        .then(data => {
            const modalContent = `
                <div class="row">
                    <div class="col-md-4 text-center mb-4">
                        <div class="avatar-lg mb-3">
                            <img src="${data.profile_picture || '{{ asset("assets/img/default-avatar.png") }}'}" 
                                 class="rounded-circle img-thumbnail" 
                                 style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <h5 class="mb-1">${data.full_name}</h5>
                        <p class="text-muted mb-0">
                            <i class="fas fa-id-card me-1"></i>${data.employee_id}
                        </p>
                        <p class="text-muted mb-3">
                            <i class="fas fa-bullhorn me-1"></i>Marketing Manager
                        </p>
                    </div>
                    <div class="col-md-8">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">
                                            <i class="fas fa-calendar-day me-2"></i>
                                            Attendance Information
                                        </h6>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted mb-1">Date</label>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-calendar text-primary me-2"></i>
                                            <span class="fw-semibold">${data.date_formatted}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted mb-1">Day</label>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-clock text-primary me-2"></i>
                                            <span class="fw-semibold">${data.day}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted mb-1">Check In Time</label>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-sign-in-alt ${data.check_in_status === 'Late' ? 'text-warning' : 'text-success'} me-2"></i>
                                            <div>
                                                <div class="fw-semibold">${data.check_in_time}</div>
                                                ${data.check_in_status ? `<div class="text-xs"><span class="badge ${data.check_in_status === 'Late' ? 'bg-warning' : 'bg-success'}">${data.check_in_status}</span></div>` : ''}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted mb-1">Check Out Time</label>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-sign-out-alt ${data.check_out_status === 'Early Leave' ? 'text-info' : 'text-success'} me-2"></i>
                                            <div>
                                                <div class="fw-semibold">${data.check_out_time}</div>
                                                ${data.check_out_status ? `<div class="text-xs"><span class="badge ${data.check_out_status === 'Early Leave' ? 'bg-info' : 'bg-success'}">${data.check_out_status}</span></div>` : ''}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="border-top pt-3 mt-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <label class="form-label text-muted mb-1">Total Working Hours</label>
                                                    <h4 class="text-primary mb-0">${data.total_hours}</h4>
                                                </div>
                                                <div class="text-end">
                                                    <label class="form-label text-muted mb-1">Attendance Status</label>
                                                    <div>
                                                        <span class="badge ${data.overall_status === 'Completed' ? 'bg-success' : data.overall_status === 'Checked In' ? 'bg-warning' : 'bg-secondary'} fs-6">
                                                            ${data.overall_status}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
            document.getElementById('attendanceDetailsContent').innerHTML = modalContent;
            const modal = new bootstrap.Modal(document.getElementById('attendanceDetailsModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('attendanceDetailsContent').innerHTML = `
                <div class="text-center py-4">
                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                    <h5 class="text-danger">Error Loading Details</h5>
                    <p class="text-muted">Please try again later</p>
                </div>`;
        });
}

function markAsCheckedOut(id) {
    if(confirm('Are you sure you want to mark check out for this marketing manager?')) {
        fetch(`/superadmin/attendance/${id}/checkout`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert('Check out marked successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    }
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Auto refresh every 5 minutes
    setInterval(() => {
        if (!document.getElementById('attendanceDetailsModal').classList.contains('show')) {
            location.reload();
        }
    }, 300000);
});
function viewAttendanceDetails(id) {
    console.log('Loading attendance details for ID:', id);
    
    const modalContent = document.getElementById('attendanceDetailsContent');
    modalContent.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3 text-muted">Loading attendance details...</p>
        </div>`;
    
    // Show modal first
    const modal = new bootstrap.Modal(document.getElementById('attendanceDetailsModal'));
    modal.show();
    
    // Fetch data
    fetch(`/superadmin/attendance/${id}/details`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(result => {
            console.log('API Response:', result);
            
            if (!result.success) {
                throw new Error(result.message || 'Failed to load details');
            }
            
            const data = result.data;
            
            const modalContentHTML = `
                <div class="attendance-details">
                    <!-- Header -->
                    <div class="bg-light p-4 border-bottom">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="avatar-lg">
                                    <img src="${data.profile_picture}" 
                                         class="rounded-circle border border-3 border-primary" 
                                         style="width: 80px; height: 80px; object-fit: cover;">
                                </div>
                            </div>
                            <div class="col">
                                <h4 class="mb-1">${data.full_name}</h4>
                                <p class="text-muted mb-1">
                                    <i class="fas fa-id-card me-1"></i>${data.employee_id}
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-briefcase me-1"></i>${data.role}
                                </p>
                            </div>
                            <div class="col-auto">
                                <span class="badge bg-${data.overall_status === 'Completed' ? 'success' : data.overall_status === 'Checked In' ? 'warning' : 'danger'} fs-6 p-2">
                                    ${data.overall_status}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Date Info -->
                    <div class="p-4 border-bottom">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-calendar me-2"></i>Date
                                </h6>
                                <h4 class="mb-0">${data.date_formatted}</h4>
                                <p class="text-muted mb-0">${data.day}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-clock me-2"></i>Working Hours
                                </h6>
                                <h4 class="mb-0 text-primary">${data.total_hours}</h4>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Time Details -->
                    <div class="p-4">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <h6 class="text-muted mb-3">
                                            <i class="fas fa-sign-in-alt me-2"></i>Check In
                                        </h6>
                                        <div class="display-4 fw-bold ${data.check_in_status === 'Late' ? 'text-warning' : 'text-success'} mb-2">
                                            ${data.check_in_time}
                                        </div>
                                        ${data.check_in_full ? `<p class="text-muted small">${data.check_in_full}</p>` : ''}
                                        
                                        ${data.check_in_status ? `
                                            <div class="mt-3">
                                                <span class="badge bg-${data.check_in_status === 'Late' ? 'warning' : 'success'}">
                                                    <i class="fas fa-${data.check_in_status === 'Late' ? 'exclamation-triangle' : 'check-circle'} me-1"></i>
                                                    ${data.check_in_status}
                                                </span>
                                            </div>
                                        ` : `
                                            <div class="mt-3">
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times-circle me-1"></i>
                                                    Not Checked In
                                                </span>
                                            </div>
                                        `}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <h6 class="text-muted mb-3">
                                            <i class="fas fa-sign-out-alt me-2"></i>Check Out
                                        </h6>
                                        <div class="display-4 fw-bold ${data.check_out_status === 'Early Leave' ? 'text-warning' : 'text-success'} mb-2">
                                            ${data.check_out_time}
                                        </div>
                                        ${data.check_out_full ? `<p class="text-muted small">${data.check_out_full}</p>` : ''}
                                        
                                        ${data.check_out_status ? `
                                            <div class="mt-3">
                                                <span class="badge bg-${data.check_out_status === 'Early Leave' ? 'warning' : 'success'}">
                                                    <i class="fas fa-${data.check_out_status === 'Early Leave' ? 'exclamation-triangle' : 'check-circle'} me-1"></i>
                                                    ${data.check_out_status}
                                                </span>
                                            </div>
                                        ` : `
                                            <div class="mt-3">
                                                <span class="badge bg-${data.check_in_time !== 'Not Checked In' ? 'warning' : 'danger'}">
                                                    <i class="fas fa-${data.check_in_time !== 'Not Checked In' ? 'clock' : 'user-slash'} me-1"></i>
                                                    ${data.check_in_time !== 'Not Checked In' ? 'Still Working' : 'Not Checked In'}
                                                </span>
                                            </div>
                                        `}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Summary -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="alert ${data.overall_status === 'Completed' ? 'alert-success' : data.overall_status === 'Checked In' ? 'alert-warning' : 'alert-danger'}">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-${data.overall_status === 'Completed' ? 'check-circle' : data.overall_status === 'Checked In' ? 'clock' : 'exclamation-triangle'} fa-2x"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="alert-heading">${data.overall_status}</h5>
                                            <p class="mb-0">
                                                ${data.full_name} ${data.overall_status === 'Completed' ? 
                                                    'has completed their working day.' : 
                                                    data.overall_status === 'Checked In' ? 
                                                    'is currently working.' : 
                                                    'was absent today.'}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Footer -->
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i> Close
                        </button>
                        <button type="button" class="btn btn-primary" onclick="printAttendanceDetails(${data.attendance_id})">
                            <i class="fas fa-print me-2"></i> Print
                        </button>
                    </div>
                </div>`;
            
            document.getElementById('attendanceDetailsContent').innerHTML = modalContentHTML;
            
        })
        .catch(error => {
            console.error('Error loading attendance details:', error);
            document.getElementById('attendanceDetailsContent').innerHTML = `
                <div class="text-center py-5">
                    <div class="alert alert-danger mx-4">
                        <i class="fas fa-exclamation-triangle fa-2x mb-3 text-danger"></i>
                        <h5 class="alert-heading">Error Loading Details</h5>
                        <p class="mb-3">${error.message || 'Please try again later'}</p>
                        <button type="button" class="btn btn-primary" onclick="viewAttendanceDetails(${id})">
                            <i class="fas fa-redo me-2"></i> Retry
                        </button>
                        <button type="button" class="btn btn-secondary ms-2" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i> Close
                        </button>
                    </div>
                </div>`;
        });
}

function printAttendanceDetails(id) {
    // Simple print functionality
    const printContent = document.getElementById('attendanceDetailsContent').innerHTML;
    const originalContent = document.body.innerHTML;
    
    document.body.innerHTML = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Attendance Details</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                @media print {
                    body { padding: 20px; }
                    .no-print { display: none !important; }
                }
                .print-header {
                    border-bottom: 2px solid #333;
                    margin-bottom: 20px;
                    padding-bottom: 10px;
                }
                .print-footer {
                    border-top: 1px solid #ccc;
                    margin-top: 30px;
                    padding-top: 10px;
                    font-size: 12px;
                    color: #666;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="print-header">
                    <h3>Attendance Details</h3>
                    <p class="text-muted">Printed on ${new Date().toLocaleDateString()} at ${new Date().toLocaleTimeString()}</p>
                </div>
                ${printContent}
                <div class="print-footer text-center">
                    © ${new Date().getFullYear()} - Attendance Management System
                </div>
            </div>
        </body>
        </html>
    `;
    
    window.print();
    document.body.innerHTML = originalContent;
    location.reload(); // Reload to restore original state
}

// Initialize Bootstrap tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection

@section('styles')
<style>
/* Custom Styles for Professional UI */
:root {
    --primary: #4e73df;
    --success: #1cc88a;
    --warning: #f6c23e;
    --danger: #e74a3b;
    --info: #36b9cc;
    --light: #f8f9fc;
    --dark: #5a5c69;
}

.container-fluid {
    padding: 1.5rem;
}

/* Card Styling */
.card {
    border: none;
    border-radius: 0.5rem;
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-2px);
}

.card.shadow {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}

/* Stat Cards */
.stat-card {
    border-left: 0.25rem solid !important;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.border-left-primary { border-color: var(--primary) !important; }
.border-left-success { border-color: var(--success) !important; }
.border-left-warning { border-color: var(--warning) !important; }
.border-left-danger { border-color: var(--danger) !important; }
.border-left-info { border-color: var(--info) !important; }

/* Avatar Styling */
.avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.avatar-lg {
    width: 150px;
    height: 150px;
}

.avatar-wrapper {
    position: relative;
}

.avatar-wrapper::after {
    content: '';
    position: absolute;
    bottom: 0;
    right: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: var(--success);
    border: 2px solid #fff;
}

/* Table Styling */
.table {
    margin-bottom: 0;
}

.table thead th {
    border-bottom: 2px solid #e3e6f0;
    text-transform: uppercase;
    font-size: 0.75rem;
    font-weight: 800;
    letter-spacing: 0.5px;
    color: var(--dark);
    padding: 1rem 1.25rem;
    background-color: var(--light);
}

.table tbody td {
    padding: 1.25rem;
    vertical-align: middle;
    border-bottom: 1px solid #e3e6f0;
    font-size: 0.875rem;
}

.table tbody tr:last-child td {
    border-bottom: none;
}

.table-hover tbody tr:hover {
    background-color: rgba(78, 115, 223, 0.05);
}

/* Badge Styling */
.badge {
    padding: 0.35em 0.65em;
    font-weight: 600;
    border-radius: 0.375rem;
}

.bg-success-light {
    background-color: rgba(28, 200, 138, 0.1) !important;
    color: var(--success) !important;
}

.bg-warning-light {
    background-color: rgba(246, 194, 62, 0.1) !important;
    color: #856404 !important;
}

.bg-danger-light {
    background-color: rgba(231, 74, 59, 0.1) !important;
    color: var(--danger) !important;
}

.bg-info-light {
    background-color: rgba(54, 185, 204, 0.1) !important;
    color: var(--info) !important;
}

.bg-secondary-light {
    background-color: rgba(108, 117, 125, 0.1) !important;
    color: #6c757d !important;
}

/* Button Styling */
.btn-outline-primary {
    border-width: 1px;
}

.btn-sm.rounded-circle {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-group .btn {
    border-radius: 0.375rem !important;
}

.btn-group .btn:first-child {
    border-top-right-radius: 0 !important;
    border-bottom-right-radius: 0 !important;
}

.btn-group .btn:last-child {
    border-top-left-radius: 0 !important;
    border-bottom-left-radius: 0 !important;
}

/* Form Control Styling */
.form-control, .form-select {
    border: 1px solid #d1d3e2;
    border-radius: 0.375rem;
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

.form-control:focus, .form-select:focus {
    border-color: #bac8f3;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

/* Modal Styling */
.modal-content {
    border-radius: 0.5rem;
    border: none;
}

.modal-header {
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
    padding: 1.25rem 1.5rem;
}

.modal-body {
    padding: 1.5rem;
}

/* Empty State Styling */
.empty-state {
    padding: 3rem 1rem;
}

.empty-state i {
    opacity: 0.5;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem;
    }
    
    .card-header .d-flex {
        flex-direction: column;
        gap: 1rem;
    }
    
    .table-responsive {
        border: 1px solid #e3e6f0;
        border-radius: 0.375rem;
    }
    
    .avatar {
        width: 36px;
        height: 36px;
    }
    
    .row.g-3 > div {
        margin-bottom: 1rem;
    }
}
</style>
@endsection