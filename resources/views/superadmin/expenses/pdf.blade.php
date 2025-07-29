<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Monthly Expenses PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 13px; }
        .month-title { font-weight: bold; background: #f0f0f0; padding: 8px; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 5px; }
        th, td { border: 1px solid #ccc; padding: 5px; text-align: left; }
        .total { text-align: right; font-weight: bold; margin-top: 5px; }
    </style>
</head>
<body>
    <h2>Monthly Expenses - {{ \Carbon\Carbon::parse($selectedMonth)->format('Y') }}</h2>

    @foreach($expensesByMonth as $month => $monthExpenses)
        <div class="month-title">{{ $month }}</div>

        @if($monthExpenses->isEmpty())
            <p>No expenses found.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Amount (Rs)</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($monthExpenses as $expense)
                        <tr>
                            <td>{{ $expense->title }}</td>
                            <td>{{ $expense->description }}</td>
                            <td>{{ number_format($expense->amount, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($expense->expense_date)->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p class="total">Month Total: Rs. {{ number_format($monthExpenses->sum('amount'), 2) }}</p>
        @endif
    @endforeach

    <hr>
    <h4 style="text-align: right;">Grand Total: Rs. {{ number_format($total, 2) }}</h4>
</body>
</html>
