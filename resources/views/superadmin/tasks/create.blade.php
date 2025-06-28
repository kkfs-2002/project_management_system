@extends('layouts.app')

@section('content')

<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #F5F5F5;
    }

    form {
        background-color: #ffffff;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        max-width: 900px;
        margin: 0 auto;
        color: #333;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #383838;
    }

    h4 {
        margin-top: 30px;
        color: #005a99;
        border-bottom: 2px solid #cce7ff;
        padding-bottom: 5px;
    }

    input, select, textarea {
        display: block;
        width: 100%;
        padding: 10px 12px;
        margin: 10px 0;
        border-radius: 6px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        font-size: 14px;
    }

    button {
        margin-top: 30px;
        width: 100%;
        padding: 12px;
        background-color: #d4af37;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        transition: 0.3s;
    }

    button:hover {
        background-color: #005f9e;
    }

    .alert-success {
        color: green;
        background: #e6ffed;
        padding: 10px;
        border-left: 4px solid green;
        margin-bottom: 15px;
    }

    label {
        font-weight: 600;
        margin-top: 10px;
        display: block;
    }
</style>

<div class="container">
    <h2 class="my-4">Assign New Task</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        <h4>Task Assignment</h4>

        <div class="form-group">
            <label>Developer</label>
            <select name="developer_id" class="form-control" required>
                <option value="">-- Choose Developer --</option>
                @foreach($developers as $dev)
                    <option value="{{ $dev->id }}">{{ $dev->full_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Project Manager</label>
            <select name="project_manager_id" class="form-control" required>
                <option value="">-- Choose Project Manager --</option>
                @foreach($projectManagers as $pm)
                    <option value="{{ $pm->id }}">{{ $pm->full_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Deadline</label>
            <input type="date" name="deadline" class="form-control" required>
        </div>

        <h4>Task Details</h4>

        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Task Description</label>
            <textarea name="description" rows="4" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-secondary">Assign Task</button>
    </form>
</div>

@endsection
