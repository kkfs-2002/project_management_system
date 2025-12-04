<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Yearly Profit Report - {{ $year }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .subtitle {
            font-size: 18px;
            color: #666;
            margin-bottom: 5px;
        }
        .report-info {
            margin-bottom: 20px;
            text-align: center;
        }
        .summary-cards {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        .card {
            border: 1px solid #ddd;
            padding: 15px;
            width: 23%;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .card-title {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }
        .card-value {
            font-size: 18px;
            font-weight: bold;
        }
        .profit-positive {
            color: #28a745;
        }
        .profit-negative {
            color: #dc3545;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
            font-weight: bold;
        }
        td {
            border: 1px solid #dee2e6;
            padding: 8px;
        }
        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .month-row:hover {
            background-color: #f5f5f5;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #666;
            font-size: 10px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .page-break {
            page-break-before: always;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .section-title {
            background-color: #f8f9fa;
            padding: 10px;
            margin: 20px 0 10px 0;
            border-left: 4px solid #007bff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Yearly Profit Report</div>
        <div class="subtitle">Year {{ $year }}</div>
        <div class="report-info">
            Generated on: {{ $generatedDate }}
        </div>
    </div>

    <!-- Yearly Summary Section -->
    <div class="section-title">Yearly Summary</div>
    <div class="summary-cards">
        <div class="card">
            <div class="card-title">Total Projects</div>
            <div class="card-value">{{ $yearlyData->count() }}</div>
        </div>
        <div class="card">
            <div class="card-title">Total Revenue</div>
            <div class="card-value">Rs {{ number_format($yearlyData->sum('total_payment'), 2) }}</div>
        </div>
        <div class="card">
            <div class="card-title">Total Expenses</div>
            @php
                $totalExpenses = $yearlyData->sum('hosting_fee') + $yearlyData->sum('developer_fee');
            @endphp
            <div class="card-value">Rs {{ number_format($totalExpenses, 2) }}</div>
        </div>
        <div class="card">
            <div class="card-title">Yearly Profit</div>
            <div class="card-value {{ $yearlyData->sum('profit') >= 0 ? 'profit-positive' : 'profit-negative' }}">
                Rs {{ number_format($yearlyData->sum('profit'), 2) }}
            </div>
        </div>
    </div>

    <!-- Monthly Breakdown Section -->
    <div class="section-title">Monthly Breakdown</div>
    <table>
        <thead>
            <tr>
                <th>Month</th>
                <th>Projects</th>
                <th class="text-right">Total Payment</th>
                <th class="text-right">Expenses</th>
                <th class="text-right">Monthly Profit</th>
                <th class="text-right">Cumulative Profit</th>
                <th class="text-right">Profit Margin</th>
            </tr>
        </thead>
        <tbody>
            @php
                $cumulativeProfit = 0;
                $months = [
                    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                ];
            @endphp
            @for($month = 1; $month <= 12; $month++)
                @php
                    $monthData = $yearlyData->filter(function ($account) use ($year, $month) {
                        return \Carbon\Carbon::parse($account->project->start_date)->month == $month;
                    });
                    
                    $monthPayment = $monthData->sum('total_payment');
                    $monthExpenses = $monthData->sum('hosting_fee') + $monthData->sum('developer_fee');
                    $monthProfit = $monthPayment - $monthExpenses;
                    $profitMargin = $monthPayment > 0 ? ($monthProfit / $monthPayment) * 100 : 0;
                    $cumulativeProfit += $monthProfit;
                @endphp
                <tr class="month-row">
                    <td><strong>{{ $months[$month] }}</strong></td>
                    <td>{{ $monthData->count() }}</td>
                    <td class="text-right">Rs {{ number_format($monthPayment, 2) }}</td>
                    <td class="text-right">Rs {{ number_format($monthExpenses, 2) }}</td>
                    <td class="text-right {{ $monthProfit >= 0 ? 'profit-positive' : 'profit-negative' }}">
                        Rs {{ number_format($monthProfit, 2) }}
                    </td>
                    <td class="text-right {{ $cumulativeProfit >= 0 ? 'profit-positive' : 'profit-negative' }}">
                        Rs {{ number_format($cumulativeProfit, 2) }}
                    </td>
                    <td class="text-right {{ $profitMargin >= 0 ? 'profit-positive' : 'profit-negative' }}">
                        {{ number_format($profitMargin, 2) }}%
                    </td>
                </tr>
            @endfor
            
            <!-- Year Total -->
            <tr class="total-row">
                <td><strong>YEAR TOTAL</strong></td>
                <td><strong>{{ $yearlyData->count() }}</strong></td>
                <td class="text-right"><strong>Rs {{ number_format($yearlyData->sum('total_payment'), 2) }}</strong></td>
                <td class="text-right"><strong>Rs {{ number_format($totalExpenses, 2) }}</strong></td>
                <td class="text-right {{ $yearlyData->sum('profit') >= 0 ? 'profit-positive' : 'profit-negative' }}">
                    <strong>Rs {{ number_format($yearlyData->sum('profit'), 2) }}</strong>
                </td>
                <td class="text-right {{ $yearlyData->sum('profit') >= 0 ? 'profit-positive' : 'profit-negative' }}">
                    <strong>Rs {{ number_format($yearlyData->sum('profit'), 2) }}</strong>
                </td>
                @php
                    $yearlyProfitMargin = $yearlyData->sum('total_payment') > 0 
                        ? ($yearlyData->sum('profit') / $yearlyData->sum('total_payment')) * 100 
                        : 0;
                @endphp
                <td class="text-right {{ $yearlyProfitMargin >= 0 ? 'profit-positive' : 'profit-negative' }}">
                    <strong>{{ number_format($yearlyProfitMargin, 2) }}%</strong>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Project List Section -->
    <div class="page-break"></div>
    <div class="section-title">Project Details for {{ $year }}</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Project Name</th>
                <th>Month</th>
                <th class="text-right">Total Payment</th>
                <th class="text-right">Advance</th>
                <th class="text-right">Hosting Fee</th>
                <th class="text-right">Developer Fee</th>
                <th class="text-right">Profit</th>
                <th class="text-right">Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($yearlyData as $index => $account)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $account->project->name }}</td>
                <td>{{ \Carbon\Carbon::parse($account->project->start_date)->format('M') }}</td>
                <td class="text-right">Rs {{ number_format($account->total_payment, 2) }}</td>
                <td class="text-right">Rs {{ number_format($account->advance, 2) }}</td>
                <td class="text-right">Rs {{ number_format($account->hosting_fee, 2) }}</td>
                <td class="text-right">Rs {{ number_format($account->developer_fee, 2) }}</td>
                <td class="text-right {{ $account->profit >= 0 ? 'profit-positive' : 'profit-negative' }}">
                    Rs {{ number_format($account->profit, 2) }}
                </td>
                <td class="text-right">Rs {{ number_format($account->balance, 2) }}</td>
            </tr>
            @endforeach
            
            <!-- Total Row -->
            <tr class="total-row">
                <td colspan="3" class="text-right"><strong>TOTAL:</strong></td>
                <td class="text-right"><strong>Rs {{ number_format($yearlyData->sum('total_payment'), 2) }}</strong></td>
                <td class="text-right"><strong>Rs {{ number_format($yearlyData->sum('advance'), 2) }}</strong></td>
                <td class="text-right"><strong>Rs {{ number_format($yearlyData->sum('hosting_fee'), 2) }}</strong></td>
                <td class="text-right"><strong>Rs {{ number_format($yearlyData->sum('developer_fee'), 2) }}</strong></td>
                <td class="text-right {{ $yearlyData->sum('profit') >= 0 ? 'profit-positive' : 'profit-negative' }}">
                    <strong>Rs {{ number_format($yearlyData->sum('profit'), 2) }}</strong>
                </td>
                <td class="text-right"><strong>Rs {{ number_format($yearlyData->sum('balance'), 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Financial Analysis -->
    <div class="section-title">Financial Analysis</div>
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%; padding-right: 20px;">
                <h4>Key Metrics</h4>
                <table style="width: 100%;">
                    <tr>
                        <td><strong>Average Monthly Profit:</strong></td>
                        <td class="text-right">Rs {{ number_format($yearlyData->sum('profit') / 12, 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Average Project Value:</strong></td>
                        @php
                            $avgProjectValue = $yearlyData->count() > 0 
                                ? $yearlyData->sum('total_payment') / $yearlyData->count() 
                                : 0;
                        @endphp
                        <td class="text-right">Rs {{ number_format($avgProjectValue, 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Average Project Profit:</strong></td>
                        @php
                            $avgProjectProfit = $yearlyData->count() > 0 
                                ? $yearlyData->sum('profit') / $yearlyData->count() 
                                : 0;
                        @endphp
                        <td class="text-right">Rs {{ number_format($avgProjectProfit, 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Outstanding Balance:</strong></td>
                        <td class="text-right">Rs {{ number_format($yearlyData->sum('balance'), 2) }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%;">
                <h4>Expense Breakdown</h4>
                <table style="width: 100%;">
                    <tr>
                        <td><strong>Hosting Expenses:</strong></td>
                        <td class="text-right">Rs {{ number_format($yearlyData->sum('hosting_fee'), 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Developer Expenses:</strong></td>
                        <td class="text-right">Rs {{ number_format($yearlyData->sum('developer_fee'), 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total Expenses:</strong></td>
                        <td class="text-right">Rs {{ number_format($totalExpenses, 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Expense to Revenue Ratio:</strong></td>
                        @php
                            $expenseRatio = $yearlyData->sum('total_payment') > 0 
                                ? ($totalExpenses / $yearlyData->sum('total_payment')) * 100 
                                : 0;
                        @endphp
                        <td class="text-right">{{ number_format($expenseRatio, 2) }}%</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="footer">
        <p>Yearly Profit Report - {{ $year }}</p>
        <p>Generated by: {{ config('app.name', 'Laravel') }} | Page 2 of 2</p>
    </div>
</body>
</html>