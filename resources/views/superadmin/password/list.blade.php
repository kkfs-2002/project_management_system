@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    Mobile Header
    <div class="d-md-none mb-4">
        <div class="d-flex align-items-center mb-3">
            <div class="bg-primary rounded-circle p-2 me-2">
                <i class="fas fa-user-shield text-white fs-5"></i>
            </div>
            <div>
                <h4 class="fw-bold mb-0">Password Reset</h4>
                <p class="text-muted small mb-0">{{ count($employees) }} employees</p>
            </div>
            <div class="ms-auto">
                <button class="btn btn-sm btn-outline-secondary" id="mobileSearchBtn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Search Bar (Hidden by default) -->
        <div class="d-none mb-3" id="mobileSearchContainer">
            <div class="input-group">
                <input type="text" class="form-control form-control-sm" 
                       placeholder="Search employees..." id="mobileSearch">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="closeMobileSearch">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Desktop Header -->
    <div class="d-none d-md-block mb-4" style="margin-top: 90px;">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-gradient rounded-circle p-3 me-3">
                        <i class="fas fa-user-shield text-white fs-4"></i>
                    </div>
                    <div>
                        <h1 class="h3 fw-bold mb-1">Employee Password Management</h1>
                        <p class="text-muted mb-0">
                            Reset passwords for employees in the system.
                        </p>
                    </div>
                    <div class="ms-auto">
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                            <i class="fas fa-users me-1"></i> {{ count($employees) }} Employees
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards - Responsive Grid -->
    <div class="row row-cols-2 row-cols-md-4 g-2 g-md-3 mb-3 mb-md-4">
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 rounded-circle p-2 me-2">
                            <i class="fas fa-user-tie text-info fs-6"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-muted small d-none d-md-block">Managers</div>
                            <div class="text-muted small d-md-none">Mgrs</div>
                            <h5 class="fw-bold mb-0">{{ $employees->where('role', 'manager')->count() }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded-circle p-2 me-2">
                            <i class="fas fa-user-cog text-success fs-6"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-muted small d-none d-md-block">Staff</div>
                            <div class="text-muted small d-md-none">Staff</div>
                            <h5 class="fw-bold mb-0">{{ $employees->where('role', 'staff')->count() }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-2">
                            <i class="fas fa-user-check text-warning fs-6"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-muted small d-none d-md-block">Active</div>
                            <div class="text-muted small d-md-none">Active</div>
                            <h5 class="fw-bold mb-0">{{ count($employees) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-purple bg-opacity-10 rounded-circle p-2 me-2">
                            <i class="fas fa-key text-purple fs-6"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-muted small d-none d-md-block">Reset Ready</div>
                            <div class="text-muted small d-md-none">Ready</div>
                            <h5 class="fw-bold mb-0">{{ count($employees) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card shadow-lg border-0">
        <!-- Card Header -->
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                <div>
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-list me-2 text-primary"></i>
                        <span class="d-none d-md-inline">Employee List</span>
                        <span class="d-md-none">Employees</span>
                    </h5>
                    <p class="text-muted mb-0 small d-none d-md-block">
                        Select an employee to reset their password
                    </p>
                </div>
                
                <!-- Desktop Controls -->
                <div class="d-none d-md-flex gap-2 align-items-center">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" 
                               id="searchEmployee" placeholder="Search employees...">
                    </div>
                    <button class="btn btn-sm btn-outline-secondary" id="filterBtn">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                </div>
                
                <!-- Mobile Controls -->
                <div class="d-flex d-md-none gap-2 w-100">
                    <div class="input-group input-group-sm flex-grow-1">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" 
                               placeholder="Search..." id="mobileSearchInput">
                    </div>
                    <button class="btn btn-sm btn-outline-secondary" id="mobileFilterBtn">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Table View for Desktop/Tablet -->
        <div class="card-body p-0 d-none d-md-block">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </div>
                            </th>
                            <th class="py-3">Employee</th>
                            <th class="py-3 d-none d-lg-table-cell">Role</th>
                            <th class="py-3 d-none d-xl-table-cell">Department</th>
                            <th class="py-3 d-none d-lg-table-cell">Last Updated</th>
                            <th class="py-3 text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody id="employeeTable">
                        @forelse ($employees as $emp)
                        <tr class="employee-row">
                            <td class="ps-4">
                                <div class="form-check">
                                    <input class="form-check-input employee-check" type="checkbox">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-40px me-3 d-none d-sm-flex">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px;">
                                            <span class="fw-bold fs-6">
                                                {{ strtoupper(substr($emp->full_name, 0, 1)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0">{{ $emp->full_name }}</h6>
                                        <small class="text-muted d-block">
                                            <i class="fas fa-user-tag me-1"></i> {{ ucfirst($emp->role) }}
                                        </small>
                                        <small class="text-muted d-block d-sm-none">
                                            <i class="fas fa-envelope me-1"></i> {{ substr($emp->email ?? 'N/A', 0, 15) }}...
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td class="d-none d-lg-table-cell">
                                @php
                                    $roleColors = [
                                        'manager' => 'primary',
                                        'admin' => 'danger',
                                        'superadmin' => 'purple',
                                        'staff' => 'success',
                                        'employee' => 'info'
                                    ];
                                    $color = $roleColors[strtolower($emp->role)] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }} px-3 py-1">
                                    {{ ucfirst($emp->role) }}
                                </span>
                            </td>
                            <td class="d-none d-xl-table-cell">
                                <span class="text-muted small">Not Specified</span>
                            </td>
                            <td class="d-none d-lg-table-cell">
                                <small class="text-muted">
                                    Recently
                                </small>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('superadmin.password.editOther', $emp->id) }}"
                                   class="btn btn-sm btn-warning btn-hover-shadow px-3">
                                   <i class="fas fa-key me-1 d-none d-sm-inline"></i>
                                   <span class="d-sm-none">Reset</span>
                                   <span class="d-none d-sm-inline">Reset Password</span>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-users fs-1 mb-3"></i>
                                    <h5 class="fw-bold">No Employees Found</h5>
                                    <p class="mb-0">There are no employees to display.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="card-body p-2 p-md-3 d-block d-md-none" id="mobileEmployeeList">
            @forelse ($employees as $emp)
            <div class="card border mb-2 employee-mobile-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-start">
                        <!-- Avatar -->
                        <div class="me-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 45px; height: 45px;">
                                <span class="fw-bold text-primary fs-5">
                                    {{ strtoupper(substr($emp->full_name, 0, 1)) }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Employee Info -->
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <div>
                                    <h6 class="fw-bold mb-0">{{ $emp->full_name }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-envelope me-1"></i> {{ $emp->email ?? 'N/A' }}
                                    </small>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input employee-check-mobile" type="checkbox">
                                </div>
                            </div>
                            
                            <!-- Role Badge -->
                            @php
                                $roleColors = [
                                    'manager' => 'primary',
                                    'admin' => 'danger',
                                    'superadmin' => 'purple',
                                    'staff' => 'success',
                                    'employee' => 'info'
                                ];
                                $color = $roleColors[strtolower($emp->role)] ?? 'secondary';
                            @endphp
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }}">
                                    <i class="fas fa-user-tag me-1"></i> {{ ucfirst($emp->role) }}
                                </span>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i> Recent
                                </small>
                            </div>
                            
                            <!-- Action Button -->
                            <div class="mt-3">
                                <a href="{{ route('superadmin.password.editOther', $emp->id) }}"
                                   class="btn btn-warning w-100 btn-sm">
                                    <i class="fas fa-key me-1"></i> Reset Password
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <div class="text-muted">
                    <i class="fas fa-users fs-1 mb-3"></i>
                    <h5 class="fw-bold">No Employees</h5>
                    <p class="mb-0">No employees found in the system.</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Card Footer -->
        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <div class="mb-2 mb-md-0">
                    <span class="text-muted small" id="selectedCount">0 selected</span>
                </div>
                
                <div class="d-flex gap-2 w-100 w-md-auto">
                    <!-- Mobile View Toggle -->
                    <button class="btn btn-sm btn-outline-secondary d-md-none flex-grow-1" id="mobileViewToggle">
                        <i class="fas fa-list me-1"></i> List
                    </button>
                    
                   
                  
            </div>
        </div>
    </div>

    <!-- Mobile Bottom Action Bar -->
    <div class="fixed-bottom bg-white border-top shadow-lg d-md-none py-2 px-3" id="mobileActionBar">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="fw-bold" id="mobileSelectedCount">0 selected</span>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-primary" id="mobileSelectAll">
                    Select All
                </button>
                <button class="btn btn-sm btn-danger" id="mobileBulkReset" disabled>
                    <i class="fas fa-key me-1"></i> Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Information Alert -->
    <div class="alert alert-info alert-dismissible fade show shadow-sm mt-4 border-0 d-none d-md-block" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle fs-4 me-3"></i>
            <div>
                <h6 class="alert-heading mb-1">Password Reset Guidelines</h6>
                <p class="mb-0">
                    When resetting passwords, ensure secure delivery of new credentials.
                </p>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <!-- Mobile Bottom Sheet for Filter -->
    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="mobileFilterSheet" style="height: 80vh;">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold">Filter Employees</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div class="mb-3">
                <label class="form-label fw-bold">Role</label>
                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-outline-primary btn-sm filter-role active" data-role="">All</button>
                    <button class="btn btn-outline-primary btn-sm filter-role" data-role="manager">Manager</button>
                    <button class="btn btn-outline-primary btn-sm filter-role" data-role="staff">Staff</button>
                    <button class="btn btn-outline-primary btn-sm filter-role" data-role="admin">Admin</button>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Status</label>
                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-outline-secondary btn-sm filter-status active" data-status="">All</button>
                    <button class="btn btn-outline-secondary btn-sm filter-status" data-status="active">Active</button>
                    <button class="btn btn-outline-secondary btn-sm filter-status" data-status="inactive">Inactive</button>
                </div>
            </div>
            
            <div class="mt-4">
                <button class="btn btn-primary w-100" id="applyMobileFilter">
                    Apply Filter
                </button>
                <button class="btn btn-outline-secondary w-100 mt-2" data-bs-dismiss="offcanvas">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Mobile Optimized Styles */
    @media (max-width: 768px) {
        .container-fluid {
            padding-left: 12px !important;
            padding-right: 12px !important;
            padding-bottom: 80px !important; /* Space for bottom action bar */
        }
        
        .card {
            border-radius: 12px !important;
        }
        
        .card-body {
            padding: 0.75rem !important;
        }
        
        .employee-mobile-card {
            border-radius: 10px !important;
            margin-bottom: 8px !important;
        }
        
        .btn-sm {
            padding: 0.375rem 0.75rem !important;
            font-size: 0.875rem !important;
        }
        
        .fixed-bottom {
            left: 0;
            right: 0;
            z-index: 1030;
            padding-bottom: env(safe-area-inset-bottom); /* Safe area for iOS */
        }
        
        /* Better touch targets */
        .btn, .form-check-input {
            min-height: 44px !important;
            min-width: 44px !important;
        }
        
        .form-check-input {
            width: 20px !important;
            height: 20px !important;
        }
        
        /* Optimize table for mobile */
        .table-responsive {
            font-size: 0.875rem;
        }
        
        /* Avatar sizing for mobile */
        .symbol {
            width: 40px !important;
            height: 40px !important;
        }
    }
    
    @media (max-width: 576px) {
        .row-cols-2 > * {
            padding-left: 4px !important;
            padding-right: 4px !important;
        }
        
        .card-body.p-3 {
            padding: 0.75rem !important;
        }
        
        h6.fw-bold {
            font-size: 0.95rem !important;
        }
        
        small {
            font-size: 0.75rem !important;
        }
        
        .badge {
            font-size: 0.7rem !important;
            padding: 0.25rem 0.5rem !important;
        }
    }
    
    /* Tablet Optimized Styles */
    @media (min-width: 768px) and (max-width: 1024px) {
        .container-fluid {
            padding-left: 20px !important;
            padding-right: 20px !important;
        }
        
        .d-xl-table-cell {
            display: table-cell !important;
        }
        
        .d-lg-table-cell {
            display: table-cell !important;
        }
        
        .btn {
            padding: 0.5rem 1rem !important;
        }
        
        .table td, .table th {
            padding: 0.75rem 0.5rem !important;
        }
    }
    
    /* Common Styles */
    .bg-purple {
        background-color: #8b5cf6 !important;
    }
    
    .text-purple {
        color: #8b5cf6 !important;
    }
    
    .employee-mobile-card {
        transition: all 0.2s ease;
    }
    
    .employee-mobile-card:active {
        transform: scale(0.98);
        background-color: rgba(0,0,0,0.02);
    }
    
    .form-check-input:checked {
        background-color: #4a6cf7;
        border-color: #4a6cf7;
    }
    
  /* Safe area for iPhone X and above */
@supports (padding: env(safe-area-inset-bottom)) {
    .fixed-bottom {
        padding-bottom: max(12px, env(safe-area-inset-bottom));
    }
}
    
    /* Better scroll on mobile */
    .offcanvas-body {
        -webkit-overflow-scrolling: touch;
    }
    
    /* Hide mobile action bar when empty */
    #mobileActionBar:empty {
        display: none !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile Search Toggle
    const mobileSearchBtn = document.getElementById('mobileSearchBtn');
    const mobileSearchContainer = document.getElementById('mobileSearchContainer');
    const closeMobileSearch = document.getElementById('closeMobileSearch');
    const mobileSearchInput = document.getElementById('mobileSearchInput');
    
    if (mobileSearchBtn) {
        mobileSearchBtn.addEventListener('click', function() {
            mobileSearchContainer.classList.toggle('d-none');
        });
    }
    
    if (closeMobileSearch) {
        closeMobileSearch.addEventListener('click', function() {
            mobileSearchContainer.classList.add('d-none');
        });
    }
    
    // Search functionality for both desktop and mobile
    const searchInputs = [document.getElementById('searchEmployee'), mobileSearchInput];
    const employeeRows = document.querySelectorAll('.employee-row');
    const mobileCards = document.querySelectorAll('.employee-mobile-card');
    
    searchInputs.forEach(input => {
        if (input) {
            input.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                
                // Search in table rows
                employeeRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
                
                // Search in mobile cards
                mobileCards.forEach(card => {
                    const text = card.textContent.toLowerCase();
                    card.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });
        }
    });
    
    // Mobile Filter Bottom Sheet
    const mobileFilterBtn = document.getElementById('mobileFilterBtn');
    if (mobileFilterBtn) {
        mobileFilterBtn.addEventListener('click', function() {
            const filterSheet = new bootstrap.Offcanvas(document.getElementById('mobileFilterSheet'));
            filterSheet.show();
        });
    }
    
    // Mobile filter buttons
    document.querySelectorAll('.filter-role, .filter-status').forEach(btn => {
        btn.addEventListener('click', function() {
            const parent = this.closest('.d-flex');
            parent.querySelectorAll('button').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
    
    // Apply mobile filter
    document.getElementById('applyMobileFilter').addEventListener('click', function() {
        const role = document.querySelector('.filter-role.active').dataset.role;
        const status = document.querySelector('.filter-status.active').dataset.status;
        
        // Filter logic here
        filterEmployees(role, status);
        
        // Close bottom sheet
        bootstrap.Offcanvas.getInstance(document.getElementById('mobileFilterSheet')).hide();
        
        // Show toast
        showMobileToast('Filter applied successfully');
    });
    
    // Selection functionality
    const desktopChecks = document.querySelectorAll('.employee-check');
    const mobileChecks = document.querySelectorAll('.employee-check-mobile');
    const selectAll = document.getElementById('selectAll');
    const mobileSelectAll = document.getElementById('mobileSelectAll');
    const selectedCount = document.getElementById('selectedCount');
    const mobileSelectedCount = document.getElementById('mobileSelectedCount');
    const bulkResetBtn = document.getElementById('bulkResetBtn');
    const mobileBulkReset = document.getElementById('mobileBulkReset');
    
    // Update selection count
    function updateSelection() {
        const allChecks = [...desktopChecks, ...mobileChecks];
        const checkedCount = allChecks.filter(check => check.checked).length;
        
        // Update counters
        selectedCount.textContent = `${checkedCount} selected`;
        mobileSelectedCount.textContent = `${checkedCount} selected`;
        
        // Enable/disable buttons
        bulkResetBtn.disabled = checkedCount === 0;
        mobileBulkReset.disabled = checkedCount === 0;
        
        // Show/hide mobile action bar
        const mobileActionBar = document.getElementById('mobileActionBar');
        if (checkedCount > 0) {
            mobileActionBar.classList.remove('d-none');
        } else {
            mobileActionBar.classList.add('d-none');
        }
    }
    
    // Desktop select all
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            const isChecked = this.checked;
            desktopChecks.forEach(check => check.checked = isChecked);
            mobileChecks.forEach(check => check.checked = isChecked);
            updateSelection();
        });
    }
    
    // Mobile select all
    if (mobileSelectAll) {
        mobileSelectAll.addEventListener('click', function() {
            const allChecked = Array.from(mobileChecks).every(check => check.checked);
            const newState = !allChecked;
            
            desktopChecks.forEach(check => check.checked = newState);
            mobileChecks.forEach(check => check.checked = newState);
            
            if (selectAll) selectAll.checked = newState;
            updateSelection();
        });
    }
    
    // Individual checkboxes
    [...desktopChecks, ...mobileChecks].forEach(check => {
        check.addEventListener('change', function() {
            updateSelection();
            
            // Sync between desktop and mobile
            if (this.classList.contains('employee-check')) {
                const index = Array.from(desktopChecks).indexOf(this);
                if (mobileChecks[index]) mobileChecks[index].checked = this.checked;
            } else {
                const index = Array.from(mobileChecks).indexOf(this);
                if (desktopChecks[index]) desktopChecks[index].checked = this.checked;
            }
        });
    });
    
    // Mobile view toggle
    const mobileViewToggle = document.getElementById('mobileViewToggle');
    if (mobileViewToggle) {
        let isGridView = false;
        mobileViewToggle.addEventListener('click', function() {
            isGridView = !isGridView;
            const cards = document.querySelectorAll('.employee-mobile-card');
            
            if (isGridView) {
                // Switch to grid view
                document.getElementById('mobileEmployeeList').classList.add('row', 'row-cols-2', 'g-2');
                cards.forEach(card => {
                    card.classList.add('h-100');
                    card.querySelector('.d-flex').classList.add('flex-column', 'text-center');
                    card.querySelector('.me-3').classList.add('mx-auto', 'mb-2');
                    card.querySelector('.flex-grow-1').classList.add('text-center');
                });
                this.innerHTML = '<i class="fas fa-th-large me-1"></i> Grid';
            } else {
                // Switch to list view
                document.getElementById('mobileEmployeeList').classList.remove('row', 'row-cols-2', 'g-2');
                cards.forEach(card => {
                    card.classList.remove('h-100');
                    card.querySelector('.d-flex').classList.remove('flex-column', 'text-center');
                    card.querySelector('.me-3').classList.remove('mx-auto', 'mb-2');
                    card.querySelector('.flex-grow-1').classList.remove('text-center');
                });
                this.innerHTML = '<i class="fas fa-list me-1"></i> List';
            }
        });
    }
    
    // Bulk reset functionality
    [bulkResetBtn, mobileBulkReset].forEach(btn => {
        if (btn) {
            btn.addEventListener('click', function() {
                const checkedCount = document.querySelectorAll('.employee-check:checked, .employee-check-mobile:checked').length;
                
                Swal.fire({
                    title: 'Reset Passwords',
                    html: `Reset passwords for <b>${checkedCount}</b> selected employee${checkedCount !== 1 ? 's' : ''}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Reset',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#f59e0b',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Processing...';
                        
                        setTimeout(() => {
                            showMobileToast(`Passwords reset for ${checkedCount} employees`);
                            this.innerHTML = this === mobileBulkReset ? 
                                '<i class="fas fa-key me-1"></i> Reset' : 
                                '<i class="fas fa-key me-1"></i> Bulk Reset';
                            
                            // Clear selections
                            desktopChecks.forEach(c => c.checked = false);
                            mobileChecks.forEach(c => c.checked = false);
                            if (selectAll) selectAll.checked = false;
                            updateSelection();
                        }, 1500);
                    }
                });
            });
        }
    });
    
    // Mobile toast notification
    function showMobileToast(message) {
        // Remove existing toasts
        const existingToasts = document.querySelectorAll('.mobile-toast');
        existingToasts.forEach(toast => toast.remove());
        
        // Create new toast
        const toast = document.createElement('div');
        toast.className = 'mobile-toast position-fixed bottom-0 start-50 translate-middle-x mb-4 bg-dark text-white rounded-pill px-4 py-2 shadow-lg';
        toast.style.zIndex = '9999';
        toast.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Animate in
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(-50%) translateY(20px)';
        
        setTimeout(() => {
            toast.style.transition = 'all 0.3s ease';
            toast.style.opacity = '1';
            toast.style.transform = 'translateX(-50%) translateY(0)';
        }, 10);
        
        // Remove after 3 seconds
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(-50%) translateY(20px)';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
    
    // Filter function
    function filterEmployees(role, status) {
        // This is a basic filter - you can expand it based on your data structure
        const rows = document.querySelectorAll('.employee-row, .employee-mobile-card');
        
        rows.forEach(row => {
            const roleText = row.textContent.toLowerCase();
            let show = true;
            
            if (role && !roleText.includes(role.toLowerCase())) {
                show = false;
            }
            
            // Add status filtering logic here if you have status data
            
            row.style.display = show ? '' : 'none';
        });
    }
    
    // Initialize with no selections
    updateSelection();
    
    // Handle orientation change
    window.addEventListener('orientationchange', function() {
        setTimeout(() => {
            // Recalculate any layout-dependent elements
            updateSelection();
        }, 300);
    });
});
</script>

<!-- Add Bootstrap Icons for better mobile performance -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Add touch-friendly CSS -->
<style>
    @media (hover: none) and (pointer: coarse) {
        /* Improve touch experience */
        .btn, a {
            cursor: pointer !important;
        }
        
        .employee-mobile-card {
            cursor: pointer !important;
        }
        
        /* Prevent zoom on input focus */
        input, select, textarea {
            font-size: 16px !important;
        }
        
        /* Better touch feedback */
        .btn:active, .employee-mobile-card:active {
            opacity: 0.7;
        }
    }
</style>
@endsection