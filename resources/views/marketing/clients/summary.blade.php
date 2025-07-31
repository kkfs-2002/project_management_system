@extends('layouts.marketing')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Client Summary Report</h4>

    <form method="GET" class="mb-4 row g-3">
        <div class="col-md-4">
            <label for="month" class="form-label">Select Month</label>
            <input type="month" name="month" id="month" class="form-control" value="{{ $month }}">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <a href="{{ route('marketing.clients.summary.pdf', ['month' => $month]) }}" class="btn btn-outline-secondary">Download PDF</a>
        </div>
    </form>

    <div class="row">
        <div class="col-md-6">
            <canvas id="statusChart"></canvas>
        </div>
        <div class="col-md-6">
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between">
                    <span><strong>Active Clients</strong></span>
                    <span>{{ $active }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span><strong>Inactive Clients</strong></span>
                    <span>{{ $inactive }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span><strong>Cancelled Clients</strong></span>
                    <span>{{ $cancelled }}</span>
                </li>
            </ul>
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
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endsection
