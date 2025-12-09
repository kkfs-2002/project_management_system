@extends('layouts.marketing')
@section('title', 'Monthly Client Report')
@section('content')
<div class="container mt-4">
    <h2>📊 Monthly Client Report - {{ \Carbon\Carbon::parse($month)->format('F Y') }}</h2>
    
    {{-- Toggle for All Clients vs My Clients --}}
    <div class="mb-3">
        <a href="{{ route('marketing.clients.report', ['month' => $month]) }}" 
           class="btn btn-sm {{ !request('my_clients') ? 'btn-primary' : 'btn-outline-primary' }}">
            All Clients
        </a>
        <a href="{{ route('marketing.clients.report', ['month' => $month, 'my_clients' => 1]) }}" 
           class="btn btn-sm {{ request('my_clients') ? 'btn-primary' : 'btn-outline-primary' }}">
            My Clients Only
        </a>
    </div>
    
    {{-- Filter & Download --}}
    <form method="GET" action="{{ route('marketing.clients.report') }}" class="d-flex align-items-center my-3">
        <input type="month" name="month" value="{{ $month }}" class="form-control me-2" style="max-width: 200px;">
        @if(request('my_clients'))
            <input type="hidden" name="my_clients" value="1">
        @endif
        <button class="btn btn-primary me-2">Filter</button>
        <a href="{{ route('marketing.clients.report', ['month' => $month, 'download' => 1, 'my_clients' => request('my_clients')]) }}" class="btn btn-success">
            <i class="fas fa-download me-1"></i>Download PDF
        </a>
    </form>
    
    {{-- Stats Summary --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Clients</h5>
                    <h3>{{ $clients->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Active</h5>
                    <h3 class="text-success">{{ $clients->where('status', 'active')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Inactive</h5>
                    <h3 class="text-warning">{{ $clients->where('status', 'inactive')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Cancelled</h5>
                    <h3 class="text-danger">{{ $clients->where('status', 'cancelled')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Pie Chart --}}
    @if($projectTypeData->isNotEmpty())
    <div style="max-width: 350px; margin-bottom: 30px;">
        <canvas id="projectTypeChart" width="350" height="250"></canvas>
    </div>
    @endif
    
    {{-- Client List --}}
    @if($clients->isEmpty())
        <div class="alert alert-warning mt-4">No clients found for this month.</div>
    @else
        <table class="table table-bordered table-striped mt-4">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Project</th>
                    <th>Type</th>
                    <th>Technology</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Reminder</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $index => $client)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->project_name ?? '-' }}</td>
                    <td>{{ $client->project_type ?? '-' }}</td>
                    <td>{{ $client->technology ?? '-' }}</td>
                    <td>
                        <span class="badge bg-{{ $client->payment_status == 'Full' ? 'success' : ($client->payment_status == 'Advance' ? 'info' : 'secondary') }}">
                            {{ $client->payment_status }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $client->status == 'active' ? 'success' : ($client->status == 'inactive' ? 'warning' : 'danger') }}">
                            {{ ucfirst($client->status) }}
                        </span>
                    </td>
                    <td>{{ $client->reminder_date ? \Carbon\Carbon::parse($client->reminder_date)->format('M d, Y') : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
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
@endsection