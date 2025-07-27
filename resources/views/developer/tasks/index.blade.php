@extends('layouts.developer')

@section('content')
<style>
    .task-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .task-table th, .task-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }
    .task-table th {
        background-color: #e6f2fa;
        color: rgba(0, 0, 0, 0.75);
        text-transform: uppercase;
        font-weight: 600;
    }
    .task-table tbody tr:hover {
        background-color: #f1faff;
    }

    .badge {
        padding: 0.35em 0.65em;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 0.375rem;
        color: #fff;
        display: inline-block;
        text-align: center;
        min-width: 80px;
    }
    .badge.bg-success { background-color: #28a745; }
    .badge.bg-info { background-color: #17a2b8; }
    .badge.bg-warning { background-color: #ffc107; color: #212529; }
</style>

<div class="container">
    <h3>Tasks</h3>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter Form -->
    <form method="GET" action="{{ route('developer.tasks.index') }}" class="mb-4">
        <div class="row g-3 align-items-end">

            <div class="col-md-3">
                <label for="project_id" class="form-label">Filter by Project</label>
                <select name="project_id" id="project_id" class="form-select">
                    <option value="">All Projects</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="status" class="form-label">Filter by Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="Forwarded" {{ request('status') == 'Forwarded' ? 'selected' : '' }}>Forwarded</option>
                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="month" class="form-label">Filter by Month</label>
                <input type="month" name="month" id="month" value="{{ request('month') }}" class="form-control">
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('developer.tasks.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <!-- Task Table -->
    <table class="task-table">
        <thead>
            <tr>
                
                <th>Project</th>
                <th>Title</th>
                <th>Start Date</th>
                <th>Deadline</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
                <tr>
                    
                    <td>{{ $task->project->name ?? 'N/A' }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ \Carbon\Carbon::parse($task->start_date)->format('Y-m-d') }}</td>
                    <td>{{ \Carbon\Carbon::parse($task->deadline)->format('Y-m-d') }}</td>
                    <td>
                        <span class="badge bg-{{ $task->status === 'Completed' ? 'success' : ($task->status === 'Forwarded' ? 'info' : 'warning') }}">
                            {{ $task->status }}
                        </span>
                    </td>
                    <td>
                        @if($task->status === 'Forwarded')
                            <form action="{{ route('developer.tasks.complete', $task->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    Mark as Completed
                                </button>
                            </form>
                        @else
                            <span class="text-muted">Already Completed</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No tasks found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
