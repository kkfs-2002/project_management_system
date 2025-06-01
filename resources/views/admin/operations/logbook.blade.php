@extends('layouts.admin')

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

    h2, h3 {
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
        background-color:#d4af37;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        transition: 0.3s;
    }

    button:hover {
        background-color: #005f9e;
    }

    label {
        font-weight: 600;
        margin-top: 10px;
        display: block;
    }
</style>

<div class="container">
    <h3 class="mb-4"> Developer Task Logbook</h3>

    <form method="POST" action="{{ url('admin/operations/logbook') }}">
        @csrf

        <h4>1. Logbook Entry</h4>

        <div class="form-group">
            <label>Project Manager</label>
            <select name="project_manager_id" class="form-control" required>
                <option value="">Select Manager</option>
                @foreach($projectManagers as $pm)
                    <option value="{{ $pm->id }}">{{ $pm->full_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Developer Name</label>
            <select name="developer_id" class="form-control" required>
                <option value="">Select Developer</option>
                @foreach($developers as $dev)
                    <option value="{{ $dev->id }}">{{ $dev->full_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Date</label>
            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>

        <div class="form-group">
            <label>Project Name</label>
            <input type="text" name="project_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Task Summary</label>
            <textarea name="task_summary" class="form-control" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label>Time Spent (hrs)</label>
            <input type="number" name="time_spent" class="form-control" step="0.1" required>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="task_status" class="form-control" required>
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
            </select>
        </div>

        <div class="form-group">
            <label>Remarks</label>
            <textarea name="remarks" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit">Save Log</button>
    </form>
</div>

@endsection
