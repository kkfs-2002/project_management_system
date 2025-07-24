@extends('layouts.developer')

@section('content')
<div class="container">
    <h3>Tasks for Project: <strong>{{ $project->name }}</strong></h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Filter by status -->
    <form method="GET" class="mb-3">
        <div class="row g-2">
            <div class="col-md-3">
                <label for="status" class="form-label">Filter by Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">-- All --</option>
                    <option value="Pending"   {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Forwarded" {{ request('status') == 'Forwarded' ? 'selected' : '' }}>Forwarded</option>
                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <div class="col-md-3 align-self-end">
                <button type="submit" class="btn btn-primary">Apply</button>
                <a href="{{ route('developer.projects.tasks', $project->id) }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
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
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ \Carbon\Carbon::parse($task->start_date)->format('Y-m-d') }}</td>
                    <td>{{ \Carbon\Carbon::parse($task->deadline)->format('Y-m-d') }}</td>
                    <td>
                        <span class="badge bg-{{ $task->status === 'Completed' ? 'success' : ($task->status === 'Forwarded' ? 'info' : 'warning') }}">
                            {{ $task->status }}
                        </span>
                    </td>
                    <td>
                        @if($task->status !== 'Completed')
                            <form method="POST" action="{{ route('developer.tasks.complete', $task->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Mark this task as completed?')">
                                    Mark Completed
                                </button>
                            </form>
                        @else
                            <span class="text-muted">Completed</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">No tasks found for this project.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
