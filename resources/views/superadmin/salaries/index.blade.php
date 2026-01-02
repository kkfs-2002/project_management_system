@extends('layouts.app')

@section('title', 'Employee Salaries')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Page Header with Stats -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
     <div class="mb-0 mb-md-0" style="margin-top: 90px;">

            <nav aria-label="breadcrumb" class="d-none d-md-block">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}" class="text-muted text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Salary Management</li>
                </ol>
            </nav>
            <div class="d-flex align-items-center">
                <div class="icon-wrapper bg-gradient-primary rounded-3 p-3 me-3">
                    <i class="fas fa-money-bill-wave fa-lg text-white"></i>
                </div>
                <div>
                    <h1 class="h3 fw-bold mb-1">Salary Records</h1>
                    <p class="text-muted mb-0">Total Paid: <span class="fw-semibold text-primary">Rs {{ number_format($total, 2) }}</span></p>
                </div>
            </div>
        </div>
      <div class="d-flex flex-wrap gap-2" style="margin-top: 20px;">

            <button type="button" class="btn btn-outline-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="fas fa-filter me-2"></i>Advanced Filter
            </button>
            <a href="{{ route('superadmin.salary.create') }}" class="btn btn-primary d-flex align-items-center">
                <i class="fas fa-plus-circle me-2"></i>Add Salary
            </a>
            @if(request('month'))
            <a href="{{ route('superadmin.salary.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
                <i class="fas fa-times me-2"></i>Clear Filter
            </a>
            @endif
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-stats border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase text-muted mb-2">Total Records</h6>
                            <h2 class="mb-0">{{ $salaries->count() }}</h2>
                        </div>
                        <div class="icon-shape bg-primary text-white rounded-circle p-3">
                            <i class="fas fa-list fa-lg"></i>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span class="text-success me-1"><i class="fas fa-calendar-alt me-1"></i>{{ request('month') ? date('F Y', strtotime(request('month'))) : 'All Time' }}</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-stats border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase text-muted mb-2">Total Amount</h6>
                            <h2 class="mb-0">Rs {{ number_format($total, 2) }}</h2>
                        </div>
                        <div class="icon-shape bg-success text-white rounded-circle p-3">
                            <i class="fas fa-coins fa-lg"></i>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span class="text-muted">Total salary disbursed</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-stats border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase text-muted mb-2">Paid</h6>
                            <h2 class="mb-0">{{ $salaries->where('status', 'paid')->count() }}</h2>
                        </div>
                        <div class="icon-shape bg-info text-white rounded-circle p-3">
                            <i class="fas fa-check-circle fa-lg"></i>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span class="text-success me-1"><i class="fas fa-arrow-up me-1"></i>Completed</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-stats border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase text-muted mb-2">Pending</h6>
                            <h2 class="mb-0">{{ $salaries->where('status', 'pending')->count() }}</h2>
                        </div>
                        <div class="icon-shape bg-warning text-white rounded-circle p-3">
                            <i class="fas fa-clock fa-lg"></i>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span class="text-warning me-1"><i class="fas fa-exclamation-circle me-1"></i>Awaiting</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="fas fa-check-circle me-3 fa-lg"></i>
            <div class="flex-grow-1">{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Content Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-bottom">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0 fw-semibold"><i class="fas fa-table me-2 text-primary"></i>Salary Records</h5>
                </div>
                <div class="col-md-6">
                    <form method="GET" action="{{ route('superadmin.salary.index') }}" class="d-flex">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-calendar-alt text-muted"></i></span>
                            <input type="month" 
                                   name="month" 
                                   value="{{ request('month') }}" 
                                   class="form-control border-start-0"
                                   onchange="this.form.submit()">
                            @if(request('month'))
                            <button type="button" class="btn btn-outline-secondary" onclick="window.location.href='{{ route('superadmin.salary.index') }}'">
                                <i class="fas fa-times"></i>
                            </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3 border-bottom-0">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </div>
                            </th>
                            <th class="py-3 border-bottom-0">EMPLOYEE</th>
                            <th class="py-3 border-bottom-0">AMOUNT</th>
                            <th class="py-3 border-bottom-0">DATE & TIME</th>
                            <th class="py-3 border-bottom-0">STATUS</th>
                            <th class="py-3 border-bottom-0 text-end pe-4">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($salaries as $salary)
                        <tr class="border-bottom">
                            <td class="ps-4">
                                <div class="form-check">
                                    <input class="form-check-input row-checkbox" type="checkbox" value="{{ $salary->id }}">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-md bg-gradient-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                        {{ substr($salary->profile->full_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">{{ $salary->profile->full_name }}</h6>
                                        <small class="text-muted">{{ $salary->profile->designation ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark">Rs {{ number_format($salary->amount, 2) }}</span>
                                    <small class="text-muted">{{ $salary->payment_method ?? 'Not specified' }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-medium">{{ \Carbon\Carbon::parse($salary->salary_month)->format('d M Y') }}</span>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($salary->salary_month)->format('h:i A') }}</small>
                                </div>
                            </td>
                            <td>
                                @if($salary->status == 'paid')
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i> Paid
                                    </span>
                                @elseif($salary->status == 'pending')
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-3 py-2">
                                        <i class="fas fa-clock me-1"></i> Pending
                                    </span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-3 py-2">
                                        {{ $salary->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
            <!-- Use the correct route name -->
            <li>
                <a class="dropdown-item" href="{{ route('superadmin.salary.show', $salary->id) }}">
                    <i class="fas fa-eye me-2"></i>View Details
                </a>
                <a class="dropdown-item" href="{{ route('superadmin.salary.edit', $salary->id) }}" class="btn btn-primary d-flex align-items-center">
    <i class="fas fa-edit me-2"></i>Edit
</a>
      
            </li>    
           
     </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-state-icon bg-light-primary rounded-circle p-4 mb-3">
                                        <i class="fas fa-money-bill-wave fa-3x text-primary"></i>
                                    </div>
                                    <h4 class="mb-3">No Salary Records Found</h4>
                                    <p class="text-muted mb-4">No salary records found for the selected period.</p>
                                    <a href="{{ route('superadmin.salary.create') }}" class="btn btn-primary px-4">
                                        <i class="fas fa-plus-circle me-2"></i>Add New Salary
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-white border-top py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                   
                </div>
                <div class="col-md-6">
                    @if($salaries instanceof \Illuminate\Pagination\LengthAwarePaginator && $salaries->total() > $salaries->perPage())
                    <nav aria-label="Page navigation" class="float-md-end">
                        {{ $salaries->links('vendor.pagination.bootstrap-5') }}
                    </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel"><i class="fas fa-filter me-2"></i>Advanced Filters</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="GET" action="{{ route('superadmin.salary.index') }}">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Date Range</label>
                            <input type="month" name="month" class="form-control" value="{{ request('month') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="">All Status</option>
                                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Min Amount</label>
                            <input type="number" name="min_amount" class="form-control" placeholder="0.00" value="{{ request('min_amount') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Max Amount</label>
                            <input type="number" name="max_amount" class="form-control" placeholder="100000.00" value="{{ request('max_amount') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .container-fluid {
        padding-left: 24px;
        padding-right: 24px;
    }
    
    .icon-wrapper {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }
    
    .card-stats .icon-shape {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .avatar-md {
        width: 48px;
        height: 48px;
        font-weight: 600;
        font-size: 18px;
    }
    
    .empty-state-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6c757d;
        border-bottom: 1px solid #e9ecef;
    }
    
    .table td {
        vertical-align: middle;
        padding: 1rem 0.5rem;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(59, 130, 246, 0.04);
        transform: translateY(-1px);
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
    }
    
    .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 0.5rem;
        margin-top: 50px;
    }
    
    .breadcrumb-item a {
        color: #6c757d;
        text-decoration: none;
        transition: color 0.2s;
    }
    
    .breadcrumb-item a:hover {
        color: #3b82f6;
    }
    
    .form-check-input:checked {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }
    
    .dropdown-toggle::after {
        display: none;
    }
    
    .dropdown-menu {
        border: 1px solid #e9ecef;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-radius: 8px;
    }
    
    .dropdown-item {
        padding: 0.5rem 1rem;
        border-radius: 4px;
        margin: 0.1rem 0.5rem;
        width: auto;
    }
    
    .dropdown-item:hover {
        background-color: rgba(59, 130, 246, 0.1);
    }
    
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
    
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid #e9ecef;
    }
    
    .input-group-text {
        background-color: #fff;
        border-color: #dee2e6;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.1);
    }
    
    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .btn-primary {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }
    
    .btn-primary:hover {
        background-color: #2563eb;
        border-color: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    
    .btn-outline-primary:hover {
        transform: translateY(-1px);
    }
    
    .pagination {
        margin-bottom: 0;
    }
    
    .page-link {
        border: none;
        color: #6c757d;
        padding: 0.5rem 0.75rem;
        margin: 0 2px;
        border-radius: 6px;
    }
    
    .page-link:hover {
        background-color: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }
    
    .page-item.active .page-link {
        background-color: #3b82f6;
        color: white;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select All functionality
        const selectAll = document.getElementById('selectAll');
        const selectAllFooter = document.getElementById('selectAllFooter');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');
        
        function updateSelectAll() {
            const allChecked = Array.from(rowCheckboxes).every(cb => cb.checked);
            selectAll.checked = allChecked;
            selectAllFooter.checked = allChecked;
        }
        
        selectAll.addEventListener('change', function() {
            rowCheckboxes.forEach(cb => cb.checked = this.checked);
            selectAllFooter.checked = this.checked;
        });
        
        selectAllFooter.addEventListener('change', function() {
            rowCheckboxes.forEach(cb => cb.checked = this.checked);
            selectAll.checked = this.checked;
        });
        
        rowCheckboxes.forEach(cb => {
            cb.addEventListener('change', updateSelectAll);
        });
        
        // Delete Selected
        document.getElementById('deleteSelected')?.addEventListener('click', function() {
            const selectedIds = Array.from(rowCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);
            
            if (selectedIds.length === 0) {
                alert('Please select at least one record to delete.');
                return;
            }
            
            if (confirm(`Are you sure you want to delete ${selectedIds.length} selected record(s)?`)) {
                // Implement delete functionality here
                console.log('Deleting:', selectedIds);
            }
        });
        
        // Mark as Paid
        document.getElementById('markAsPaid')?.addEventListener('click', function() {
            const selectedIds = Array.from(rowCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);
            
            if (selectedIds.length === 0) {
                alert('Please select at least one record to mark as paid.');
                return;
            }
            
            if (confirm(`Mark ${selectedIds.length} selected record(s) as paid?`)) {
                // Implement mark as paid functionality here
                console.log('Marking as paid:', selectedIds);
            }
        });
    });
</script>
@endsection