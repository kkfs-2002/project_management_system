@extends('layouts.app')

@section('title', 'Monthly Expenses Management')

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
        --warning-light: #fff3cd;
        --danger: #dc3545;
        --danger-light: #f8d7da;
        --info: #17a2b8;
        --info-light: #d1ecf1;
        --light: #f8f9fa;
        --dark: #343a40;
        --dark-light: #495057;
        --border: #dee2e6;
        --border-light: #eff2f7;
        --shadow: 0 4px 12px rgba(0,0,0,0.08);
        --shadow-light: 0 2px 6px rgba(0,0,0,0.05);
        --shadow-hover: 0 6px 20px rgba(0,0,0,0.12);
        --radius: 12px;
        --radius-sm: 8px;
        --radius-lg: 16px;
    }

    .expenses-container {
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
        border-left: 5px solid var(--danger);
        position: relative;
        overflow: hidden;
        margin-top: 50px;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.05) 0%, transparent 70%);
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
        background: linear-gradient(135deg, var(--danger) 0%, #c82333 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 28px;
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    }

    .page-title-text h1 {
        margin: 0;
        font-weight: 700;
        font-size: 32px;
        background: linear-gradient(135deg, var(--danger) 0%, #c82333 100%);
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

    /* Statistics Cards */
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
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
    }

    .stat-card.total-expenses::before {
        background: linear-gradient(135deg, var(--danger) 0%, #c82333 100%);
    }

    .stat-card.current-month::before {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    }

    .stat-card.average-expense::before {
        background: linear-gradient(135deg, var(--warning) 0%, #e0a800 100%);
    }

    .stat-card.month-count::before {
        background: linear-gradient(135deg, var(--info) 0%, #138496 100%);
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

    .stat-icon.total {
        background: linear-gradient(135deg, var(--danger) 0%, #c82333 100%);
    }

    .stat-icon.monthly {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    }

    .stat-icon.average {
        background: linear-gradient(135deg, var(--warning) 0%, #e0a800 100%);
    }

    .stat-icon.calendar {
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

    .stat-content .change {
        font-size: 12px;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .change.positive {
        color: var(--success);
    }

    .change.negative {
        color: var(--danger);
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
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.05) 0%, #fdf5f6 100%);
        padding: 20px 30px;
        border-bottom: 1px solid var(--border);
    }

    .filters-header h3 {
        margin: 0;
        color: var(--danger);
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
        color: var(--danger);
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
        border-color: var(--danger);
        box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
        background: white;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
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
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-success {
        background: linear-gradient(135deg, var(--success) 0%, #218838 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #218838 0%, #1e7e34 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.3);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(44, 90, 160, 0.2);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-dark) 0%, #16325c 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(44, 90, 160, 0.3);
    }

    .btn-outline-secondary {
        background: white;
        color: var(--secondary);
        border: 2px solid var(--border);
        box-shadow: 0 2px 8px rgba(108, 117, 125, 0.1);
    }

    .btn-outline-secondary:hover {
        background: var(--light);
        color: var(--dark);
        border-color: var(--secondary);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.2);
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
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.05) 0%, #fdf5f6 100%);
        color: var(--danger);
        border-left: 4px solid var(--danger);
    }

    .accordion-button::after {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='%23dc3545' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
        transform: rotate(-90deg);
        transition: transform 0.3s ease;
        width: 20px;
        height: 20px;
        background-size: 20px;
    }

    .accordion-button:not(.collapsed)::after {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='%23c82333' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
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
        background: rgba(220, 53, 69, 0.1);
        color: var(--danger);
        padding: 6px 15px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        border: 1px solid rgba(220, 53, 69, 0.2);
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

    .accordion-body {
        padding: 0;
        background: #fafbfc;
        border-top: 1px solid var(--border-light);
    }

    /* Table Container */
    .table-container {
        background: white;
        border-radius: 0 0 var(--radius) var(--radius);
        overflow: hidden;
    }

    .table-header {
        padding: 20px 30px;
        background: rgba(220, 53, 69, 0.03);
        border-bottom: 1px solid var(--border-light);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-title {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: var(--danger);
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
        box-shadow: var(--shadow-light);
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

    /* Table Styles */
    .expenses-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    .expenses-table thead {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.05) 0%, rgba(220, 53, 69, 0.02) 100%);
    }

    .expenses-table th {
        padding: 18px 25px;
        text-align: left;
        font-weight: 600;
        color: var(--danger);
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border: none;
        white-space: nowrap;
        border-bottom: 2px solid rgba(220, 53, 69, 0.1);
    }

    .expenses-table td {
        padding: 18px 25px;
        border-bottom: 1px solid var(--border-light);
        vertical-align: middle;
        font-size: 14px;
        color: var(--dark);
        transition: all 0.3s ease;
    }

    .expenses-table tbody tr {
        transition: all 0.3s ease;
        background: white;
    }

    .expenses-table tbody tr:hover {
        background: rgba(220, 53, 69, 0.02);
        transform: translateY(-2px);
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    }

    .expenses-table tbody tr:last-child td {
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

    .badge-danger {
        background: rgba(220, 53, 69, 0.1);
        color: var(--danger);
        border: 1px solid rgba(220, 53, 69, 0.2);
    }

    .badge-warning {
        background: rgba(255, 193, 7, 0.1);
        color: #856404;
        border: 1px solid rgba(255, 193, 7, 0.2);
    }

    .badge-success {
        background: rgba(40, 167, 69, 0.1);
        color: var(--success);
        border: 1px solid rgba(40, 167, 69, 0.2);
    }

    /* Action Buttons */
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
        background: rgba(220, 53, 69, 0.05);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: var(--danger);
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

    /* Grand Total */
    .grand-total {
        background: white;
        border-radius: var(--radius);
        padding: 25px 30px;
        box-shadow: var(--shadow);
        margin-top: 30px;
        border-top: 4px solid var(--danger);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .grand-total-label {
        font-size: 16px;
        color: var(--secondary);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
    }

    .grand-total-value {
        font-size: 36px;
        font-weight: 800;
        color: var(--danger);
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .expenses-container {
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
        
        .expenses-table {
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
        
        .grand-total {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .expenses-container {
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
        
        .expenses-table th,
        .expenses-table td {
            padding: 15px;
            font-size: 13px;
        }
        
        .action-buttons {
            flex-direction: column;
            width: 100%;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
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
        
        .grand-total-value {
            font-size: 28px;
        }
    }
</style>

<div class="expenses-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <div class="page-title-icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="page-title-text">
                <h1>Monthly Expenses Management</h1>
                <p>Track, analyze, and manage all organizational expenses with detailed monthly breakdowns</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-cards">
        @php
            $currentMonthExpenses = $expensesByMonth[$selectedMonth] ?? collect();
            $currentMonthTotal = $currentMonthExpenses->sum('amount');
            $monthCount = count($expensesByMonth);
            $averageExpense = $monthCount > 0 ? $total / $monthCount : 0;
        @endphp
        
        <div class="stat-card total-expenses">
            <div class="stat-icon total">
                <i class="fas fa-chart-pie"></i>
            </div>
            <div class="stat-content">
                <h3>Total Expenses</h3>
                <div class="value">Rs. {{ number_format($total, 2) }}</div>
                <div class="change">
                    <i class="fas fa-chart-line"></i>
                    All-time total
                </div>
            </div>
        </div>
        
        <div class="stat-card current-month">
            <div class="stat-icon monthly">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-content">
                <h3>Current Month</h3>
                <div class="value">Rs. {{ number_format($currentMonthTotal, 2) }}</div>
                <div class="change">
                    @if($currentMonthTotal > 0)
                        <i class="fas fa-exclamation-triangle"></i>
                        {{ count($currentMonthExpenses) }} expenses
                    @else
                        <i class="fas fa-check-circle"></i>
                        No expenses
                    @endif
                </div>
            </div>
        </div>
        
        <div class="stat-card average-expense">
            <div class="stat-icon average">
                <i class="fas fa-calculator"></i>
            </div>
            <div class="stat-content">
                <h3>Average Monthly</h3>
                <div class="value">Rs. {{ number_format($averageExpense, 2) }}</div>
                <div class="change">
                    <i class="fas fa-balance-scale"></i>
                    Per month average
                </div>
            </div>
        </div>
        
        <div class="stat-card month-count">
            <div class="stat-icon calendar">
                <i class="far fa-calendar"></i>
            </div>
            <div class="stat-content">
                <h3>Months Tracked</h3>
                <div class="value">{{ $monthCount }}</div>
                <div class="change">
                    <i class="fas fa-history"></i>
                    Active periods
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filters-card">
        <div class="filters-header">
            <h3><i class="fas fa-sliders-h"></i> Filter & Manage Expenses</h3>
        </div>
        <div class="filters-body">
            <form method="GET" action="{{ route('superadmin.expenses.index') }}">
                <div class="filters-row">
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-calendar-alt"></i>Select Month
                        </label>
                        <input type="month" id="month" name="month" value="{{ $selectedMonth }}" 
                               class="form-control" title="Select month to filter expenses" required>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-tools"></i>Management Actions
                        </label>
                        <div class="action-buttons">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter"></i> Apply Filter
                            </button>
                            <a href="{{ route('superadmin.expenses.create') }}" class="btn btn-success">
                                <i class="fas fa-plus-circle"></i> Add Expense
                            </a>
                            <a href="{{ route('superadmin.expenses.pdf', ['month' => $selectedMonth]) }}" 
                               class="btn btn-outline-secondary" target="_blank">
                                <i class="fas fa-file-pdf"></i> Export PDF
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Expenses Accordion -->
    <div class="accordion" id="expenseAccordion">
        @foreach($expensesByMonth as $month => $monthExpenses)
            @php
                $isActive = $month === $selectedMonth;
                $monthTotal = $monthExpenses->sum('amount');
                $expenseCount = count($monthExpenses);
                $monthSlug = \Illuminate\Support\Str::slug($month);
            @endphp

            <div class="accordion-item">
                <h2 class="accordion-header" id="heading-{{ $monthSlug }}">
                    <button class="accordion-button {{ $isActive ? '' : 'collapsed' }}" type="button" 
                            data-bs-toggle="collapse" data-bs-target="#collapse-{{ $monthSlug }}"
                            aria-expanded="{{ $isActive ? 'true' : 'false' }}"
                            aria-controls="collapse-{{ $monthSlug }}">
                        <div class="accordion-header-content">
                            <div class="month-info">
                                <span style="font-size: 16px; font-weight: 600;">{{ $month }}</span>
                                <span class="month-badge">
                                    <i class="fas fa-receipt"></i>
                                    {{ $expenseCount }} Expenses
                                </span>
                            </div>
                            <div class="month-stats">
                                <div class="stat-item">
                                    <span class="stat-label">Total Amount</span>
                                    <span class="stat-value amount-negative">Rs. {{ number_format($monthTotal, 2) }}</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-label">Average/Expense</span>
                                    <span class="stat-value amount-neutral">
                                        Rs. {{ $expenseCount > 0 ? number_format($monthTotal / $expenseCount, 2) : '0.00' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </button>
                </h2>
                <div id="collapse-{{ $monthSlug }}" class="accordion-collapse collapse {{ $isActive ? 'show' : '' }}"
                     aria-labelledby="heading-{{ $monthSlug }}" data-bs-parent="#expenseAccordion">
                    <div class="accordion-body">
                        <div class="table-container">
                            @if($monthExpenses->isEmpty())
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-inbox"></i>
                                    </div>
                                    <h5>No Expenses Found</h5>
                                    <p>No expenses were recorded for {{ $month }}.</p>
                                    <a href="{{ route('superadmin.expenses.create') }}" class="btn btn-success mt-3">
                                        <i class="fas fa-plus-circle"></i> Add First Expense
                                    </a>
                                </div>
                            @else
                                <div class="table-header">
                                    <h4 class="table-title">
                                        <i class="fas fa-receipt"></i>
                                        Expense Details - {{ $month }}
                                    </h4>
                                    <div class="table-summary">
                                        <div class="summary-item">
                                            <span class="summary-label">Total Expenses</span>
                                            <span class="summary-value">{{ $expenseCount }}</span>
                                        </div>
                                        <div class="summary-item">
                                            <span class="summary-label">Month Total</span>
                                            <span class="summary-value amount-negative">Rs. {{ number_format($monthTotal, 2) }}</span>
                                        </div>
                                        <div class="summary-item">
                                            <span class="summary-label">Average</span>
                                            <span class="summary-value amount-neutral">
                                                Rs. {{ number_format($monthTotal / $expenseCount, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <table class="expenses-table">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Amount (Rs)</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($monthExpenses as $expense)
                                            <tr>
                                                <td>
                                                    <strong style="display: block; margin-bottom: 5px; color: var(--dark);">
                                                        <i class="fas fa-tag me-2" style="color: var(--danger);"></i>
                                                        {{ $expense->title }}
                                                    </strong>
                                                    <small style="color: var(--secondary); font-size: 12px;">
                                                        ID: EXP-{{ str_pad($expense->id, 4, '0', STR_PAD_LEFT) }}
                                                    </small>
                                                </td>
                                                <td>
                                                    @if($expense->description)
                                                        <span style="color: var(--dark-light);">
                                                            {{ Str::limit($expense->description, 100) }}
                                                        </span>
                                                    @else
                                                        <span style="color: var(--secondary); font-style: italic;">No description</span>
                                                    @endif
                                                </td>
                                                <td class="amount-negative">
                                                    <strong>Rs. {{ number_format($expense->amount, 2) }}</strong>
                                                </td>
                                                <td>
                                                    <div style="display: flex; align-items: center; gap: 8px;">
                                                        <i class="far fa-calendar" style="color: var(--primary);"></i>
                                                        <span>{{ \Carbon\Carbon::parse($expense->expense_date)->format('M d, Y') }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                    
                                                        <form action="{{ route('superadmin.expenses.destroy', $expense->id) }}"
                                                              method="POST" style="display:inline;"
                                                              onsubmit="return confirm('Are you sure you want to delete this expense? This action cannot be undone.');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn-action btn-delete" 
                                                                    title="Delete Expense" data-bs-toggle="tooltip">
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
                                
                                <!-- Month Total Footer -->
                                <div style="background: rgba(220, 53, 69, 0.03); padding: 20px 30px; border-top: 1px solid var(--border-light);">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <div>
                                            <h6 style="margin: 0; color: var(--danger); font-weight: 600;">
                                                <i class="fas fa-chart-bar me-2"></i>
                                                {{ $month }} Summary
                                            </h6>
                                            <small style="color: var(--secondary);">
                                                {{ $expenseCount }} expense{{ $expenseCount > 1 ? 's' : '' }} recorded
                                            </small>
                                        </div>
                                        <div style="text-align: right;">
                                            <div style="font-size: 12px; color: var(--secondary); margin-bottom: 5px;">
                                                Monthly Total
                                            </div>
                                            <div class="amount-negative" style="font-size: 24px; font-weight: 800;">
                                                Rs. {{ number_format($monthTotal, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Grand Total -->
    <div class="grand-total">
        <div class="grand-total-label">
            <i class="fas fa-chart-line me-2"></i>
            Grand Total (All Months)
        </div>
        <div class="grand-total-value">
            Rs. {{ number_format($total, 2) }}
        </div>
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
        
        // Auto-expand the selected month's accordion
        const selectedMonth = '{{ $selectedMonth }}';
        if (selectedMonth) {
            const activeAccordion = document.querySelector('.accordion-button:not(.collapsed)');
            if (activeAccordion) {
                setTimeout(() => {
                    activeAccordion.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center',
                        inline: 'nearest'
                    });
                }, 300);
            }
        }
        
        // Add loading effect to buttons
        const filterForm = document.querySelector('form[method="GET"]');
        if (filterForm) {
            filterForm.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    const originalHTML = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Filtering...';
                    submitBtn.disabled = true;
                    
                    setTimeout(() => {
                        submitBtn.innerHTML = originalHTML;
                        submitBtn.disabled = false;
                    }, 1500);
                }
            });
        }
        
        // Add smooth animations to accordion
        const accordionButtons = document.querySelectorAll('.accordion-button');
        accordionButtons.forEach(button => {
            button.addEventListener('click', function() {
                const icon = this.querySelector('i');
                if (icon) {
                    const originalClass = icon.className;
                    icon.className = 'fas fa-spinner fa-spin';
                    setTimeout(() => {
                        icon.className = originalClass;
                    }, 300);
                }
            });
        });
        
        // Highlight expensive items
        const amountCells = document.querySelectorAll('.amount-negative');
        amountCells.forEach(cell => {
            const amount = parseFloat(cell.textContent.replace(/[^0-9.-]+/g,""));
            if (amount > 10000) {
                cell.style.fontWeight = '900';
                cell.style.fontSize = '16px';
                cell.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>' + cell.innerHTML;
            }
        });
        
        // Print functionality
        const printBtn = document.createElement('button');
        printBtn.className = 'btn btn-outline-secondary';
        printBtn.innerHTML = '<i class="fas fa-print"></i> Print Report';
        printBtn.onclick = () => window.print();
        document.querySelector('.action-buttons').appendChild(printBtn);
        
        // Add print styles
        const style = document.createElement('style');
        style.innerHTML = `
            @media print {
                .btn, .filters-card, .stats-cards, .action-buttons {
                    display: none !important;
                }
                .accordion-button::after {
                    display: none !important;
                }
                .accordion-collapse {
                    display: block !important;
                }
                .accordion-item {
                    break-inside: avoid;
                    box-shadow: none !important;
                    border: 1px solid #ddd !important;
                }
                .page-header {
                    box-shadow: none !important;
                    border: 1px solid #ddd !important;
                }
                .grand-total {
                    break-inside: avoid;
                }
            }
        `;
        document.head.appendChild(style);
    });
</script>

@endsection