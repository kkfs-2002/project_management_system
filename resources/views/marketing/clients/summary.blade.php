@extends('layouts.marketing')
@section('content')
<div class="container" style="margin-top: 120px;">

    <h4 class="mb-4">📊 Client Summary Report - {{ \Carbon\Carbon::parse($month)->format('F Y') }}</h4>
    
    {{-- Toggle for All Clients vs My Clients --}}
    <div class="mb-3">
        <a href="{{ route('marketing.clients.summary', ['month' => $month]) }}" 
           class="btn btn-sm {{ !request('my_clients') ? 'btn-primary' : 'btn-outline-primary' }}">
            All Clients
        </a>
        <a href="{{ route('marketing.clients.summary', ['month' => $month, 'my_clients' => 1]) }}" 
           class="btn btn-sm {{ request('my_clients') ? 'btn-primary' : 'btn-outline-primary' }}">
            My Clients Only
        </a>
    </div>
    
    <form method="GET" class="mb-4 row g-3">
        <div class="col-md-4">
            <label for="month" class="form-label">Select Month</label>
            <input type="month" name="month" id="month" class="form-control" value="{{ $month }}">
        </div>
        @if(request('my_clients'))
            <input type="hidden" name="my_clients" value="1">
        @endif
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <a href="{{ route('marketing.clients.summary.pdf', ['month' => $month, 'my_clients' => request('my_clients')]) }}" 
               class="btn btn-success">
                <i class="fas fa-download me-1"></i> Download PDF
            </a>
        </div>
    </form>
    
    {{-- Summary Cards --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Clients</h5>
                    <h2>{{ $total }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Active</h5>
                    <h2>{{ $active }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center bg-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title">Inactive</h5>
                    <h2>{{ $inactive }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">Cancelled</h5>
                    <h2>{{ $cancelled }}</h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <strong>Status Distribution Chart</strong>
                </div>
                <div class="card-body">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <strong>Client Status Breakdown</strong>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-circle text-success me-2"></i><strong>Active Clients</strong></span>
                            <span class="badge bg-success rounded-pill">{{ $active }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-circle text-warning me-2"></i><strong>Inactive Clients</strong></span>
                            <span class="badge bg-warning text-dark rounded-pill">{{ $inactive }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-circle text-danger me-2"></i><strong>Cancelled Clients</strong></span>
                            <span class="badge bg-danger rounded-pill">{{ $cancelled }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                            <span><strong>Total Clients</strong></span>
                            <span class="badge bg-primary rounded-pill">{{ $total }}</span>
                        </li>
                    </ul>
                    
                    {{-- Percentages --}}
                    @if($total > 0)
                    <div class="mt-3">
                        <h6>Percentage Distribution:</h6>
                        <div class="progress mb-2" style="height: 25px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: {{ ($active / $total) * 100 }}%"
                                 aria-valuenow="{{ $active }}" aria-valuemin="0" aria-valuemax="{{ $total }}">
                                {{ number_format(($active / $total) * 100, 1) }}%
                            </div>
                            <div class="progress-bar bg-warning" role="progressbar" 
                                 style="width: {{ ($inactive / $total) * 100 }}%"
                                 aria-valuenow="{{ $inactive }}" aria-valuemin="0" aria-valuemax="{{ $total }}">
                                {{ number_format(($inactive / $total) * 100, 1) }}%
                            </div>
                            <div class="progress-bar bg-danger" role="progressbar" 
                                 style="width: {{ ($cancelled / $total) * 100 }}%"
                                 aria-valuenow="{{ $cancelled }}" aria-valuemin="0" aria-valuemax="{{ $total }}">
                                {{ number_format(($cancelled / $total) * 100, 1) }}%
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('statusChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Active', 'Inactive', 'Cancelled'],
            datasets: [{
                label: 'Client Status',
                data: [{{ $active }}, {{ $inactive }}, {{ $cancelled }}],
                backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { 
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 12
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Client Status Distribution',
                    font: {
                        size: 16,
                        weight: 'bold'
                    },
                    padding: 20
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.parsed || 0;
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let percentage = ((value / total) * 100).toFixed(1);
                            return label + ': ' + value + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection