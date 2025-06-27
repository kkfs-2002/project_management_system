@extends('layouts.developer')
@section('content')
<h3><!-- {{ $dev->full_name }} – --> Task List</h3>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-hover">
  <thead>
    <tr>
      <th>#</th><th>Title</th><th>PM</th><th>Deadline</th><th>Status</th><th>Action</th>
    </tr>
  </thead>
  <tbody>
  @foreach($tasks as $task)
    <tr>
      <td>{{ $task->id }}</td>
      <td>{{ $task->title }}</td>
      <td>{{ $task->project_manager_name }}</td>
      <td>{{ $task->deadline }}</td>
      <td>{{ $task->status }}</td>
      <td>
        @if($task->status === 'Forwarded')
          <form action="{{ route('developer.tasks.complete', $task->id) }}" method="POST">
            @csrf
            <button class="btn btn-sm btn-warning">Mark Completed</button>
          </form>
        @else
          Submitted
        @endif
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
@endsection
