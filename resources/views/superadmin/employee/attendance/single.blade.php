@extends('layouts.app')

@section('content')
<div class="container py-4">

  {{-- HEADER --}}
  <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="mb-0">
          <i class="fas fa-user-clock me-2"></i>
          {{ $employee->full_name }}
      </h4>
      <a href="{{ route('superadmin.attendance.employee.month') }}" class="btn btn-sm btn-outline-secondary">
         <i class="fas fa-arrow-left"></i> Change Employee
      </a>
  </div>

  {{-- MONTH BUTTONS --}}
  <div class="d-flex flex-wrap gap-2 mb-4">
      @foreach($allMonths as $m)
          <form method="GET" action="{{ route('superadmin.attendance.employee.month') }}">
              <input type="hidden" name="employee_id" value="{{ $employee->id }}">
              <input type="hidden" name="month" value="{{ $m['value'] }}">
              <button class="btn btn-outline-primary {{ $m['value'] === $month ? 'active' : '' }}">
                 {{ $m['label'] }}
              </button>
          </form>
      @endforeach
  </div>

  {{-- KPI CARDS --}}
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

  {{-- WORKING HOURS CHART --}}
  <canvas id="hoursChart" height="120"></canvas>

  {{-- PDF Download --}}
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

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
(() => {
    /* convert the Collection into plain JS arrays */
    const labels = {!! json_encode($dailyHours->keys()->toArray()) !!};
    const data   = {!! json_encode($dailyHours->values()->toArray()) !!};

    console.log('labels', labels);   // should print all days of the month
    console.log('data',   data);     // ex: [0,4,0,7.5, …]

    const ctx = document.getElementById('hoursChart').getContext('2d');
    if (window.hoursChart instanceof Chart) window.hoursChart.destroy();

    window.hoursChart = new Chart(ctx, {
        type : 'line',
        data : {
            labels,
            datasets:[{
                data,
                label:'Hours worked',
                fill:true,
                tension:0.4,
                borderWidth:2,
                borderColor:'rgba(13,110,253,1)',     // bootstrap primary
                backgroundColor:'rgba(13,110,253,.15)',
                pointRadius:4,
                pointBackgroundColor:'rgba(13,110,253,.9)'
            }]
        },
        options:{
            responsive:true,
            plugins:{ legend:{ display:false } },
            scales:{
                x:{ grid:{ display:false } },
                y:{ beginAtZero:true, ticks:{ stepSize:1 },
                    grid:{ color:'rgba(0,0,0,.05)' } }
            }
        }
    });
})();
</script>

@endsection