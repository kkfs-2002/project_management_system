<!DOCTYPE html>
<html>
<head>
    <title>Monthly Client Report</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Client Report - {{ $month }}</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Project</th>
                <th>Type</th>
                <th>Tech</th>
                <th>Payment</th>
                <th>Reminder</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
            <tr>
                <td>{{ $client->name }}</td>
                <td>{{ $client->project_name }}</td>
                <td>{{ $client->project_type }}</td>
                <td>{{ $client->technology }}</td>
                <td>{{ $client->payment_status }}</td>
                <td>{{ $client->reminder_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
