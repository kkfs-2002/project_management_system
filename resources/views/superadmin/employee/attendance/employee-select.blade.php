
@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h4 class="mb-4">
    <i class="fas fa-user-clock me-2"></i>
    Attendance Tracker
  </h4>

  {{-- EMPLOYEE SELECT FORM --}}
  <form method="GET" action="{{ route('superadmin.attendance.employee.month') }}" class="row mb-4">
    <div class="col-md-4">
      <label class="form-label">Employee</label>
      <select name="employee_id" class="form-select" required>
        <option value="">-- Select Employee --</option>
        @foreach($employees as $emp)
          <option value="{{ $emp->id }}" {{ isset($employee) && $employee->id === $emp->id ? 'selected' : '' }}>
            {{ $emp->full_name }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="col-md-3">
      <label class="form-label">Month</label>
      <select name="month" class="form-select">
        @foreach($allMonths as $m)
          <option value="{{ $m['value'] }}" {{ $m['value'] === $month ? 'selected' : '' }}>
            {{ $m['label'] }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="col-md-2 d-flex align-items-end">
      <button class="btn btn-primary w-100">
        <i class="fas fa-search me-1"></i> View
      </button>
    </div>
  </form>

  @if(isset($employee))
    {{-- STATS --}}
    <div class="row mb-4">
      <div class="col-md-3">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <h6 class="text-muted">Days Present</h6>
            <h3 class="fw-bold mb-0">{{ $daysPresent }}</h3>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <h6 class="text-muted">Total Hours</h6>
            <h3 class="fw-bold mb-0">{{ $totalHours }}</h3>
          </div>
        </div>
      </div>
    </div>

    {{-- CHART --}}
    <canvas id="hoursChart" height="120"></canvas>

    {{-- PDF --}}
    <form class="mt-4" method="GET" action="{{ route('superadmin.attendance.employee.month.pdf') }}">
      <input type="hidden" name="employee_id" value="{{ $employee->id }}">
      <input type="hidden" name="month" value="{{ $month }}">
      <input type="hidden" name="days_present" value="{{ $daysPresent }}">
      <input type="hidden" name="total_hours" value="{{ $totalHours }}">
      <input type="hidden" name="daily_hours" value='@json($dailyHours)'>
      <button class="btn btn-dark">
        <i class="fas fa-file-pdf"></i> Download PDF
      </button>
    </form>
  @endif
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@if(isset($employee))
<script>
(() => {
    const labels = {!! json_encode($dailyHours->keys()->toArray()) !!};
    const data = {!! json_encode($dailyHours->values()->toArray()) !!};

    const ctx = document.getElementById('hoursChart').getContext('2d');
    if (window.hoursChart instanceof Chart) {
        window.hoursChart.destroy();
    }

    window.hoursChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Hours worked',
                data: data,
                fill: true,
                tension: 0.4,
                borderWidth: 2,
                borderColor: 'rgba(13,110,253,1)',
                backgroundColor: 'rgba(13,110,253,0.15)',
                pointRadius: 4,
                pointBackgroundColor: 'rgba(13,110,253,0.9)'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { grid: { display: false } },
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 },
                    grid: { color: 'rgba(0,0,0,.05)' }
                }
            }
        }
    });
})();
</script>
@endif
@endsection