@extends('layouts.app')

@section('content')
<div class="container">
    <h3>All Assigned Tasks</h3>

    <!-- Filter by Month and Status -->
    <form method="GET" action="{{ route('superadmin.tasks') }}" class="mb-4">
        <div class="row g-3 align-items-end">

            <div class="col-md-3">
                <label for="month" class="form-label">Filter by Month</label>
                <input type="month" id="month" name="month" class="form-control" value="{{ request('month') }}">
            </div>

            <div class="col-md-3">
                <label for="status" class="form-label">Filter by Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">-- All --</option>
                    <option value="Pending"   {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Forwarded" {{ request('status') == 'Forwarded' ? 'selected' : '' }}>Forwarded</option>
                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('superadmin.tasks') }}" class="btn btn-secondary">Reset</a>
            </div>

        </div>
    </form>

    <!-- Task Table -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Project</th>
                <th>Title</th>
                <th>Developer</th>
                <th>Project Manager</th>
                <th>Start Date</th>
                <th>Deadline</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
                <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->project->name ?? 'N/A' }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->developer_name }}</td>
                    <td>{{ $task->project_manager_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($task->start_date)->format('Y-m-d') }}</td>
                    <td>{{ \Carbon\Carbon::parse($task->deadline)->format('Y-m-d') }}</td>
                    <td>
                        <span class="badge bg-{{ $task->status === 'Completed' ? 'success' : ($task->status === 'Forwarded' ? 'info' : 'warning') }}">
                            {{ $task->status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No tasks found for selected filters.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
