@extends('layouts.app')
@section('content')
<h3>All Tasks</h3>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>Title</th>
      <th>Developer</th>
      <th>Project Manager</th>
      <th>Deadline</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    @foreach($tasks as $task)
      <tr>
        <td>{{ $task->id }}</td>
        <td>{{ $task->title }}</td>
        <td>{{ $task->developer_name }}</td>
        <td>{{ $task->project_manager_name }}</td>
        <td>{{ $task->deadline }}</td>
        <td>{{ $task->status }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection
