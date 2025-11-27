@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #2c5aa0;
        --primary-dark: #1e3d72;
        --primary-light: #e8eff7;
        --secondary: #6c757d;
        --success: #28a745;
        --warning: #ffc107;
        --danger: #dc3545;
        --info: #17a2b8;
        --light: #f8f9fa;
        --dark: #343a40;
        --border: #dee2e6;
        --shadow: 0 4px 12px rgba(0,0,0,0.08);
        --radius: 12px;
    }
    
    .transactions-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
        margin-top: 20px;
    }
    
    .page-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border-radius: var(--radius);
        padding: 25px 30px;
        color: white;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        transform: translate(40px, -40px);
    }
    
    .page-title {
        display: flex;
        align-items: center;
        gap: 15px;
        position: relative;
        z-index: 2;
    }
    
    .page-title i {
        font-size: 32px;
        background: rgba(255,255,255,0.2);
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
    }
    
    .page-title h1 {
        margin: 0;
        font-weight: 700;
        font-size: 28px;
    }
    
    .page-title p {
        margin: 5px 0 0 0;
        opacity: 0.9;
        font-size: 14px;
    }
    
    /* Filters Section */
    .filters-card {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        margin-bottom: 30px;
        overflow: hidden;
    }
    
    .filters-header {
        background: var(--primary-light);
        padding: 18px 25px;
        border-bottom: 1px solid var(--border);
    }
    
    .filters-header h3 {
        margin: 0;
        color: var(--primary);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 18px;
    }
    
    .filters-body {
        padding: 25px;
    }
    
    .filters-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 20px;
        flex-wrap: wrap;
    }
    
    .filter-group {
        flex: 1;
        min-width: 200px;
    }
    
    .filter-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--dark);
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .filter-label i {
        color: var(--primary);
        width: 16px;
        text-align: center;
    }
    
    .form-control {
        width: 100%;
        padding: 10px 15px;
        border: 2px solid var(--border);
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.1);
    }
    
    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        text-decoration: none;
        font-size: 14px;
    }
    
    .btn-primary {
        background: var(--primary);
        color: white;
    }
    
    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .btn-dark {
        background: var(--dark);
        color: white;
    }
    
    .btn-dark:hover {
        background: #23272b;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    /* Accordion Styles */
    .accordion {
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow);
    }
    
    .accordion-item {
        border: none;
        margin-bottom: 15px;
        border-radius: var(--radius) !important;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .accordion-button {
        background: white;
        color: var(--dark);
        font-weight: 600;
        padding: 20px 25px;
        border: none;
        box-shadow: none;
        font-size: 16px;
        transition: all 0.3s;
    }
    
    .accordion-button:not(.collapsed) {
        background: var(--primary-light);
        color: var(--primary);
        border-bottom: 3px solid var(--primary);
    }
    
    .accordion-button::after {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%232c5aa0' viewBox='0 0 16 16'%3E%3Cpath d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z'/%3E%3C/svg%3E");
        transform: rotate(0deg);
        transition: transform 0.3s ease;
    }
    
    .accordion-button:not(.collapsed)::after {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%232c5aa0' viewBox='0 0 16 16'%3E%3Cpath d='M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z'/%3E%3C/svg%3E");
        transform: rotate(0deg);
    }
    
    .accordion-body {
        padding: 0;
        background: #fafbfc;
    }
    
    /* Table Styles */
    .table-container {
        background: white;
        border-radius: 0 0 var(--radius) var(--radius);
        overflow: hidden;
    }
    
    .transactions-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }
    
    .transactions-table thead {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    }
    
    .transactions-table th {
        padding: 16px 20px;
        text-align: left;
        font-weight: 600;
        color: white;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        white-space: nowrap;
    }
    
    .transactions-table td {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
        font-size: 14px;
        color: var(--dark);
    }
    
    .transactions-table tbody tr {
        transition: all 0.3s ease;
        background: white;
    }
    
    .transactions-table tbody tr:hover {
        background: var(--primary-light);
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .transactions-table tbody tr:last-child td {
        border-bottom: none;
    }
    
    /* Amount Styling */
    .amount-positive {
        color: var(--success);
        font-weight: 600;
    }
    
    .amount-negative {
        color: var(--danger);
        font-weight: 600;
    }
    
    .amount-neutral {
        color: var(--dark);
        font-weight: 600;
    }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        align-items: center;
    }
    
    .btn-action {
        padding: 8px 12px;
        border-radius: 6px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        text-decoration: none;
        font-size: 12px;
        min-width: 40px;
        height: 36px;
        justify-content: center;
    }
    
    .btn-edit {
        background: var(--primary);
        color: white;
    }
    
    .btn-edit:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    
    .btn-delete {
        background: var(--danger);
        color: white;
    }
    
    .btn-delete:hover {
        background: #c82333;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: var(--secondary);
    }
    
    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }
    
    .empty-state h5 {
        margin-bottom: 10px;
        color: var(--dark);
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .transactions-container {
            padding: 15px;
        }
        
        .page-header {
            padding: 20px;
        }
        
        .page-title {
            flex-direction: column;
            text-align: center;
            gap: 10px;
        }
        
        .page-title i {
            width: 50px;
            height: 50px;
            font-size: 24px;
        }
        
        .filters-row {
            flex-direction: column;
            align-items: stretch;
            gap: 15px;
        }
        
        .filter-group {
            min-width: auto;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
        
        .transactions-table {
            display: block;
            overflow-x: auto;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 5px;
        }
        
        .btn-action {
            min-width: 35px;
            height: 32px;
        }
    }
    
    @media (max-width: 480px) {
        .transactions-table th,
        .transactions-table td {
            padding: 12px 15px;
            font-size: 12px;
        }
        
        .accordion-button {
            padding: 15px 20px;
            font-size: 14px;
        }
    }
</style>

<div class="transactions-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <i class="fas fa-chart-line"></i>
            <div>
                <h1>Project Transactions</h1>
                <p>View and manage all project financial transactions</p>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filters-card">
        <div class="filters-header">
            <h3><i class="fas fa-filter"></i> Filter Transactions</h3>
        </div>
        <div class="filters-body">
            <form method="GET">
                <div class="filters-row">
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-calendar-alt"></i>Select Month
                        </label>
                        <input type="month" name="month" id="month" value="{{ $month }}" required class="form-control">
                    </div>
                    <div class="filter-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Apply Filter
                        </button>
                    </div>
                    <div class="filter-group">
                        <a href="{{ route('superadmin.project.transactions.downloadPdf', ['month' => $month]) }}" class="btn btn-dark">
                            <i class="fas fa-file-pdf"></i> Download PDF
                        </a>
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
            @endphp

            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $loop->index }}">
                    <button class="accordion-button {{ $isActive ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $loop->index }}" aria-expanded="{{ $isActive ? 'true' : 'false' }}"
                            aria-controls="collapse{{ $loop->index }}">
                        <div class="d-flex justify-content-between align-items-center w-100 me-3">
                            <span>{{ $monthItem['label'] }}</span>
                            <span class="badge bg-primary rounded-pill">
                                {{ $monthlyAccounts->count() }} Transactions
                                • Total: Rs. {{ number_format($totalAmount, 2) }}
                                @if($totalProfit > 0)
                                    • Profit: <span class="amount-positive">Rs. {{ number_format($totalProfit, 2) }}</span>
                                @elseif($totalProfit < 0)
                                    • Loss: <span class="amount-negative">Rs. {{ number_format(abs($totalProfit), 2) }}</span>
                                @else
                                    • Profit: <span class="amount-neutral">Rs. {{ number_format($totalProfit, 2) }}</span>
                                @endif
                            </span>
                        </div>
                    </button>
                </h2>
                <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse {{ $isActive ? 'show' : '' }}"
                     aria-labelledby="heading{{ $loop->index }}" data-bs-parent="#transactionsAccordion">
                    <div class="accordion-body">
                        <div class="table-container">
                            @if($monthlyAccounts->isEmpty())
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <h5>No Transactions Found</h5>
                                    <p>No financial transactions recorded for {{ $monthItem['label'] }}</p>
                                </div>
                            @else
                                <table class="transactions-table">
                                    <thead>
                                        <tr>
                                            <th>Project</th>
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
                                            <tr>
                                                <td>
                                                    <strong>{{ $account->project->name }}</strong>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">{{ $account->project->type }}</span>
                                                </td>
                                                <td class="amount-neutral">
                                                    Rs. {{ number_format($account->total_payment, 2) }}
                                                </td>
                                                <td class="amount-neutral">
                                                    Rs. {{ number_format($account->advance, 2) }}
                                                </td>
                                                <td class="{{ $account->balance >= 0 ? 'amount-positive' : 'amount-negative' }}">
                                                    Rs. {{ number_format($account->balance, 2) }}
                                                </td>
                                                <td class="amount-neutral">
                                                    Rs. {{ number_format($account->hosting_fee, 2) }}
                                                </td>
                                                <td class="amount-neutral">
                                                    Rs. {{ number_format($account->developer_fee, 2) }}
                                                </td>
                                                <td class="{{ $account->profit >= 0 ? 'amount-positive' : 'amount-negative' }}">
                                                    Rs. {{ number_format($account->profit, 2) }}
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="{{ route('superadmin.project.financials.edit', $account->id) }}"
                                                           class="btn-action btn-edit" title="Edit Transaction">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('superadmin.project.financials.destroy', $account->id) }}"
                                                              method="POST" style="display:inline;"
                                                              onsubmit="return confirm('Are you sure you want to delete this transaction?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn-action btn-delete" title="Delete Transaction">
                                                                <i class="fas fa-trash"></i>
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
        // Auto-expand the current month's accordion
        const currentMonth = '{{ $month }}';
        if (currentMonth) {
            const activeAccordion = document.querySelector(`[aria-expanded="true"]`);
            if (activeAccordion) {
                activeAccordion.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
        
        // Add smooth animations
        const accordionButtons = document.querySelectorAll('.accordion-button');
        accordionButtons.forEach(button => {
            button.addEventListener('click', function() {
                const target = document.querySelector(this.getAttribute('data-bs-target'));
                if (target) {
                    target.style.transition = 'all 0.3s ease';
                }
            });
        });
    });
</script>

@endsection