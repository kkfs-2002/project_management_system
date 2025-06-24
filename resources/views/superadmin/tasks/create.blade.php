@extends('layouts.app')
@section('content')
<h3>Assign New Task</h3>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('tasks.store') }}" method="POST" class="mt-4">
  @csrf

  <div class="form-row">
    <div class="form-group col-md-4">
      <label>Developer</label>
      <select name="developer_id" class="form-control" required>
        <option value="">-- choose --</option>
        @foreach($developers as $dev)
          <option value="{{ $dev->id }}">{{ $dev->full_name }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group col-md-4">
      <label>Project Manager</label>
      <select name="project_manager_id" class="form-control" required>
        <option value="">-- choose --</option>
        @foreach($projectManagers as $pm)
          <option value="{{ $pm->id }}">{{ $pm->full_name }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group col-md-4">
      <label>Deadline</label>
      <input type="date" name="deadline" class="form-control" required>
    </div>
  </div>

  <div class="form-group">
    <label>Title</label>
    <input type="text" name="title" class="form-control" required>
  </div>

  <div class="form-group">
    <label>Task Description</label>
    <textarea name="description" rows="4" class="form-control" required></textarea>
  </div>

  <button class="btn btn-secondary">Assign Task</button>
</form>
@endsection
