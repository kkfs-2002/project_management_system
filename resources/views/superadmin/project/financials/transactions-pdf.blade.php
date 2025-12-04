<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Project Transactions - {{ $monthLabel }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h2 { color: #333; }
        .summary-box { 
            background-color: #f8f9fa; 
            padding: 15px; 
            border-radius: 5px; 
            margin-bottom: 20px;
        }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #343a40; color: white; padding: 10px; }
        td { padding: 8px; border-bottom: 1px solid #dee2e6; }
        .total-row { background-color: #e9ecef; font-weight: bold; }
        .profit { color: #28a745; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Project Transactions Report</h2>
        <h4>{{ $monthLabel }}</h4>
        <p>Generated on: {{ $generatedDate }}</p>
    </div>

    <!-- Profit Summary -->
    @php
        $monthlyProfit = $accounts->sum('profit');
        $month = \Carbon\Carbon::parse($monthLabel)->format('Y-m');
        $year = \Carbon\Carbon::parse($monthLabel)->year;
        $yearlyAccounts = \App\Models\ProjectAccount::with('project')
            ->whereHas('project', function ($query) use ($year) {
                $query->whereYear('start_date', $year);
            })->get();
        $yearlyProfit = $yearlyAccounts->sum('profit');
    @endphp

    <div class="summary-box">
        <h4>Profit Summary</h4>
        <table>
            <tr>
                <td><strong>Monthly Profit ({{ $monthLabel }}):</strong></td>
                <td class="profit">LKR {{ number_format($monthlyProfit, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Yearly Profit ({{ $year }}):</strong></td>
                <td class="profit">LKR {{ number_format($yearlyProfit, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Average Monthly Profit:</strong></td>
                <td>LKR {{ number_format($yearlyProfit / 12, 2) }}</td>
            </tr>
        </table>
    </div>

    <!-- Transactions Table -->
    <h4>Transaction Details</h4>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Project Name</th>
                <th>Type</th>
                <th>Total Payment</th>
                <th>Advance</th>
                <th>Hosting Fee</th>
                <th>Developer Fee</th>
                <th>Profit</th>
                <th>Balance</th>
                <th>Renewal Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accounts as $account)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $account->project->name }}</td>
                <td>{{ $account->project->type }}</td>
                <td>LKR {{ number_format($account->total_payment, 2) }}</td>
                <td>LKR {{ number_format($account->advance, 2) }}</td>
                <td>LKR {{ number_format($account->hosting_fee, 2) }}</td>
                <td>LKR {{ number_format($account->developer_fee, 2) }}</td>
                <td class="profit">LKR {{ number_format($account->profit, 2) }}</td>
                <td>LKR {{ number_format($account->balance, 2) }}</td>
                <td>{{ $account->renewal_date->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
        @if($accounts->count() > 0)
        <tfoot>
            <tr class="total-row">
                <td colspan="7" align="right"><strong>Monthly Total Profit:</strong></td>
                <td class="profit"><strong>LKR {{ number_format($monthlyProfit, 2) }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
        @endif
    </table>
</body>
</html>