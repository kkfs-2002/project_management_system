<!DOCTYPE html>
<html>
<head>
    <title>Project Transactions</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #000;
            line-height: 1.6;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #001f4d;
            margin-bottom: 5px;
        }

        .divider {
            border-top: 1px dashed #444;
            margin: 15px 0;
        }
    </style>
</head>
<body>

    <div class="section-title">Project Financial Transactions - {{ $monthLabel }}</div>
    <div><strong>Generated Date:</strong> {{ $generatedDate }}</div>

    @if($accounts->isEmpty())
        <p>No transactions available for this month.</p>
    @else
        @foreach($accounts as $acc)
            <div class="divider"></div>
            <p>
                <strong>Project Name:</strong> {{ $acc->project->name }}<br>
                <strong>Type:</strong> {{ $acc->project->type }}<br>
                <strong>Total Payment:</strong> Rs. {{ number_format($acc->total_payment, 2) }}<br>
                <strong>Advance:</strong> Rs. {{ number_format($acc->advance, 2) }}<br>
                <strong>Credit:</strong> Rs. {{ number_format($acc->credit, 2) }}<br>
                <strong>Hosting Fee:</strong> Rs. {{ number_format($acc->hosting_fee, 2) }}<br>
                <strong>Developer Fee:</strong> Rs. {{ number_format($acc->developer_fee, 2) }}<br>
                <strong>Profit:</strong> Rs. {{ number_format($acc->profit, 2) }}
            </p>
        @endforeach
        <div class="divider"></div>
    @endif

</body>
</html>