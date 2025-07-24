@extends('layouts.app')

@section('content')
<div class="container py-4">

<!-- About Section with Typing -->
<div class="mb-5 position-relative">
    <img src="{{ asset('images/company-bg.jpeg') }}" class="img-fluid w-100" style="max-height:350px; object-fit: cover; filter: brightness(0.5);" alt="Company Background">

    <div class="position-absolute top-50 start-50 translate-middle bg-white bg-opacity-75 p-4 rounded shadow" style="max-width: 700px;">
        <h3 id="typingText" class="fw-bold mb-2 text-primary"></h3>
        <p class="mb-0 text-dark">We specialize in delivering cutting-edge software and digital solutions that drive results. From enterprise web apps to mobile platforms, we empower businesses to scale and succeed.</p>
    </div>
</div>

<!-- Animated Stats Section -->
<div class="row text-center mb-5">
    <div class="col-md-4 mx-auto">
        <div class="p-4 bg-white border border-primary rounded shadow-sm h-100 transition" style="transition: all 0.3s ease;">
            <h2 id="employeeCount" class="text-primary fw-bold">0</h2>
            <p class="text-muted mb-0">Total Employees</p>
        </div>
    </div>
    <div class="col-md-4 mx-auto mt-4 mt-md-0">
        <div class="p-4 bg-white border border-success rounded shadow-sm h-100 transition" style="transition: all 0.3s ease;">
            <h2 id="projectCount" class="text-success fw-bold">0</h2>
            <p class="text-muted mb-0">Total Projects</p>
        </div>
    </div>
</div>


    <!-- Header with Icons -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark">
            <i class="fas fa-stream me-2 text-primary"></i> Project Timeline Overview
        </h4>

        <div class="d-flex align-items-center">
            <!-- View toggle buttons -->
            <button class="btn btn-outline-primary me-2" id="timelineViewBtn"><i class="fas fa-stream"></i></button>
            <button class="btn btn-outline-primary me-2" id="gridViewBtn"><i class="fas fa-th"></i></button>
            
                    <!-- Sort Dropdown -->
        <div class="dropdown me-2">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-sort me-1"></i> Sort
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('superadmin.dashboard', array_merge(request()->query(), ['sort' => 'asc'])) }}">Deadline: Soonest</a></li>
                <li><a class="dropdown-item" href="{{ route('superadmin.dashboard', array_merge(request()->query(), ['sort' => 'desc'])) }}">Deadline: Latest</a></li>
            </ul>
        </div>

            <!-- Filter by type -->
            <div class="dropdown me-2">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item" href="{{ route('superadmin.dashboard') }}">All</a></li>
                    @foreach($projectTypes as $type)
                        <li><a class="dropdown-item" href="{{ route('superadmin.dashboard', ['type' => $type]) }}">{{ $type }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Timeline View -->
    <div id="timelineView">
        @if($timelineProjects->isEmpty())
            <div class="alert alert-warning">No projects found.</div>
        @else
            <div class="timeline-wrapper">
                @foreach($timelineProjects as $index => $project)
                    <div class="timeline-item mb-5 d-flex">
                        <div class="timeline-line"></div>
                        <div class="timeline-dot {{ $project['color'] }}">{{ $index + 1 }}</div>

                        <div class="timeline-content card shadow-sm p-3" style="width:70%; max-width:800px;">
                            <h6 class="fw-bold">{{ $project['name'] }}</h6>
                            <div class="text-muted small mb-2">
                                <i class="fas fa-calendar-alt me-1"></i> {{ $project['start_date'] }}
                                &nbsp; → &nbsp;
                                <i class="fas fa-flag-checkered me-1"></i> {{ $project['deadline'] }}
                            </div>

                            <div class="text-left py-1 mt-1 rounded alert-success" style="background-color: {{$project['color'] === 'success' ? 'rgba(25,135,84,0.15)' : ($project['color'] === 'warning' ? 'rgba(255,193,7,0.15)' : 'rgba(220,53,69,0.15)')}};box-shadow: 0 0 6px rgba(0, 0, 0, 0.05); font-size:14px;">
                              <strong>{{ 100 - $project['completion'] }}%</strong> Work Remaining
                            </div>

                            <div class="progress mb-2 mt-2" style="height: 8px;">
                                <div class="progress-bar bg-{{ $project['color'] }}" style="width: {{ $project['completion'] }}%;">
                                </div>
                            </div>

                        

                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Grid View -->
    <div id="gridView" class="row" style="display: none;">
        @foreach($timelineProjects as $project)
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $project['name'] }}</h5>
                        <p class="text-muted small mb-1">
                            <i class="fas fa-calendar-alt me-1"></i> {{ $project['start_date'] }} → {{ $project['deadline'] }}
                        </p>

                        <div class="progress mb-2" style="height: 6px;">
                            <div class="progress-bar bg-{{ $project['color'] }}" style="width: {{ $project['completion'] }}%;"></div>
                        </div>

                        <div class="text-left py-1 mt-1 rounded alert-success" style="background-color: {{$project['color'] === 'success' ? 'rgba(25,135,84,0.15)' : ($project['color'] === 'warning' ? 'rgba(255,193,7,0.15)' : 'rgba(220,53,69,0.15)')}};box-shadow: 0 0 6px rgba(0, 0, 0, 0.05); font-size:14px;">
                              <strong>{{ 100 - $project['completion'] }}%</strong> Work Remaining
                            </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>

<!-- Styles -->
<style>
.timeline-wrapper {
    position: relative;
    margin-left: 30px;
    padding-left: 30px;
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
    width: 24px;
    height: 24px;
    border-radius: 50%;
    color: white;
    font-size: 0.8rem;
    text-align: center;
    line-height: 24px;
    position: absolute;
    top: 40px;
    left: -24px;
    font-weight: bold;
}

.timeline-dot.success { background-color: #198754; }
.timeline-dot.warning { background-color: #ffc107; }
.timeline-dot.danger { background-color: #dc3545; }
</style>

<!-- View Switcher Script -->
<script>
document.getElementById('timelineViewBtn').addEventListener('click', () => {
    document.getElementById('timelineView').style.display = 'block';
    document.getElementById('gridView').style.display = 'none';
});

document.getElementById('gridViewBtn').addEventListener('click', () => {
    document.getElementById('timelineView').style.display = 'none';
    document.getElementById('gridView').style.display = 'flex';
});
</script>

<!-- Counter + Typing Script -->
<script>
    function animateCounter(id, endValue, duration = 1200) {
        const element = document.getElementById(id);
        const startTime = performance.now();

        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const value = Math.floor(progress * endValue);
            element.innerText = value.toLocaleString();

            if (progress < 1) {
                requestAnimationFrame(update);
            }
        }

        requestAnimationFrame(update);
    }

    function typeWriter(text, elementId, speed = 50) {
        let i = 0;
        const element = document.getElementById(elementId);
        function type() {
            if (i < text.length) {
                element.innerHTML += text.charAt(i);
                i++;
                setTimeout(type, speed);
            }
        }
        type();
    }

    document.addEventListener('DOMContentLoaded', () => {
        animateCounter("employeeCount", {{ $employeeCount }});
        animateCounter("projectCount", {{ $projectCount }});
        typeWriter("Welcome to NetIT Solutions....!", "typingText");
    });
</script>


@endsection