@extends('layouts.app')

@section('title', 'Salary Details - ' . $salary->profile->full_name)

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <div class="mb-3 mb-md-0" style="margin-top: 90px;">
            <nav aria-label="breadcrumb" class="d-none d-md-block">
                <ol class="breadcrumb mb-2">
               
                </ol>
            </nav>
            <div class="d-flex align-items-center">
                <div class="icon-wrapper bg-gradient-primary rounded-3 p-3 me-3">
                    <i class="fas fa-file-invoice-dollar fa-lg text-white"></i>
                </div>
                <div>
                    <h1 class="h3 fw-bold mb-1">Salary Details</h1>
                    <p class="text-muted mb-0">{{ $salary->profile->full_name }} | {{ \Carbon\Carbon::parse($salary->salary_month)->format('F Y') }}</p>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-2"style="margin-top: 50px;">
            <a href="{{ route('superadmin.salary.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
            <a href="javascript:void(0)" 
   class="btn btn-outline-primary d-flex align-items-center"
   onclick="window.print()">
    <i class="fas fa-print me-2"></i> Print
</a>

           
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-lg-8">
            <!-- Salary Details Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-semibold"><i class="fas fa-money-bill-wave me-2 text-primary"></i>Salary Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-4">
                                <div class="avatar-lg bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                    {{ substr($salary->profile->full_name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-1">{{ $salary->profile->full_name }}</h4>
                                    <p class="text-muted mb-0">
                                        @if($salary->profile->employee_id)
                                            ID: {{ $salary->profile->employee_id }}
                                        @endif
                                        @if($salary->profile->designation)
                                            | {{ $salary->profile->designation }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light p-4 rounded text-center">
                                <p class="text-muted mb-2">Salary Amount</p>
                                <h2 class="fw-bold text-primary mb-0">Rs {{ number_format($salary->amount, 2) }}</h2>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted mb-1">Payment Date</label>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar text-primary me-2"></i>
                                <div>
                                    <p class="fw-medium mb-0">{{ \Carbon\Carbon::parse($salary->salary_month)->format('d M Y') }}</p>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($salary->salary_month)->format('l') }}</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted mb-1">Payment Status</label>
                            <div>
                                @if($salary->status == 'paid')
                                    <span class="badge bg-success rounded-pill px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i> Paid
                                    </span>
                                @elseif($salary->status == 'pending')
                                    <span class="badge bg-warning rounded-pill px-3 py-2">
                                        <i class="fas fa-clock me-1"></i> Pending
                                    </span>
                                @else
                                    <span class="badge bg-secondary rounded-pill px-3 py-2">{{ $salary->status }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted mb-1">Payment Method</label>
                            <p class="fw-medium mb-0">
                                <i class="fas fa-credit-card text-primary me-2"></i>
                                {{ $salary->payment_method ? ucfirst($salary->payment_method) : 'Not Specified' }}
                            </p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted mb-1">Record Created</label>
                            <p class="fw-medium mb-0">
                                <i class="fas fa-clock text-primary me-2"></i>
                                {{ \Carbon\Carbon::parse($salary->created_at)->format('d M Y, h:i A') }}
                            </p>
                        </div>
                    </div>

                    @if($salary->notes)
                    <div class="mt-4 pt-3 border-top">
                        <label class="form-label text-muted mb-2">Notes</label>
                        <div class="bg-light p-3 rounded">
                            <p class="mb-0">{{ $salary->notes }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Employee Information -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-semibold"><i class="fas fa-user-tie me-2 text-primary"></i>Employee Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted mb-1">Department</label>
                            <p class="fw-medium mb-0">
                                <i class="fas fa-building text-primary me-2"></i>
                                {{ $salary->profile->department->name ?? 'N/A' }}
                            </p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted mb-1">Email</label>
                            <p class="fw-medium mb-0">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                {{ $salary->profile->email ?? 'N/A' }}
                            </p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted mb-1">Phone</label>
                            <p class="fw-medium mb-0">
                                <i class="fas fa-phone text-primary me-2"></i>
                                {{ $salary->profile->phone ?? 'N/A' }}
                            </p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted mb-1">Joined Date</label>
                            <p class="fw-medium mb-0">
                                <i class="fas fa-calendar-plus text-primary me-2"></i>
                                {{ $salary->profile->joined_date ? \Carbon\Carbon::parse($salary->profile->joined_date)->format('d M Y') : 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-semibold"><i class="fas fa-bolt me-2 text-primary"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-danger text-start" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i>Delete Record
                        </button>
                    </div>
                </div>
            </div>

            <!-- Record Summary -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-semibold"><i class="fas fa-info-circle me-2 text-primary"></i>Record Summary</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Record ID</span>
                                <span class="fw-medium">#{{ str_pad($salary->id, 6, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </li>
                        <li class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Last Updated</span>
                                <span class="fw-medium">{{ \Carbon\Carbon::parse($salary->updated_at)->format('d M Y, h:i A') }}</span>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Employee ID</span>
                                <span class="fw-medium">{{ $salary->profile->id }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this salary record?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    This action cannot be undone. All data will be permanently deleted.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('superadmin.salary.destroy', $salary->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Permanently</button>
                </form>
            </div>
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
    
    .avatar-lg {
        width: 60px;
        height: 60px;
        font-weight: 600;
        font-size: 24px;
    }
    
    .card {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e9ecef;
    }
    
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid #e9ecef;
    }
    
    .form-label {
        color: #6c757d;
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
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
    
    .d-grid .btn {
        text-align: left;
        justify-content: flex-start;
        padding: 0.75rem 1rem;
    }
    
    .border-top {
        border-top: 1px solid #e9ecef;
    }
</style>
@endsection