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

    .btn-success {
        background-color: #28a745;
        border: none;
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .alert {
        margin-bottom: 20px;
    }
</style>

<div class="container">
    <h3>My Tasks (Developer)</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>#</th>
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
                    <td>{{ $task->project_name }}</td>
                    <td>{{ $task->task_description }}</td>
                    <td>{{ \Carbon\Carbon::parse($task->deadline)->format('Y-m-d H:i') }}</td>
                    <td>{{ $task->priority }}</td>
                    <td>{{ $task->status }}</td>
                    <td>
                        @if($task->status == 'Forwarded')
                            <form method="POST" action="{{ route('developer.tasks.complete', $task->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-success">Mark as Completed</button>
                            </form>
                        @else
                            <span>N/A</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;">No tasks assigned yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


