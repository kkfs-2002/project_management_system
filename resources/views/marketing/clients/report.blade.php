@extends('layouts.marketing')
@section('title', 'Monthly Client Report')
@section('content')
<div class="container mt-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4" style="margin-top: 120px;">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-chart-bar text-primary me-2"></i>
                Monthly Client Report
            </h4>
            <p class="text-muted mb-0">{{ \Carbon\Carbon::parse($month)->format('F Y') }}</p>
        </div>
        <a href="{{ route('marketing.clients.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <!-- Filter Controls -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="btn-group w-100">
                        <a href="{{ route('marketing.clients.report', ['month' => $month]) }}" 
                           class="btn {{ !request('my_clients') ? 'btn-primary' : 'btn-outline-primary' }}">
                            All Clients
                        </a>
                        <a href="{{ route('marketing.clients.report', ['month' => $month, 'my_clients' => 1]) }}" 
                           class="btn {{ request('my_clients') ? 'btn-primary' : 'btn-outline-primary' }}">
                            My Clients Only
                        </a>
                    </div>
                </div>
                <div class="col-md-8">
                    <form method="GET" action="{{ route('marketing.clients.report') }}" class="d-flex">
                        <div class="input-group me-2">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                            <input type="month" name="month" value="{{ $month }}" class="form-control border-start-0">
                            @if(request('my_clients'))
                                <input type="hidden" name="my_clients" value="1">
                            @endif
                        </div>
                        <button class="btn btn-primary me-2">Filter</button>
                        <a href="{{ route('marketing.clients.report', ['month' => $month, 'download' => 1, 'my_clients' => request('my_clients')]) }}" 
                           class="btn btn-success">
                            <i class="fas fa-download me-1"></i> PDF
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="fas fa-users fa-2x text-primary"></i>
                    </div>
                    <h5 class="card-title text-muted mb-1">Total Clients</h5>
                    <h2 class="fw-bold mb-0">{{ $clients->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                    <h5 class="card-title text-muted mb-1">Active</h5>
                    <h2 class="fw-bold text-success mb-0">{{ $clients->where('status', 'active')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="fas fa-pause-circle fa-2x text-warning"></i>
                    </div>
                    <h5 class="card-title text-muted mb-1">Inactive</h5>
                    <h2 class="fw-bold text-warning mb-0">{{ $clients->where('status', 'inactive')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="fas fa-times-circle fa-2x text-danger"></i>
                    </div>
                    <h5 class="card-title text-muted mb-1">Cancelled</h5>
                    <h2 class="fw-bold text-danger mb-0">{{ $clients->where('status', 'cancelled')->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    @if($projectTypeData->isNotEmpty())
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-chart-pie me-2 text-primary"></i>
                Project Types Distribution
            </h5>
            <div class="d-flex justify-content-center">
                <div style="width: 350px; height: 250px;">
                    <canvas id="projectTypeChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Client List -->
    @if($clients->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                <h5 class="text-muted mb-2">No clients found for this month.</h5>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-lg">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3 fw-semibold">#</th>
                                <th class="py-3 fw-semibold">Name</th>
                                <th class="py-3 fw-semibold">Project</th>
                                <th class="py-3 fw-semibold">Type</th>
                                <th class="py-3 fw-semibold">Technology</th>
                                <th class="py-3 fw-semibold">Payment</th>
                                <th class="py-3 fw-semibold">Status</th>
                                <th class="py-3 fw-semibold">Reminder</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $index => $client)
                            <tr>
                                <td class="ps-4">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                             style="width: 36px; height: 36px;">
                                            <span class="fw-bold small">
                                                {{ strtoupper(substr($client->name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <strong>{{ $client->name }}</strong>
                                            @if($client->contact_number)
                                            <div class="text-muted small">{{ $client->contact_number }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $client->project_name ?? '-' }}</td>
                                <td>
                                    @if($client->project_type)
                                    <span class="badge bg-info bg-opacity-10 text-info px-3 py-1">
                                        {{ $client->project_type }}
                                    </span>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $client->technology ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $client->payment_status == 'Full' ? 'success' : ($client->payment_status == 'Advance' ? 'info' : 'secondary') }} px-3 py-2">
                                        {{ $client->payment_status }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $client->status == 'active' ? 'success' : ($client->status == 'inactive' ? 'warning' : 'danger') }} px-3 py-2">
                                        {{ ucfirst($client->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($client->reminder_date)
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar text-muted me-2"></i>
                                        <span>{{ \Carbon\Carbon::parse($client->reminder_date)->format('M d, Y') }}</span>
                                    </div>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @if($projectTypeData->isNotEmpty())
    const ctx = document.getElementById('projectTypeChart').getContext('2d');
    const projectTypeChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($projectTypeData->keys()) !!},
            datasets: [{
                label: 'Project Type',
                data: {!! json_encode($projectTypeData->values()) !!},
                backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 15,
                        padding: 10
                    }
                },
                title: {
                    display: true,
                    text: 'Project Types Distribution'
                }
            }
        }
    });
    @endif
</script>

<style>
    .card {
        border-radius: 0.5rem;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    
    .badge {
        border-radius: 0.25rem;
        font-weight: 500;
    }
    
    .bg-opacity-10 {
        opacity: 0.1;
    }
    
    .btn-group .btn {
        border-radius: 0.25rem !important;
    }
    
    .btn-group .btn:first-child {
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }
    
    .btn-group .btn:last-child {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }
    
    .input-group-text {
        background-color: #f8f9fa;
    }
</style>
@endsection