@extends('layouts.app')
@section('content')

<h3>All Tasks</h3>
<!-- Filter by Month and Status -->
<form method="GET" action="{{ route('superadmin.tasks') }}" class="mb-3">
    <div class="row g-3 align-items-end">

        <div class="col-md-3">
            <label for="month" class="form-label">Filter by Month:</label>
            <input type="month" id="month" name="month" class="form-control" value="{{ request('month') }}">
        </div>

        <div class="col-md-3">
            <label for="status" class="form-label">Filter by Status:</label>
            <select name="status" id="status" class="form-select">
                <option value="">-- All --</option>
                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
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

<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>Title</th>
      <th>Developer</th>
      <th>Project Manager</th>
      <th>Deadline</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    @forelse($tasks as $task)
      <tr>
        <td>{{ $task->id }}</td>
        <td>{{ $task->title }}</td>
        <td>{{ $task->developer_name }}</td>
        <td>{{ $task->project_manager_name }}</td>
        <td>{{ \Carbon\Carbon::parse($task->deadline)->format('Y-m-d') }}</td>
        <td>{{ $task->status }}</td>
      </tr>
    @empty
      <tr>
        <td colspan="6" class="text-center">No tasks found for selected month.</td>
      </tr>
    @endforelse
  </tbody>
</table>

@endsection
