@extends('layouts.projectmanager')

@section('content')

<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #F5F5F5;
    }

    .container {
        padding: 30px;
        max-width: 1100px;
        margin: 0 auto;
    }

    h3 {
        text-align: center;
        margin-bottom: 30px;
        color: #383838;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: #ffffff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    th, td {
        padding: 14px 18px;
        border-bottom: 1px solid #eee;
        text-align: left;
        font-size: 14px;
    }

    th {
        background-color: #f0f8ff;
        font-weight: bold;
        color: #333;
    }

    tr:hover {
        background-color: #fafafa;
    }

    .btn {
        padding: 6px 12px;
        font-size: 14px;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-primary {
        background-color: #007BFF;
        border: none;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0069D9;
    }

    .alert {
        margin-bottom: 20px;
    }
</style>

<div class="container">
    <h3>My Assigned Tasks (Project Manager)</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Developer</th>
                <th>Date</th>
                <th>Project</th>
                <th>Task Description</th>
                <th>Deadline</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $index => $task)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $task->developer->full_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($task->date)->format('Y-m-d') }}</td>
                    <td>{{ $task->project_name }}</td>
                    <td>{{ $task->task_description }}</td>
                    <td>{{ \Carbon\Carbon::parse($task->deadline)->format('Y-m-d H:i') }}</td>
                    <td>{{ $task->priority }}</td>
                    <td>{{ $task->status }}</td>
                    <td>
                        @if($task->status == 'Pending')
                            <form method="POST" action="{{ route('projectmanager.tasks.forward', $task->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-primary">Forward to Developer</button>
                            </form>
                        @else
                            <span>N/A</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align:center;">No tasks assigned yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
