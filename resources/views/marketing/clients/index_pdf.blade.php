<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Client List PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>

    <h2 style="text-align: center;">Client List {{ $month ? 'for ' . \Carbon\Carbon::parse($month)->format('F Y') : '' }}</h2>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Contact</th>
                <th>Project</th>
                <th>Type</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Reminder</th>
                <th>Note</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->contact_number }}</td>
                    <td>{{ $client->project_name }}</td>
                    <td>{{ $client->project_type }}</td>
                    <td>{{ $client->payment_status }}</td>
                    <td>{{ ucfirst($client->status) }}</td>
                    <td>{{ $client->reminder_date ? \Carbon\Carbon::parse($client->reminder_date)->format('M d, Y') : '-' }}</td>
                    <td>{{ $client->note }}</td>
                    <td>{{ $client->created_at->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="9">No clients found.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
