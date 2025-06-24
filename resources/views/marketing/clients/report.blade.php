@extends('layouts.marketing')

@section('title', 'Monthly Client Report')

@section('content')
<div class="container mt-4">
    <h2>📊 Monthly Client Report - {{ \Carbon\Carbon::parse($month)->format('F Y') }}</h2>

    {{-- Filter & Download --}}
    <form method="GET" action="{{ route('marketing.clients.report') }}" class="d-flex align-items-center my-3">
        <input type="month" name="month" value="{{ $month }}" class="form-control me-2" style="max-width: 200px;">
        <button class="btn btn-primary me-2">Filter</button>
        <a href="{{ route('marketing.clients.report', ['month' => $month, 'download' => 1]) }}" class="btn btn-success">
            <i class="fas fa-download me-1"></i>Download PDF
        </a>
    </form>

    {{-- Pie Chart --}}
    <div style="max-width: 350px; margin-bottom: 30px;">
        <canvas id="projectTypeChart" width="350" height="250"></canvas>
    </div>

    {{-- Client List --}}
    @if($clients->isEmpty())
        <div class="alert alert-warning mt-4">No clients found for this month.</div>
    @else
        <table class="table table-bordered table-striped mt-4">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Project</th>
                    <th>Type</th>
                    <th>Technology</th>
                    <th>Payment</th>
                    <th>Reminder</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->project_name }}</td>
                    <td>{{ $client->project_type }}</td>
                    <td>{{ $client->technology }}</td>
                    <td>{{ ucfirst($client->payment_status) }}</td>
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
                }
            }
        }
    });
</script>
@endsection
