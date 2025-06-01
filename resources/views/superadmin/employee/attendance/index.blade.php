@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Monthly Attendance Dashboard</h2>

    <form method="GET" class="mb-4">
        <label>Select Month:</label>
        <input type="month" name="month" value="{{ $month }}" required>
        <button class="btn btn-primary">Filter</button>
    </form>
    
    <canvas id="dailyChart" height="100"></canvas>
    <canvas id="employeeChart" height="100" class="mt-5"></canvas>

    <form method="GET" action="{{ route('superadmin.employee.attendance.pdf') }}">
        <input type="hidden" name="month" value="{{ $month }}">
        <input type="hidden" name="dailyCount" value='@json($dailyCount)'>
        <input type="hidden" name="employeeProgress" value='@json($employeeProgress)'>
        <button class="btn btn-success mt-3">Download PDF</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const dailyLabels = {!! json_encode(array_keys($dailyCount->toArray())) !!};
        const dailyData = {!! json_encode(array_values($dailyCount->toArray())) !!};

        console.log("Daily Labels:", dailyLabels);
        console.log("Daily Data:", dailyData);

        new Chart(document.getElementById('dailyChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: dailyLabels,
                datasets: [{
                    label: 'Daily Attendance Count',
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    data: dailyData
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMax: 10,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        const empLabels = {!! json_encode($employeeProgress->pluck('name')) !!};
        const empData = {!! json_encode($employeeProgress->pluck('hours')) !!};

        console.log("Employee Labels:", empLabels);
        console.log("Employee Hours:", empData);

        new Chart(document.getElementById('employeeChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: empLabels,
                datasets: [{
                    label: 'Total Hours Worked',
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40,167,69,0.2)',
                    borderWidth: 2,
                    pointRadius: 4,
                    fill: true,
                    data: empData
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMax: 10,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });
</script>
@endsection