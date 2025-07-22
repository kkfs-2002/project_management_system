@extends('layouts.app')

@section('title', 'Assign Task')

@section('content')
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f5f7fa;
        margin: 0;
        padding: 0;
    }

    .assign-task-wrapper {
        background-color: #ffffff;
        border-radius: 10px;
        padding: 40px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        max-width: 850px;
        margin: 50px auto;
        color: #343a40;
    }

    .assign-task-wrapper h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #1c1c1c;
        font-weight: 600;
    }

    .assign-task-wrapper label {
        font-weight: 500;
        margin-top: 15px;
        display: block;
        color: #333;
    }

    .assign-task-wrapper input,
    .assign-task-wrapper select,
    .assign-task-wrapper textarea {
        width: 100%;
        padding: 10px 12px;
        margin-top: 5px;
        border-radius: 6px;
        border: 1px solid #ced4da;
        font-size: 14px;
        background-color: #fdfdfd;
        box-sizing: border-box;
    }

    .assign-task-wrapper textarea {
        resize: vertical;
    }

    .assign-task-wrapper button {
        margin-top: 30px;
        width: 100%;
        padding: 14px;
        background-color: #0056b3;
        color: #ffffff;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 500;
        transition: background-color 0.3s ease-in-out;
    }

    .assign-task-wrapper button:hover {
        background-color: #003f88;
    }

    .alert-success {
        background: #e7f8ef;
        color: #146c43;
        padding: 15px;
        border-left: 4px solid #198754;
        margin-bottom: 25px;
        border-radius: 5px;
    }
</style>

<div class="assign-task-wrapper">
    <h2>Assign New Task</h2>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        <label for="project_id">Project</label>
        <select name="project_id" id="project_id" required>
            <option value="">-- Choose Project --</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->name }}</option>
            @endforeach
        </select>

        <label for="project_manager_id">Project Manager</label>
        <select name="project_manager_id" id="project_manager_id" required>
            <option value="">-- Choose Project Manager --</option>
            @foreach($projectManagers as $pm)
                <option value="{{ $pm->id }}">{{ $pm->full_name }}</option>
            @endforeach
        </select>

        <label for="developer_id">Developer</label>
        <select name="developer_id" id="developer_id" required>
            <option value="">-- Choose Developer --</option>
            @foreach($developers as $dev)
                <option value="{{ $dev->id }}">{{ $dev->full_name }}</option>
            @endforeach
        </select>

        <label for="title">Task Title</label>
        <input type="text" name="title" id="title" required>

        <label for="description">Task Description</label>
        <textarea name="description" id="description" rows="4" required></textarea>

        <label for="start_date">Start Date</label>
        <input type="date" name="start_date" id="start_date" required>

        <label for="deadline">End Date</label>
        <input type="date" name="deadline" id="deadline" required>

        <button type="submit">Assign Task</button>
    </form>
</div>
@endsection
