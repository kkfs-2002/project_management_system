@extends('layouts.developer')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h2 class="text-center">Developer Dashboard</h2>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h5>Your Tasks</h5>
                <p class="fs-4">{{ $totalTasks }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h5>Completed</h5>
                <p class="fs-4">{{ $completedTasks }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h5>Pending</h5>
                <p class="fs-4">{{ $pendingTasks }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
