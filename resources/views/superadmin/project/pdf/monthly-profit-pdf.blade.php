<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Monthly Profit Report - {{ $month }}</title>
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
        }
        .card {
            border: 1px solid #ddd;
            padding: 15px;
            width: 23%;
            text-align: center;
            border-radius: 5px;
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
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Monthly Profit Report</div>
        <div class="subtitle">{{ $month }}</div>
        <div class="report-info">
            Generated on: {{ $generatedDate }}
        </div>
    </div>

    <!-- Summary Section -->
    <div class="summary-section">
        <h3>Summary</h3>
        <div class="summary-cards">
            <div class="card">
                <div class="card-title">Total Projects</div>
                <div class="card-value">{{ $monthlyData->count() }}</div>
            </div>
            <div class="card">
                <div class="card-title">Total Revenue</div>
                <div class="card-value">Rs {{ number_format($monthlyData->sum('total_payment'), 2) }}</div>
            </div>
            <div class="card">
                <div class="card-title">Total Expenses</div>
                @php
                    $totalExpenses = $monthlyData->sum('hosting_fee') + $monthlyData->sum('developer_fee');
                @endphp
                <div class="card-value">Rs {{ number_format($totalExpenses, 2) }}</div>
            </div>
            <div class="card">
                <div class="card-title">Monthly Profit</div>
                <div class="card-value {{ $monthlyData->sum('profit') >= 0 ? 'profit-positive' : 'profit-negative' }}">
                    Rs {{ number_format($monthlyData->sum('profit'), 2) }}
                </div>
            </div>
        </div>
    </div>

    <!-- Projects Details Table -->
    <h3>Project Details</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Project Name</th>
                <th>Type</th>
                <th class="text-right">Total Payment</th>
                <th class="text-right">Advance</th>
                <th class="text-right">Hosting Fee</th>
                <th class="text-right">Developer Fee</th>
                <th class="text-right">Profit</th>
                <th class="text-right">Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($monthlyData as $index => $account)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $account->project->name }}</td>
                <td>{{ $account->project->type }}</td>
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
                <td class="text-right"><strong>Rs {{ number_format($monthlyData->sum('total_payment'), 2) }}</strong></td>
                <td class="text-right"><strong>Rs {{ number_format($monthlyData->sum('advance'), 2) }}</strong></td>
                <td class="text-right"><strong>Rs {{ number_format($monthlyData->sum('hosting_fee'), 2) }}</strong></td>
                <td class="text-right"><strong>Rs {{ number_format($monthlyData->sum('developer_fee'), 2) }}</strong></td>
                <td class="text-right {{ $monthlyData->sum('profit') >= 0 ? 'profit-positive' : 'profit-negative' }}">
                    <strong>Rs {{ number_format($monthlyData->sum('profit'), 2) }}</strong>
                </td>
                <td class="text-right"><strong>Rs {{ number_format($monthlyData->sum('balance'), 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Additional Summary -->
    <div style="margin-top: 30px;">
        <h3>Financial Summary</h3>
        <table style="width: 50%; margin: 0 auto;">
            <tr>
                <td><strong>Total Revenue:</strong></td>
                <td class="text-right">Rs {{ number_format($monthlyData->sum('total_payment'), 2) }}</td>
            </tr>
            <tr>
                <td><strong>Total Advance Received:</strong></td>
                <td class="text-right">Rs {{ number_format($monthlyData->sum('advance'), 2) }}</td>
            </tr>
            <tr>
                <td><strong>Total Hosting Expenses:</strong></td>
                <td class="text-right">Rs {{ number_format($monthlyData->sum('hosting_fee'), 2) }}</td>
            </tr>
            <tr>
                <td><strong>Total Developer Expenses:</strong></td>
                <td class="text-right">Rs {{ number_format($monthlyData->sum('developer_fee'), 2) }}</td>
            </tr>
            <tr>
                <td><strong>Total Expenses:</strong></td>
                <td class="text-right">Rs {{ number_format($totalExpenses, 2) }}</td>
            </tr>
            <tr style="border-top: 2px solid #333;">
                <td><strong>Net Monthly Profit:</strong></td>
                <td class="text-right {{ $monthlyData->sum('profit') >= 0 ? 'profit-positive' : 'profit-negative' }}">
                    <strong>Rs {{ number_format($monthlyData->sum('profit'), 2) }}</strong>
                </td>
            </tr>
            <tr>
                <td><strong>Outstanding Balance:</strong></td>
                <td class="text-right">Rs {{ number_format($monthlyData->sum('balance'), 2) }}</td>
            </tr>
            <tr>
                <td><strong>Profit Margin:</strong></td>
                @php
                    $profitMargin = $monthlyData->sum('total_payment') > 0 
                        ? ($monthlyData->sum('profit') / $monthlyData->sum('total_payment')) * 100 
                        : 0;
                @endphp
                <td class="text-right {{ $profitMargin >= 0 ? 'profit-positive' : 'profit-negative' }}">
                    <strong>{{ number_format($profitMargin, 2) }}%</strong>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Monthly Profit Report - {{ $month }}</p>
        <p>Generated by: {{ config('app.name', 'Laravel') }} | Page 1 of 1</p>
    </div>
</body>
</html>