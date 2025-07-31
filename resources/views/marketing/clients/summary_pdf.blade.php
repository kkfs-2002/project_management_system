<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Client Summary Report</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        .title { text-align: center; font-size: 18px; font-weight: bold; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 8px; text-align: center; }
    </style>
</head>
<body>
    <div class="title">Client Summary Report</div>

    <table>
        <thead>
            <tr>
                <th>Status</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Active</td>
                <td>{{ $active }}</td>
            </tr>
            <tr>
                <td>Inactive</td>
                <td>{{ $inactive }}</td>
            </tr>
            <tr>
                <td>Cancelled</td>
                <td>{{ $cancelled }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
