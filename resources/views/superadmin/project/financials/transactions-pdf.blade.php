<!DOCTYPE html>
<html>
<head>
    <title>Project Transactions PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #001f4d; color: white; }
    </style>
</head>
<body>
    <h2>Project Financial Transactions - {{ $month }}</h2>

    <table>
        <thead>
            <tr>
                <th>Project Name</th>
                <th>Total</th>
                <th>Advance</th>
                <th>Credit</th>
                <th>Hosting</th>
                <th>Developer</th>
                <th>Profit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accounts as $acc)
                <tr>
                    <td>{{ $acc->project->name }}</td>
                    <td>Rs. {{ $acc->total_payment }}</td>
                    <td>Rs. {{ $acc->advance }}</td>
                    <td>Rs. {{ $acc->credit }}</td>
                    <td>Rs. {{ $acc->hosting_fee }}</td>
                    <td>Rs. {{ $acc->developer_fee }}</td>
                    <td>Rs. {{ $acc->profit }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>