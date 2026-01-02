@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #2c5aa0;
        --primary-dark: #1e3d72;
        --primary-light: #e8eff7;
        --primary-extra-light: #f5f8fd;
        --secondary: #6c757d;
        --success: #28a745;
        --success-light: #d4edda;
        --warning: #ffc107;
        --danger: #dc3545;
        --danger-light: #f8d7da;
        --info: #17a2b8;
        --light: #f8f9fa;
        --dark: #343a40;
        --dark-light: #495057;
        --border: #dee2e6;
        --border-light: #eff2f7;
        --shadow: 0 4px 12px rgba(0,0,0,0.08);
        --shadow-light: 0 2px 6px rgba(0,0,0,0.05);
        --radius: 12px;
        --radius-sm: 8px;
        --radius-lg: 16px;
    }
    
    .transactions-container {
        max-width: 1600px;
        margin: 0 auto;
        padding: 20px;
        margin-top: 20px;
    }
    
    /* Page Header Styling */
    .page-header {
        background: white;
        border-radius: var(--radius-lg);
        padding: 30px 35px;
        color: var(--dark);
        margin-bottom: 30px;
        box-shadow: var(--shadow);
        border-left: 5px solid var(--primary);
        position: relative;
        overflow: hidden;
        margin-top: 90px;
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: linear-gradient(135deg, var(--primary-light) 0%, transparent 70%);
        border-radius: 0 0 0 100%;
    }
    
    .page-title {
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        z-index: 2;
    }
    
    .page-title-icon {
        width: 70px;
        height: 70px;
        border-radius: var(--radius);
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 28px;
        box-shadow: 0 4px 15px rgba(44, 90, 160, 0.3);
    }
    
    .page-title-text h1 {
        margin: 0;
        font-weight: 700;
        font-size: 32px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .page-title-text p {
        margin: 8px 0 0 0;
        color: var(--dark-light);
        font-size: 15px;
        line-height: 1.5;
    }
    
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: white;
        border-radius: var(--radius);
        padding: 25px;
        box-shadow: var(--shadow-light);
        border-top: 4px solid var(--primary);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 20px;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
    }
    
    .stat-icon.income {
        background: linear-gradient(135deg, var(--success) 0%, #218838 100%);
    }
    
    .stat-icon.profit {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    }
    
    .stat-icon.transactions {
        background: linear-gradient(135deg, var(--info) 0%, #138496 100%);
    }
    
    .stat-content h3 {
        margin: 0;
        font-size: 14px;
        color: var(--secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }
    
    .stat-content .value {
        font-size: 28px;
        font-weight: 700;
        color: var(--dark);
        line-height: 1;
    }
    
    /* Filters Section */
    .filters-card {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        margin-bottom: 30px;
        overflow: hidden;
        border: 1px solid var(--border-light);
    }
    
    .filters-header {
        background: linear-gradient(135deg, var(--primary-light) 0%, #f0f5ff 100%);
        padding: 20px 30px;
        border-bottom: 1px solid var(--border);
    }
    
    .filters-header h3 {
        margin: 0;
        color: var(--primary-dark);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 18px;
    }
    
    .filters-body {
        padding: 30px;
    }
    
    .filters-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
        align-items: end;
    }
    
    .filter-group {
        margin-bottom: 0;
    }
    
    .filter-label {
        display: block;
        margin-bottom: 10px;
        font-weight: 600;
        color: var(--dark);
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .filter-label i {
        color: var(--primary);
        width: 18px;
        text-align: center;
        font-size: 16px;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 18px;
        border: 2px solid var(--border);
        border-radius: var(--radius-sm);
        font-size: 15px;
        transition: all 0.3s;
        background: white;
        color: var(--dark);
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(44, 90, 160, 0.1);
        background: white;
    }
    
    .btn {
        padding: 12px 24px;
        border-radius: var(--radius-sm);
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        text-decoration: none;
        font-size: 15px;
        height: 48px;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(44, 90, 160, 0.2);
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-dark) 0%, #16325c 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(44, 90, 160, 0.3);
    }
    
    .btn-dark {
        background: linear-gradient(135deg, var(--dark) 0%, #23272b 100%);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(52, 58, 64, 0.2);
    }
    
    .btn-dark:hover {
        background: linear-gradient(135deg, #23272b 0%, #1a1d21 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(52, 58, 64, 0.3);
    }
    
    /* Accordion Styles */
    .accordion {
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow-light);
    }
    
    .accordion-item {
        border: none;
        margin-bottom: 15px;
        border-radius: var(--radius) !important;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        border: 1px solid var(--border-light);
        transition: all 0.3s;
    }
    
    .accordion-item:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border-color: var(--border);
    }
    
    .accordion-button {
        background: white;
        color: var(--dark);
        font-weight: 600;
        padding: 22px 30px;
        border: none;
        box-shadow: none;
        font-size: 17px;
        transition: all 0.3s;
        display: flex;
        align-items: center;
    }
    
    .accordion-button:not(.collapsed) {
        background: linear-gradient(135deg, var(--primary-light) 0%, #f0f5ff 100%);
        color: var(--primary-dark);
        border-left: 4px solid var(--primary);
    }
    
    .accordion-button::after {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='%232c5aa0' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
        transform: rotate(-90deg);
        transition: transform 0.3s ease;
        width: 20px;
        height: 20px;
        background-size: 20px;
    }
    
    .accordion-button:not(.collapsed)::after {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='%231e3d72' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
        transform: rotate(0deg);
    }
    
    .accordion-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding-right: 20px;
    }
    
    .month-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .month-badge {
        background: var(--primary-light);
        color: var(--primary-dark);
        padding: 6px 15px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        border: 1px solid rgba(44, 90, 160, 0.2);
    }
    
    .month-stats {
        display: flex;
        gap: 25px;
        align-items: center;
    }
    
    .stat-item {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }
    
    .stat-label {
        font-size: 12px;
        color: var(--secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 3px;
    }
    
    .stat-value {
        font-size: 18px;
        font-weight: 700;
    }
    
    .accordion-body {
        padding: 0;
        background: #fafbfc;
        border-top: 1px solid var(--border-light);
    }
    
    /* Table Styles */
    .table-container {
        background: white;
        border-radius: 0 0 var(--radius) var(--radius);
        overflow: hidden;
    }
    
    .table-header {
        padding: 20px 30px;
        background: var(--primary-extra-light);
        border-bottom: 1px solid var(--border-light);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .table-title {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .table-summary {
        display: flex;
        gap: 20px;
        align-items: center;
    }
    
    .summary-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 10px 15px;
        background: white;
        border-radius: var(--radius-sm);
        min-width: 120px;
        border: 1px solid var(--border-light);
    }
    
    .summary-label {
        font-size: 12px;
        color: var(--secondary);
        margin-bottom: 5px;
    }
    
    .summary-value {
        font-size: 18px;
        font-weight: 700;
        color: var(--dark);
    }
    
    .transactions-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }
    
    .transactions-table thead {
        background: linear-gradient(135deg, var(--primary-light) 0%, #e3ebf9 100%);
    }
    
    .transactions-table th {
        padding: 18px 25px;
        text-align: left;
        font-weight: 600;
        color: var(--primary-dark);
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border: none;
        white-space: nowrap;
        border-bottom: 2px solid var(--border);
    }
    
    .transactions-table td {
        padding: 18px 25px;
        border-bottom: 1px solid var(--border-light);
        vertical-align: middle;
        font-size: 14px;
        color: var(--dark);
        transition: all 0.3s ease;
    }
    
    .transactions-table tbody tr {
        transition: all 0.3s ease;
        background: white;
    }
    
    .transactions-table tbody tr:hover {
        background: var(--primary-extra-light);
        transform: translateY(-2px);
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    }
    
    .transactions-table tbody tr:last-child td {
        border-bottom: none;
    }
    
    /* Status Badges */
    .status-badge {
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .badge-primary {
        background: rgba(44, 90, 160, 0.1);
        color: var(--primary-dark);
        border: 1px solid rgba(44, 90, 160, 0.2);
    }
    
    .badge-success {
        background: rgba(40, 167, 69, 0.1);
        color: var(--success);
        border: 1px solid rgba(40, 167, 69, 0.2);
    }
    
    .badge-warning {
        background: rgba(255, 193, 7, 0.1);
        color: #856404;
        border: 1px solid rgba(255, 193, 7, 0.2);
    }
    
    .badge-danger {
        background: rgba(220, 53, 69, 0.1);
        color: var(--danger);
        border: 1px solid rgba(220, 53, 69, 0.2);
    }
    
    /* Amount Styling */
    .amount-positive {
        color: var(--success);
        font-weight: 700;
        font-size: 15px;
    }
    
    .amount-negative {
        color: var(--danger);
        font-weight: 700;
        font-size: 15px;
    }
    
    .amount-neutral {
        color: var(--dark);
        font-weight: 600;
        font-size: 15px;
    }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        align-items: center;
    }
    
    .btn-action {
        padding: 8px 12px;
        border-radius: var(--radius-sm);
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        text-decoration: none;
        font-size: 13px;
        min-width: 40px;
        height: 36px;
        position: relative;
        overflow: hidden;
    }
    
    .btn-action::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s;
    }
    
    .btn-action:hover::before {
        left: 100%;
    }
    
    .btn-edit {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(44, 90, 160, 0.2);
    }
    
    .btn-edit:hover {
        background: linear-gradient(135deg, var(--primary-dark) 0%, #16325c 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(44, 90, 160, 0.3);
    }
    
    .btn-delete {
        background: linear-gradient(135deg, var(--danger) 0%, #c82333 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.2);
    }
    
    .btn-delete:hover {
        background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--secondary);
        background: white;
        border-radius: 0 0 var(--radius) var(--radius);
    }
    
    .empty-state-icon {
        width: 80px;
        height: 80px;
        background: var(--primary-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: var(--primary);
        font-size: 32px;
    }
    
    .empty-state h5 {
        margin-bottom: 10px;
        color: var(--dark);
        font-size: 18px;
        font-weight: 600;
    }
    
    .empty-state p {
        max-width: 400px;
        margin: 0 auto;
        line-height: 1.6;
    }
    
    /* Loading Animation */
    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(44, 90, 160, 0.3);
        border-radius: 50%;
        border-top-color: var(--primary);
        animation: spin 1s ease-in-out infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    /* Responsive Design */
    @media (max-width: 1200px) {
        .transactions-container {
            padding: 15px;
        }
        
        .month-stats {
            flex-direction: column;
            gap: 10px;
            align-items: flex-end;
        }
        
        .stat-item {
            align-items: flex-end;
        }
    }
    
    @media (max-width: 992px) {
        .stats-cards {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .filters-row {
            grid-template-columns: 1fr;
        }
        
        .accordion-header-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .month-stats {
            width: 100%;
            justify-content: space-between;
            flex-direction: row;
        }
    }
    
    @media (max-width: 768px) {
        .page-header {
            padding: 25px;
        }
        
        .page-title {
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }
        
        .page-title-icon {
            width: 60px;
            height: 60px;
            font-size: 24px;
        }
        
        .stats-cards {
            grid-template-columns: 1fr;
        }
        
        .accordion-button {
            padding: 18px 20px;
        }
        
        .transactions-table {
            display: block;
            overflow-x: auto;
        }
        
        .table-header {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }
        
        .table-summary {
            width: 100%;
            justify-content: space-between;
        }
        
        .summary-item {
            min-width: auto;
            flex: 1;
        }
    }
    
    @media (max-width: 576px) {
        .transactions-container {
            padding: 10px;
        }
        
        .page-header {
            padding: 20px;
            border-left-width: 3px;
        }
        
        .page-title-text h1 {
            font-size: 24px;
        }
        
        .filters-body {
            padding: 20px;
        }
        
        .transactions-table th,
        .transactions-table td {
            padding: 15px;
            font-size: 13px;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 5px;
        }
        
        .btn-action {
            min-width: 35px;
            height: 32px;
        }
        
        .month-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
        
        .month-stats {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
        
        .stat-item {
            align-items: flex-start;
        }
    }
</style>

<div class="transactions-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <div class="page-title-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="page-title-text">
                <h1>Project Financial Transactions</h1>
                <p>Monitor, analyze, and manage all project financial activities in one comprehensive dashboard</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-cards">
        @php
            $currentMonthAccounts = $groupedAccounts[$month] ?? collect();
            $totalIncome = $currentMonthAccounts->sum('total_payment');
            $totalProfit = $currentMonthAccounts->sum('profit');
            $totalTransactions = $currentMonthAccounts->count();
        @endphp
        
        <div class="stat-card">
            <div class="stat-icon income">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-content">
                <h3>Total Income</h3>
                <div class="value">Rs. {{ number_format($totalIncome, 2) }}</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon profit">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div class="stat-content">
                <h3>Net Profit</h3>
                <div class="value {{ $totalProfit >= 0 ? 'amount-positive' : 'amount-negative' }}">
                    Rs. {{ number_format($totalProfit, 2) }}
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon transactions">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <div class="stat-content">
                <h3>Transactions</h3>
                <div class="value">{{ $totalTransactions }}</div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filters-card">
        <div class="filters-header">
            <h3><i class="fas fa-sliders-h"></i> Filter & Export Options</h3>
        </div>
        <div class="filters-body">
            <form method="GET">
                <div class="filters-row">
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-calendar-alt"></i>Select Month
                        </label>
                        <input type="month" name="month" id="month" value="{{ $month }}" required 
                               class="form-control" title="Select month to view transactions">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-bullseye"></i>Filter Actions
                        </label>
                        <div class="action-buttons" style="justify-content: flex-start;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Apply Filter
                            </button>
                            <a href="{{ route('superadmin.project.transactions.downloadPdf', ['month' => $month]) }}" 
                               class="btn btn-dark" target="_blank">
                                <i class="fas fa-file-pdf"></i> Export PDF
                            </a>
                            @if($currentMonthAccounts->isNotEmpty())
                            <button type="button" class="btn btn-dark" onclick="window.print()">
                                <i class="fas fa-print"></i> Print Report
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Transactions Accordion -->
    <div class="accordion" id="transactionsAccordion">
        @foreach($allMonths as $monthItem)
            @php
                $monthKey = $monthItem['value'];
                $monthlyAccounts = $groupedAccounts[$monthKey] ?? collect();
                $isActive = $month === $monthKey;
                $totalAmount = $monthlyAccounts->sum('total_payment');
                $totalProfit = $monthlyAccounts->sum('profit');
                $transactionCount = $monthlyAccounts->count();
            @endphp

            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $loop->index }}">
                    <button class="accordion-button {{ $isActive ? '' : 'collapsed' }}" type="button" 
                            data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->index }}" 
                            aria-expanded="{{ $isActive ? 'true' : 'false' }}"
                            aria-controls="collapse{{ $loop->index }}">
                        <div class="accordion-header-content">
                            <div class="month-info">
                                <span style="font-size: 16px; font-weight: 600;">{{ $monthItem['label'] }}</span>
                                <span class="month-badge">
                                    <i class="fas fa-exchange-alt"></i>
                                    {{ $transactionCount }} Transactions
                                </span>
                            </div>
                            <div class="month-stats">
                                <div class="stat-item">
                                    <span class="stat-label">Total Income</span>
                                    <span class="stat-value amount-neutral">Rs. {{ number_format($totalAmount, 2) }}</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-label">Net Profit</span>
                                    <span class="stat-value {{ $totalProfit >= 0 ? 'amount-positive' : 'amount-negative' }}">
                                        Rs. {{ number_format($totalProfit, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </button>
                </h2>
                <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse {{ $isActive ? 'show' : '' }}"
                     aria-labelledby="heading{{ $loop->index }}" data-bs-parent="#transactionsAccordion">
                    <div class="accordion-body">
                        <div class="table-container">
                            @if($monthlyAccounts->isEmpty())
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-inbox"></i>
                                    </div>
                                    <h5>No Transactions Found</h5>
                                    <p>No financial transactions were recorded for {{ $monthItem['label'] }}.</p>
                                </div>
                            @else
                                <div class="table-header">
                                    <h4 class="table-title">
                                        <i class="fas fa-table"></i>
                                        Transaction Details - {{ $monthItem['label'] }}
                                    </h4>
                                    <div class="table-summary">
                                        <div class="summary-item">
                                            <span class="summary-label">Projects</span>
                                            <span class="summary-value">{{ $monthlyAccounts->count() }}</span>
                                        </div>
                                        <div class="summary-item">
                                            <span class="summary-label">Total Income</span>
                                            <span class="summary-value amount-neutral">Rs. {{ number_format($totalAmount, 2) }}</span>
                                        </div>
                                        <div class="summary-item">
                                            <span class="summary-label">Net Profit</span>
                                            <span class="summary-value {{ $totalProfit >= 0 ? 'amount-positive' : 'amount-negative' }}">
                                                Rs. {{ number_format($totalProfit, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <table class="transactions-table">
                                    <thead>
                                        <tr>
                                            <th>Project Details</th>
                                            <th>Type</th>
                                            <th>Total Payment</th>
                                            <th>Advance</th>
                                            <th>Balance</th>
                                            <th>Hosting Fee</th>
                                            <th>Developer Fee</th>
                                            <th>Profit</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($monthlyAccounts as $account)
                                            @php
                                                $balanceClass = $account->balance >= 0 ? 'amount-positive' : 'amount-negative';
                                                $profitClass = $account->profit >= 0 ? 'amount-positive' : 'amount-negative';
                                            @endphp
                                            <tr>
                                                <td>
                                                    <strong style="display: block; margin-bottom: 5px; color: var(--primary-dark);">
                                                        {{ $account->project->name }}
                                                    </strong>
                                                    <small style="color: var(--secondary); font-size: 12px;">
                                                        <i class="far fa-calendar-alt"></i> 
                                                        {{ date('M d, Y', strtotime($account->created_at)) }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <span class="status-badge badge-primary">
                                                        {{ $account->project->type }}
                                                    </span>
                                                </td>
                                                <td class="amount-neutral">
                                                    <strong>Rs. {{ number_format($account->total_payment, 2) }}</strong>
                                                </td>
                                                <td class="amount-neutral">
                                                    Rs. {{ number_format($account->advance, 2) }}
                                                </td>
                                                <td class="{{ $balanceClass }}">
                                                    <strong>Rs. {{ number_format($account->balance, 2) }}</strong>
                                                </td>
                                                <td class="amount-neutral">
                                                    Rs. {{ number_format($account->hosting_fee, 2) }}
                                                </td>
                                                <td class="amount-neutral">
                                                    Rs. {{ number_format($account->developer_fee, 2) }}
                                                </td>
                                                <td class="{{ $profitClass }}">
                                                    <strong>Rs. {{ number_format($account->profit, 2) }}</strong>
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                      
                                                        <form action="{{ route('superadmin.project.financials.destroy', $account->id) }}"
                                                              method="POST" style="display:inline;"
                                                              onsubmit="return confirm('Are you sure you want to delete this transaction? This action cannot be undone.');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn-action btn-delete" 
                                                                    title="Delete Transaction" data-bs-toggle="tooltip">
                                                                <i class="fas fa-trash"></i>
                                                                <span class="d-none d-md-inline">Delete</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Font Awesome for icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Auto-expand the current month's accordion
        const currentMonth = '{{ $month }}';
        if (currentMonth) {
            const activeAccordion = document.querySelector('.accordion-button:not(.collapsed)');
            if (activeAccordion) {
                setTimeout(() => {
                    activeAccordion.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center' 
                    });
                }, 300);
            }
        }
        
        // Add smooth animations
        const accordionButtons = document.querySelectorAll('.accordion-button');
        accordionButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Add loading effect
                const icon = this.querySelector('i');
                if (icon) {
                    const originalClass = icon.className;
                    icon.className = 'fas fa-spinner fa-spin';
                    setTimeout(() => {
                        icon.className = originalClass;
                    }, 300);
                }
                
                const target = document.querySelector(this.getAttribute('data-bs-target'));
                if (target) {
                    target.style.transition = 'all 0.3s ease';
                }
            });
        });
        
        // Add print styles
        const style = document.createElement('style');
        style.innerHTML = `
            @media print {
                .btn, .filters-card, .stats-cards {
                    display: none !important;
                }
                .accordion-button::after {
                    display: none !important;
                }
                .accordion-collapse {
                    display: block !important;
                }
                .page-header {
                    box-shadow: none !important;
                    border: 1px solid #ddd !important;
                }
                .transactions-table {
                    break-inside: avoid;
                }
            }
        `;
        document.head.appendChild(style);
    });
</script>

@endsection