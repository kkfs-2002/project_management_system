@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Project Timeline Overview</h2>

    @if($timelineProjects->isEmpty())
        <p>No projects with deadlines found.</p>
    @else
        <div class="timeline-wrapper">
            @foreach($timelineProjects as $project)
                <div class="timeline-item mb-4 position-relative">
                    {{-- Connector Line --}}
                    <div class="timeline-line"></div>

                    {{-- Circle indicator --}}
                    <div class="timeline-dot {{ $project['color'] }}"></div>

                    {{-- Project Info --}}
                    <div class="timeline-content card shadow-sm p-3 ms-5">
                    
                        <h6 class="fw-bold mb-1">{{ $project['name'] }}</h6>
                        <div class="small text-muted mb-1">
                            <i class="bi bi-play-circle"></i> Start: {{ $project['start_date'] }} &nbsp; | &nbsp;
                            <i class="bi bi-flag-fill"></i> Deadline: {{ $project['deadline'] }}
                        </div>

                        @if($project['days_remaining'] > 0)
                            <span class="badge bg-warning">⏳ {{ $project['days_remaining'] }} day(s) remaining</span>
                        @elseif($project['days_remaining'] == 0)
                            <span class="badge bg-danger">🔴 Deadline is today!</span>
                        @else
                            <span class="badge bg-danger">⚠ Overdue by {{ abs($project['days_remaining']) }} day(s)</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
.timeline-wrapper {
    position: relative;
    margin-left: 20px;
    padding-left: 20px;
    border-left: 4px solid #0a4275;
}

.timeline-item {
    position: relative;
}

.timeline-line {
    position: absolute;
    left: -13px;
    top: 0;
    width: 2px;
    height: 100%;
    background: #0a4275;
}

.timeline-dot {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #0a4275;
    position: absolute;
    top: 8px;
    left: -20px;
}

.timeline-dot.success {
    background-color: #198754; /* Green */
}

.timeline-dot.warning {
    background-color: #ffc107; /* Yellow */
}

.timeline-dot.danger {
    background-color: #dc3545; /* Red */
}

.timeline-content{
  max-width:550px;
  padding:15px;
  border-radius:8px;
}
</style>
@endsection