@extends('layouts.app')

@section('content')

<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #F5F5F5;
    }

    .container {
        padding: 30px;
        max-width: 800px;
        margin: 0 auto;
    }

    h3 {
        text-align: center;
        margin-bottom: 30px;
        color: #383838;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        font-weight: bold;
    }

    .btn-primary {
        background-color: #007BFF;
        border-color: #007BFF;
    }

    .btn-primary:hover {
        background-color: #0069D9;
        border-color: #0062CC;
    }

    .alert {
        margin-bottom: 20px;
    }
</style>

<div class="container">
    <h3>Assign Task (Superadmin)</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('superadmin.assign_task.store') }}">
        @csrf

        <!-- Project Manager Dropdown -->
        <div class="form-group">
            <label for="project_manager_id">Project Manager</label>
            <select name="project_manager_id" id="project_manager_id" class="form-control" required>
                <option value="">Select Project Manager</option>
                @foreach($projectManagers as $pm)
                    <option value="{{ $pm->id }}">{{ $pm->full_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Developer Dropdown -->
        <div class="form-group">
            <label for="developer_id">Developer</label>
            <select name="developer_id" id="developer_id" class="form-control" required>
                <option value="">Select Developer</option>
                @foreach($developers as $dev)
                    <option value="{{ $dev->id }}">{{ $dev->full_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Project Name -->
        <div class="form-group">
            <label for="project_name">Project Name</label>
            <input type="text" name="project_name" id="project_name" class="form-control" required>
        </div>

        <!-- Task Description -->
        <div class="form-group">
            <label for="task_description">Task Description</label>
            <textarea name="task_description" id="task_description" class="form-control" rows="4" required></textarea>
        </div>

        <!-- Deadline -->
        <div class="form-group">
            <label for="deadline">Deadline</label>
            <input type="datetime-local" name="deadline" id="deadline" class="form-control" required>
        </div>

        <!-- Priority -->
        <div class="form-group">
            <label for="priority">Priority</label>
            <select name="priority" id="priority" class="form-control" required>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Assign Task</button>
    </form>
</div>

@endsection
