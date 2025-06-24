@extends('layouts.projectmanager')
@section('content')
<h3>  Assigned Tasks</h3>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-striped">
  <thead>
    <tr>
      <th>#</th><th>Title</th><th>Developer</th><th>Deadline</th><th>Status</th><th>Action</th>
    </tr>
  </thead>
  <tbody>
  @foreach($tasks as $task)
    <tr>
      <td>{{ $task->id }}</td>
      <td>{{ $task->title }}</td>
      <td>{{ $task->developer_name }}</td>
      <td>{{ $task->deadline }}</td>
      <td>{{ $task->status }}</td>
      <td>
        @if($task->status === 'Assigned')
          <form action="{{ route('projectmanager.tasks.forward', $task->id) }}" method="POST">
            @csrf
            <button class="btn btn-sm btn-warning">Forward to Developer</button>
          </form>
        @else
          —
        @endif
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
@endsection
