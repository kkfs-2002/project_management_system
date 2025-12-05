@extends('layouts.app')

@section('title', 'All Clients')

@section('content')
<div class="container-fluid py-4">

    {{-- Header Section with margin top --}}
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-5 mt-5">
        <div>
            <h2 class="h4 fw-bold text-dark mb-1">Client Management</h2>
            <p class="text-muted mb-0">Manage and monitor all client records</p>
        </div>
       
    </div>
    {{-- Stats Cards --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-start border-primary border-3 shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Clients</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $clientsByMonth->sum->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-start border-warning border-3 shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">Pending Requests</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $pendingRequests->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-start border-success border-3 shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">Active Projects</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $activeProjects ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-start border-info border-3 shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">This Month</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">
                                @php
                                    $currentMonth = date('F Y');
                                    $monthClients = $clientsByMonth[$currentMonth] ?? collect([]);
                                    echo $monthClients->count();
                                @endphp
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Panel --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-dark">
                <i class="fas fa-filter me-2"></i>Filter Clients
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('superadmin.clients.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted">Month Filter</label>
                    <input type="month" name="month" id="month" class="form-control" value="{{ request('month') }}">
                </div>
                
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted">Marketing Manager</label>
                    <select name="manager" id="manager" class="form-select">
                        <option value="">All Managers</option>
                        @foreach($managers as $manager)
                            <option value="{{ $manager->employee_id }}" 
                                {{ request('manager') == $manager->employee_id ? 'selected' : '' }}>
                                {{ $manager->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1 d-flex align-items-center justify-content-center">
                        <i class="fas fa-search me-2"></i> Apply Filters
                    </button>
                    @if(request('month') || request('manager'))
                    <a href="{{ route('superadmin.clients.index') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                        <i class="fas fa-times me-2"></i> Clear
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($clientsByMonth->isEmpty())
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No clients found</h5>
                <p class="text-muted">Start by adding your first client</p>
                <a href="{{ route('superadmin.clients.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i> Add Client
                </a>
            </div>
        </div>
    @else
        {{-- Clients by Month --}}
        <div class="accordion mb-4" id="clientsAccordion">
            @foreach ($clientsByMonth as $monthYear => $clients)
                <div class="accordion-item border-0 shadow-sm mb-3">
                    <h2 class="accordion-header" id="heading{{ $loop->index }}">
                        <button class="accordion-button collapsed bg-white shadow-sm" type="button" 
                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->index }}" 
                                aria-expanded="false" aria-controls="collapse{{ $loop->index }}">
                            <div class="d-flex align-items-center w-100">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-light text-dark rounded-circle p-2 me-3">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $monthYear }}</h6>
                                        <small class="text-muted">{{ $clients->count() }} client(s)</small>
                                    </div>
                                </div>
                                @php
                                    $monthPendingCount = $clients->where('edit_permission', 'pending')->count();
                                @endphp
                                @if($monthPendingCount > 0)
                                    <span class="badge bg-warning text-dark ms-auto me-3">
                                        <i class="fas fa-clock me-1"></i>{{ $monthPendingCount }} pending
                                    </span>
                                @endif
                            </div>
                        </button>
                    </h2>
                    <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse" 
                         aria-labelledby="heading{{ $loop->index }}" data-bs-parent="#clientsAccordion">
                        <div class="accordion-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0">Client</th>
                                            <th class="border-0">Project Details</th>
                                            <th class="border-0">Payment</th>
                                            <th class="border-0">Status</th>
                                            <th class="border-0">Reminder</th>
                                            <th class="border-0">Permission</th>
                                            <th class="border-0 text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($clients as $client)
                                        <tr class="{{ $client->edit_permission === 'pending' ? 'bg-light-warning' : '' }}">
                                            {{-- Client Info --}}
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                                        <i class="fas fa-user text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-semibold">{{ $client->name }}</h6>
                                                        <small class="text-muted">{{ $client->contact_number }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            
                                            {{-- Project Details --}}
                                            <td class="align-middle">
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">{{ $client->project_name }}</h6>
                                                    <div class="d-flex flex-wrap gap-1 mt-1">
                                                        <span class="badge bg-light text-dark">{{ $client->project_type }}</span>
                                                        <span class="badge bg-light text-dark">{{ $client->technology }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            
                                            {{-- Payment --}}
                                            <td class="align-middle">
                                                <div>
                                                    <span class="badge bg-{{ $client->payment_status === 'paid' ? 'success' : ($client->payment_status === 'pending' ? 'warning' : 'danger') }}-subtle text-{{ $client->payment_status === 'paid' ? 'success' : ($client->payment_status === 'pending' ? 'warning' : 'danger') }} mb-1 d-inline-block">
                                                        {{ ucfirst($client->payment_status) }}
                                                    </span>
                                                    <div class="fw-bold">Rs.{{ number_format($client->amount, 2) }}</div>
                                                </div>
                                            </td>
                                            
                                            {{-- Status --}}
                                            <td class="align-middle">
                                                <span class="badge bg-{{ $client->status === 'active' ? 'success' : ($client->status === 'pending' ? 'warning' : 'secondary') }}-subtle text-{{ $client->status === 'active' ? 'success' : ($client->status === 'pending' ? 'warning' : 'secondary') }}">
                                                    {{ ucfirst($client->status) }}
                                                </span>
                                            </td>
                                            
                                            {{-- Reminder --}}
                                            <td class="align-middle">
                                                @if($client->reminder_date)
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-bell text-warning me-2"></i>
                                                    <span>{{ \Carbon\Carbon::parse($client->reminder_date)->format('d/m/Y') }}</span>
                                                </div>
                                                @else
                                                <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            
                                            {{-- Permission Status --}}
                                            <td class="align-middle">
                                                @if ($client->edit_permission === 'pending')
                                                    <div class="d-flex gap-1">
                                                        <form action="{{ route('superadmin.clients.approve-permission', $client->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm px-2 py-1" title="Approve">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('superadmin.clients.reject-permission', $client->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger btn-sm px-2 py-1" title="Reject">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @elseif ($client->edit_permission === 'approved')
                                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                                        <i class="fas fa-check-circle me-1"></i>Approved
                                                    </span>
                                                @elseif ($client->edit_permission === 'rejected')
                                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">
                                                        <i class="fas fa-times-circle me-1"></i>Rejected
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                                        No Request
                                                    </span>
                                                @endif
                                            </td>
                                            
                                            {{-- Actions --}}
                                            <td class="align-middle text-end">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow">
                                                        <li>
                                                            <a class="dropdown-item" href="#">
                                                                <i class="fas fa-eye me-2"></i>View Details
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#">
                                                                <i class="fas fa-edit me-2"></i>Edit
                                                            </a>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <a class="dropdown-item text-danger" href="#">
                                                                <i class="fas fa-trash me-2"></i>Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Pending Requests Alert --}}
    @if($pendingRequests->count() > 0)
        <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle fa-lg me-3"></i>
                <div>
                    <h6 class="alert-heading mb-1">Pending Permission Requests</h6>
                    <p class="mb-0">You have <strong>{{ $pendingRequests->count() }}</strong> pending permission requests that require your attention.</p>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif
</div>

<style>
:root {
    --primary-color: #4e73df;
    --success-color: #1cc88a;
    --warning-color: #f6c23e;
    --danger-color: #e74a3b;
    --info-color: #36b9cc;
}

.accordion-button:not(.collapsed) {
    background-color: #f8f9fa;
    box-shadow: none;
}

.avatar-sm {
    width: 40px;
    height: 40px;
}

.bg-light-warning {
    background-color: rgba(246, 194, 62, 0.1) !important;
}

.bg-success-subtle {
    background-color: rgba(28, 200, 138, 0.1) !important;
}

.bg-warning-subtle {
    background-color: rgba(246, 194, 62, 0.1) !important;
}

.bg-danger-subtle {
    background-color: rgba(231, 74, 59, 0.1) !important;
}

.bg-secondary-subtle {
    background-color: rgba(133, 135, 150, 0.1) !important;
}

.table-hover tbody tr:hover {
    background-color: rgba(78, 115, 223, 0.05);
    transition: background-color 0.2s ease;
}

.dropdown-menu {
    border: none;
    min-width: 180px;
}

.card {
    border: none;
    border-radius: 0.75rem;
}

.border-start {
    border-left-width: 4px !important;
}

.badge {
    font-weight: 500;
    padding: 0.35em 0.65em;
}

.btn-group .btn-light {
    border-color: #dee2e6;
}

.btn-group .btn-light:hover {
    background-color: #f8f9fa;
    border-color: #adb5bd;
}
</style>

<script>
// Add smooth scrolling and auto-expand if filter is applied
document.addEventListener('DOMContentLoaded', function() {
    @if(request('month'))
        // Auto expand the current month's accordion if filtered by month
        const currentMonth = "{{ request('month') }}";
        if (currentMonth) {
            const formattedMonth = new Date(currentMonth + '-01').toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long' 
            });
            const headings = document.querySelectorAll('.accordion-button');
            headings.forEach((heading, index) => {
                if (heading.textContent.includes(formattedMonth)) {
                    const collapseId = heading.getAttribute('data-bs-target');
                    const collapseElement = document.querySelector(collapseId);
                    new bootstrap.Collapse(collapseElement, { toggle: true });
                }
            });
        }
    @endif
});
</script>
@endsection