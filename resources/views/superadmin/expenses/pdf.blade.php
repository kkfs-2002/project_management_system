<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Monthly Expenses Report - {{ \Carbon\Carbon::parse($selectedMonth)->format('F Y') }}</title>
    <style>
        /* Reset and Base Styles */
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            font-size: 12px; 
            color: #333; 
            line-height: 1.4; 
            background: #fff;
        }
        
        /* Header Section */
        .header {
            padding: 20px 0;
            border-bottom: 2px solid #dc3545;
            margin-bottom: 25px;
        }
        
        .company-info {
            text-align: center;
            margin-bottom: 15px;
        }
        
        .company-name {
            font-size: 22px;
            font-weight: 700;
            color: #2c5aa0;
            margin-bottom: 5px;
        }
        
        .company-tagline {
            font-size: 12px;
            color: #666;
            margin-bottom: 8px;
        }
        
        .report-title {
            text-align: center;
            margin-bottom: 10px;
        }
        
        .main-title {
            font-size: 20px;
            font-weight: 700;
            color: #dc3545;
            margin-bottom: 5px;
        }
        
        .sub-title {
            font-size: 14px;
            color: #666;
        }
        
        .report-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
        }
        
        .meta-item {
            display: flex;
            flex-direction: column;
        }
        
        .meta-label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        
        .meta-value {
            font-size: 12px;
            font-weight: 600;
            color: #333;
        }
        
        /* Summary Cards */
        .summary-cards {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .summary-card {
            flex: 1;
            padding: 15px;
            border-radius: 6px;
            border-left: 4px solid;
        }
        
        .card-total {
            border-left-color: #dc3545;
            background: linear-gradient(135deg, #fdf5f6 0%, #fef9fa 100%);
        }
        
        .card-months {
            border-left-color: #2c5aa0;
            background: linear-gradient(135deg, #f0f5ff 0%, #f9fbff 100%);
        }
        
        .card-average {
            border-left-color: #ffc107;
            background: linear-gradient(135deg, #fffdf5 0%, #fffef9 100%);
        }
        
        .card-current {
            border-left-color: #28a745;
            background: linear-gradient(135deg, #f5fdf7 0%, #fafefb 100%);
        }
        
        .card-title {
            font-size: 10px;
            text-transform: uppercase;
            color: #666;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }
        
        .card-value {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .card-hint {
            font-size: 10px;
            color: #888;
        }
        
        /* Month Sections */
        .month-section {
            margin-bottom: 30px;
            break-inside: avoid;
        }
        
        .month-header {
            background: linear-gradient(135deg, #fdf5f6 0%, #f9f0f1 100%);
            padding: 12px 15px;
            border-radius: 6px 6px 0 0;
            border: 1px solid #f0d2d5;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .month-title {
            font-size: 16px;
            font-weight: 700;
            color: #dc3545;
        }
        
        .month-stats {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        
        .month-stat {
            text-align: right;
        }
        
        .stat-label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        
        .stat-value {
            font-size: 14px;
            font-weight: 700;
            color: #333;
        }
        
        /* Table Styles */
        .expense-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #eee;
            margin-top: -1px;
            page-break-inside: avoid;
        }
        
        .expense-table thead {
            background: linear-gradient(135deg, #f8f9fa 0%, #f1f3f5 100%);
        }
        
        .expense-table th {
            padding: 10px 12px;
            text-align: left;
            font-weight: 600;
            color: #495057;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #dee2e6;
        }
        
        .expense-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 11px;
            vertical-align: top;
        }
        
        .expense-table tbody tr:nth-child(even) {
            background-color: #fafafa;
        }
        
        .expense-table tbody tr:hover {
            background-color: #f5f5f5;
        }
        
        .expense-table tbody tr:last-child td {
            border-bottom: none;
        }
        
        /* Column specific styles */
        .col-title {
            font-weight: 600;
            color: #2c5aa0;
            width: 25%;
        }
        
        .col-description {
            color: #666;
            width: 30%;
        }
        
        .col-amount {
            text-align: right;
            font-weight: 700;
            color: #dc3545;
            width: 15%;
        }
        
        .col-date {
            text-align: center;
            color: #666;
            width: 15%;
        }
        
        /* Empty State */
        .empty-state {
            padding: 40px 20px;
            text-align: center;
            border: 1px solid #eee;
            border-top: none;
            background: #fdfdfd;
        }
        
        .empty-icon {
            font-size: 32px;
            color: #ddd;
            margin-bottom: 10px;
        }
        
        .empty-text {
            color: #999;
            font-style: italic;
        }
        
        /* Month Footer */
        .month-footer {
            background: #f8f9fa;
            padding: 12px 15px;
            border: 1px solid #eee;
            border-top: none;
            border-radius: 0 0 6px 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .footer-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .expense-count {
            font-size: 11px;
            color: #666;
        }
        
        .month-total {
            text-align: right;
        }
        
        .total-label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        
        .total-value {
            font-size: 18px;
            font-weight: 800;
            color: #dc3545;
        }
        
        /* Grand Total */
        .grand-total {
            margin-top: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
            border: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
            page-break-before: avoid;
        }
        
        .grand-label {
            font-size: 14px;
            font-weight: 600;
            color: #495057;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .grand-value {
            font-size: 28px;
            font-weight: 900;
            color: #dc3545;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        
        /* Report Footer */
        .report-footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #eee;
            text-align: center;
            font-size: 10px;
            color: #888;
            page-break-before: always;
        }
        
        .footer-info {
            margin-bottom: 8px;
        }
        
        .footer-note {
            font-style: italic;
            color: #999;
            margin-top: 5px;
        }
        
        /* Print Optimizations */
        @media print {
            .header { padding: 15px 0; }
            .summary-cards { margin-bottom: 20px; }
            .month-section { margin-bottom: 25px; }
            .grand-total { margin-top: 25px; }
            .report-footer { margin-top: 25px; }
            
            body {
                font-size: 11px;
            }
            
            .expense-table th,
            .expense-table td {
                padding: 8px 10px;
                font-size: 10px;
            }
            
            .card-value {
                font-size: 18px;
            }
            
            .grand-value {
                font-size: 24px;
            }
        }
        
        /* Utility Classes */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .text-danger { color: #dc3545; }
        .text-success { color: #28a745; }
        .text-warning { color: #ffc107; }
        .text-primary { color: #2c5aa0; }
        .text-muted { color: #6c757d; }
        .mb-1 { margin-bottom: 5px; }
        .mb-2 { margin-bottom: 10px; }
        .mb-3 { margin-bottom: 15px; }
        .mb-4 { margin-bottom: 20px; }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <div class="company-info">
            <div class="company-name">YOUR COMPANY NAME</div>
            <div class="company-tagline">Financial Management System</div>
        </div>
        
        <div class="report-title">
            <h1 class="main-title">Monthly Expenses Report</h1>
            <div class="sub-title">Comprehensive Financial Expense Analysis</div>
        </div>
        
        <div class="report-meta">
            <div class="meta-item">
                <span class="meta-label">Report Period</span>
                <span class="meta-value">{{ \Carbon\Carbon::parse($selectedMonth)->format('F Y') }}</span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Generated On</span>
                <span class="meta-value">{{ date('F d, Y') }}</span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Generated At</span>
                <span class="meta-value">{{ date('h:i A') }}</span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Report ID</span>
                <span class="meta-value">EXP-{{ date('Ymd') }}-{{ str_pad(count($expensesByMonth), 3, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>
    </div>
    
    <!-- Summary Statistics -->
    <div class="summary-cards">
        @php
            $currentMonthExpenses = $expensesByMonth[$selectedMonth] ?? collect();
            $currentMonthTotal = $currentMonthExpenses->sum('amount');
            $monthCount = count($expensesByMonth);
            $averageExpense = $monthCount > 0 ? $total / $monthCount : 0;
        @endphp
        
        <div class="summary-card card-total">
            <div class="card-title">Total Expenses</div>
            <div class="card-value text-danger">Rs. {{ number_format($total, 2) }}</div>
            <div class="card-hint">All-time accumulated</div>
        </div>
        
        <div class="summary-card card-months">
            <div class="card-title">Months Tracked</div>
            <div class="card-value text-primary">{{ $monthCount }}</div>
            <div class="card-hint">Active periods in system</div>
        </div>
        
        <div class="summary-card card-average">
            <div class="card-title">Average Monthly</div>
            <div class="card-value text-warning">Rs. {{ number_format($averageExpense, 2) }}</div>
            <div class="card-hint">Per month average</div>
        </div>
        
        <div class="summary-card card-current">
            <div class="card-title">Current Month</div>
            <div class="card-value text-success">Rs. {{ number_format($currentMonthTotal, 2) }}</div>
            <div class="card-hint">{{ count($currentMonthExpenses) }} expenses</div>
        </div>
    </div>
    
    <!-- Monthly Expenses Breakdown -->
    @foreach($expensesByMonth as $month => $monthExpenses)
        @php
            $monthTotal = $monthExpenses->sum('amount');
            $expenseCount = count($monthExpenses);
        @endphp
        
        <div class="month-section">
            <div class="month-header">
                <div class="month-title">{{ $month }}</div>
                <div class="month-stats">
                    <div class="month-stat">
                        <div class="stat-label">Expenses Count</div>
                        <div class="stat-value">{{ $expenseCount }}</div>
                    </div>
                    <div class="month-stat">
                        <div class="stat-label">Month Total</div>
                        <div class="stat-value text-danger">Rs. {{ number_format($monthTotal, 2) }}</div>
                    </div>
                    <div class="month-stat">
                        <div class="stat-label">Average/Expense</div>
                        <div class="stat-value text-primary">
                            Rs. {{ $expenseCount > 0 ? number_format($monthTotal / $expenseCount, 2) : '0.00' }}
                        </div>
                    </div>
                </div>
            </div>
            
            @if($monthExpenses->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">📊</div>
                    <div class="empty-text">No expenses recorded for this month</div>
                </div>
            @else
                <table class="expense-table">
                    <thead>
                        <tr>
                            <th class="col-title">Title</th>
                            <th class="col-description">Description</th>
                            <th class="col-amount">Amount (LKR)</th>
                            <th class="col-date">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($monthExpenses as $expense)
                            <tr>
                                <td class="col-title">
                                    <strong>{{ $expense->title }}</strong><br>
                                    <small style="color: #888; font-size: 10px;">
                                        ID: EXP-{{ str_pad($expense->id, 4, '0', STR_PAD_LEFT) }}
                                    </small>
                                </td>
                                <td class="col-description">
                                    @if($expense->description)
                                        {{ Str::limit($expense->description, 80) }}
                                    @else
                                        <span style="color: #999; font-style: italic;">No description</span>
                                    @endif
                                </td>
                                <td class="col-amount">
                                    Rs. {{ number_format($expense->amount, 2) }}
                                    @if($expense->amount > 10000)
                                        <br><small style="color: #e63946; font-weight: 600;">⚠️ Large Expense</small>
                                    @endif
                                </td>
                                <td class="col-date">
                                    {{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="month-footer">
                    <div class="footer-info">
                        <div class="expense-count">
                            {{ $expenseCount }} expense{{ $expenseCount > 1 ? 's' : '' }} recorded
                        </div>
                    </div>
                    <div class="month-total">
                        <div class="total-label">Month Total</div>
                        <div class="total-value">Rs. {{ number_format($monthTotal, 2) }}</div>
                    </div>
                </div>
            @endif
        </div>
    @endforeach
    
    <!-- Grand Total Section -->
    <div class="grand-total">
        <div class="grand-label">
            <span style="font-size: 18px; margin-right: 10px;">📈</span>
            Grand Total (All Months)
        </div>
        <div class="grand-value">
            Rs. {{ number_format($total, 2) }}
        </div>
    </div>
    
    <!-- Report Footer -->
    <div class="report-footer">
        <div class="footer-info">
            <strong>Report Information:</strong> 
            This report is system-generated and reflects expense data as recorded in the financial management system.
        </div>
        <div>
            Page 1 of 1 | Document ID: EXP-{{ date('Ymd-His') }} | Generated by: System Administrator
        </div>
        <div class="footer-note mb-2">
            Note: This is a confidential financial document. Unauthorized distribution is prohibited.
        </div>
        <div style="border-top: 1px solid #eee; padding-top: 8px; color: #aaa; font-size: 9px;">
            © {{ date('Y') }} Your Company Name. All rights reserved. | Generated on {{ date('Y-m-d H:i:s') }}
        </div>
    </div>
</body>
</html>