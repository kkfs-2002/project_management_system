@extends('layouts.marketing')

@section('title', 'Cancelled Clients')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4" style="margin-top: 50px">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-ban text-danger me-2"></i>
                Cancelled Clients
            </h4>
            <p class="text-muted mb-0">View all cancelled and hidden client records</p>
        </div>
        <div>
            <a href="{{ route('marketing.clients.reminders') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back to Reminders
            </a>
        </div>
    </div>

    <!-- Status Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fas fa-ban text-danger"></i>
                        </div>
                        <div>
                            <div class="text-muted">Total Cancelled</div>
                            <h4 class="fw-bold mb-0">{{ $clients->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fas fa-calendar-alt text-warning"></i>
                        </div>
                        <div>
                            <div class="text-muted">This Month</div>
                            <h4 class="fw-bold mb-0">
                                {{ $clients->where('updated_at', '>=', now()->startOfMonth())->count() }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fas fa-clock text-info"></i>
                        </div>
                        <div>
                            <div class="text-muted">Recently</div>
                            <h4 class="fw-bold mb-0">
                                {{ $clients->where('updated_at', '>=', now()->subDays(7))->count() }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="card shadow-lg border-0">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0">
                <i class="fas fa-list me-2 text-danger"></i>
                Cancelled Clients List
            </h5>
        </div>

        @if ($clients->isEmpty())
        <div class="card-body">
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-ban fa-3x text-muted opacity-50"></i>
                </div>
                <h5 class="fw-bold text-muted mb-2">No Cancelled Clients</h5>
                <p class="text-muted mb-4">There are no cancelled or hidden clients in the system.</p>
                <a href="{{ route('marketing.clients.index') }}" class="btn btn-primary">
                    <i class="fas fa-eye me-2"></i> View Active Clients
                </a>
            </div>
        </div>
        @else
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 fw-semibold">Client Name</th>
                            <th class="py-3 fw-semibold">Contact Number</th>
                            <th class="py-3 fw-semibold">Reminder Date</th>
                            <th class="py-3 fw-semibold">Note</th>
                            <th class="py-3 fw-semibold">Cancel Reason</th>
                            <th class="py-3 fw-semibold">Cancelled At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 40px; height: 40px;">
                                        <span class="fw-bold">
                                            {{ strtoupper(substr($client->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0">{{ $client->name }}</h6>
                                        @if($client->project_name)
                                        <small class="text-muted">
                                            {{ $client->project_name }}
                                        </small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($client->contact_number)
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-phone text-muted me-2"></i>
                                    <span>{{ $client->contact_number }}</span>
                                </div>
                                @else
                                <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($client->reminder_date)
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar text-muted me-2"></i>
                                    <span>{{ \Carbon\Carbon::parse($client->reminder_date)->format('M d, Y') }}</span>
                                </div>
                                @else
                                <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($client->note)
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-sticky-note text-muted me-2"></i>
                                    <span class="text-truncate" style="max-width: 200px;">
                                        {{ $client->note }}
                                    </span>
                                </div>
                                @else
                                <span class="text-muted">No notes</span>
                                @endif
                            </td>
                            <td>
                                @if($client->cancel_reason)
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2">
                                    <i class="fas fa-times-circle me-1"></i>
                                    {{ $client->cancel_reason }}
                                </span>
                                @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2">
                                    Not specified
                                </span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($client->updated_at)->format('M d, Y') }}
                                    </small>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($client->updated_at)->format('h:i A') }}
                                    </small>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Card Footer -->
        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted">
                        Showing {{ $clients->count() }} cancelled clients
                    </span>
                </div>
                <div>
                    <button class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-download me-1"></i> Export
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .card {
        border-radius: 0.75rem;
        overflow: hidden;
    }
    
    .card-header {
        border-bottom: 1px solid #e9ecef;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    
    .badge {
        border-radius: 0.375rem;
        font-weight: 500;
    }
    
    .text-truncate {
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .bg-opacity-10 {
        opacity: 0.1;
    }
    
    .bg-danger.bg-opacity-10 {
        background-color: rgba(220, 53, 69, 0.1) !important;
    }
    
    .bg-warning.bg-opacity-10 {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }
    
    .bg-info.bg-opacity-10 {
        background-color: rgba(13, 202, 240, 0.1) !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add hover effect to table rows
        const tableRows = document.querySelectorAll('.table tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'rgba(220, 53, 69, 0.05)';
            });
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });
        
        // Export button functionality
        const exportBtn = document.querySelector('.btn-outline-primary');
        if (exportBtn) {
            exportBtn.addEventListener('click', function() {
                alert('Export functionality would be implemented here');
            });
        }
    });
</script>
@endsection