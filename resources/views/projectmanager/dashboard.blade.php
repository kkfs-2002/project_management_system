@extends('layouts.projectmanager')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h2 class="text-center">Project Manager Dashboard</h2>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h5>Total Assigned Tasks</h5>
                <p class="fs-4">{{ $totalTasks }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h5>Forwarded Tasks</h5>
                <p class="fs-4">{{ $forwardedTasks }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h5>Completed Tasks</h5>
                <p class="fs-4">{{ $completedTasks }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
