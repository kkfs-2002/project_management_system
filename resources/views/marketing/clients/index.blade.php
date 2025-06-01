<!DOCTYPE html>
<html>
<head>
    <title>Client List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f8ff;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #007acc;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .top-bar a {
            padding: 10px 20px;
            background: #007acc;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #e6f2ff;
            color: #007acc;
        }
        .btn-edit, .btn-delete {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-edit {
            background-color: #00aaff;
            color: white;
        }
        .btn-delete {
            background-color: #ff4d4d;
            color: white;
        }
        .btn-delete:hover {
            background-color: #e60000;
        }
        .btn-edit:hover {
            background-color: #008ecc;
        }
        .actions {
            display: flex;
            gap: 8px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Client List</h2>
    <a href="{{ route('marketing.dashboard') }}" class="text-blue-600 font-medium hover:underline">← Dashboard</a>
    <div class="top-bar">
        <div></div>
        <a href="{{ route('clients.create') }}">+ Add New Client</a>
    </div>

    @if(session('success'))
        <div style="color: green; font-weight: bold; margin-bottom: 10px;">{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Contact</th>
                <th>Project</th>
                <th>Type</th>
                <th>Technology</th>
                <th>Reminder Date</th>
                <th>Cost (LKR)</th>
                <th>Status</th>
                <th>note</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                <tr class="hover:bg-blue-50">
                    <td>{{ $client->client_name }}</td>
                    <td>{{ $client->contact_number }}</td>
                    <td>{{ $client->project_name }}</td>
                    <td>{{ $client->project_type }}</td>
                    <td>{{ $client->technology }}</td>
                    <td>{{ $client->reminder_date }}</td>
                    <td>{{ $client->cost ? number_format($client->cost, 2) : '-' }}</td>
                    <td>
                        @if($client->status === 'success')
                            <span style="color: green; font-weight: bold;">Success</span>
                        @else
                            <span style="color: #e6ac00; font-weight: bold;">Pending</span>
                        @endif
                    </td>
                    <td>{{ $client->note }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('clients.edit', $client->id) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this client?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
