@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Project Finance</h2>

    <!-- Filter by Month -->
    <form method="GET" class="mb-4">
        <label>Select Month:</label>
        <input type="month" name="month" value="{{ $month }}" required>
        <button class="btn btn-secondary">Filter</button>
        <a href="{{ route('superadmin.project.create') }}" class="btn btn-success float-end">➕ Add Project</a>
    </form>

    @forelse($projects as $project)
        <div class="card mb-3 shadow-sm" style="border-left: 5px solid #4e73df;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">{{ $project->name }}</h5>
                    <small class="text-muted">{{ $project->type }}</small>
                </div>
                <a href="{{ route('superadmin.project.create', ['project_id' => $project->id]) }}" class="btn btn-outline-primary">➕ Add Financials</a>
            </div>
        </div>
    @empty
        <p>No projects found for this month.</p>
    @endforelse
</div>
@endsection
