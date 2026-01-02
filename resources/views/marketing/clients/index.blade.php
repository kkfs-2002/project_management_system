@extends('layouts.marketing')

@section('title', 'Client Management Dashboard')

@section('content')
<style>
    :root {
        --primary-blue: #0066cc;
        --primary-light: #e6f0ff;
        --secondary-blue: #0044aa;
        --light-bg: #f8fbff;
        --dark-text: #1a365d;
        --light-text: #718096;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --border-color: #e1e8ff;
    }

    .dashboard-container {
        background: #f5f9ff;
        min-height: 100vh;
        padding: 30px;
    }

    .dashboard-header {
        background: white;
        border-radius: 16px;
        padding: 25px 30px;
        margin-bottom: 30px;
        box-shadow: 0 4px 20px rgba(0, 102, 204, 0.08);
        border: 1px solid var(--border-color);
        margin-top: 60px;
    }

    .header-title {
        color: var(--dark-text);
        font-weight: 700;
        font-size: 28px;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .header-title i {
        color: var(--primary-blue);
        background: var(--primary-light);
        padding: 12px;
        border-radius: 12px;
    }

    .header-subtitle {
        color: var(--light-text);
        font-size: 15px;
        margin-top: 8px;
        margin-bottom: 0;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .btn-primary-gradient {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(0, 102, 204, 0.25);
    }

    .btn-primary-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 102, 204, 0.35);
        color: white;
    }

    .btn-outline-blue {
        border: 2px solid var(--primary-blue);
        color: var(--primary-blue);
        background: white;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-outline-blue:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
        color: var(--primary-blue);
    }

    /* Stats Cards */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 102, 204, 0.1);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
    }

    .stat-icon.blue { background: #e6f0ff; color: var(--primary-blue); }
    .stat-icon.green { background: #d1fae5; color: #10b981; }
    .stat-icon.orange { background: #ffedd5; color: #f97316; }
    .stat-icon.purple { background: #f3e8ff; color: #8b5cf6; }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: var(--dark-text);
        margin: 0;
        line-height: 1.2;
    }

    .stat-label {
        color: var(--light-text);
        font-size: 14px;
        margin-top: 5px;
        margin-bottom: 0;
    }

    .stat-change {
        font-size: 12px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 4px;
        margin-top: 8px;
    }

    .stat-change.positive { color: #10b981; }
    .stat-change.negative { color: #ef4444; }

    /* Filter Section */
    .filter-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
    }

    .filter-title {
        color: var(--dark-text);
        font-weight: 600;
        font-size: 16px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .month-selector {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .month-input {
        padding: 10px 15px;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        font-size: 14px;
        color: var(--dark-text);
        background: white;
        transition: all 0.3s ease;
    }

    .month-input:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
    }

    /* Client Table */
    .clients-table-container {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--border-color);
        margin-bottom: 40px;
    }

    .month-section {
        border-bottom: 1px solid var(--border-color);
    }

    .month-section:last-child {
        border-bottom: none;
    }

    .month-header {
        background: var(--light-bg);
        padding: 20px 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid var(--border-color);
    }

    .month-title {
        color: var(--dark-text);
        font-weight: 600;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .month-title i {
        color: var(--primary-blue);
    }

    .client-count {
        background: var(--primary-blue);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .table-container {
        padding: 0;
    }

    .table {
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table thead {
        background: var(--light-bg);
    }

    .table thead th {
        border: none;
        padding: 16px 20px;
        color: var(--dark-text);
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .table tbody tr {
        border-bottom: 1px solid var(--border-color);
        transition: background-color 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: var(--light-bg);
    }

    .table tbody td {
        padding: 16px 20px;
        vertical-align: middle;
        border: none;
        color: var(--dark-text);
        font-size: 14px;
        border-top: 1px solid var(--border-color);
    }

    /* Status Badges */
    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .badge-success { background: #d1fae5; color: #065f46; }
    .badge-warning { background: #fef3c7; color: #92400e; }
    .badge-danger { background: #fee2e2; color: #991b1b; }
    .badge-secondary { background: #e5e7eb; color: #374151; }
    .badge-info { background: #e0f2fe; color: #075985; }

    /* Payment Badges */
    .payment-badge-full { background: #dcfce7; color: #166534; }
    .payment-badge-advance { background: #fef3c7; color: #92400e; }
    .payment-badge-none { background: #fee2e2; color: #991b1b; }

    /* Action Buttons */
    .action-group {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-icon-edit {
        background: #e0f2fe;
        color: #0284c7;
    }

    .btn-icon-edit:hover {
        background: #bae6fd;
        transform: translateY(-2px);
    }

    .btn-icon-delete {
        background: #fee2e2;
        color: #dc2626;
    }

    .btn-icon-delete:hover {
        background: #fecaca;
        transform: translateY(-2px);
    }

    .btn-request {
        background: var(--primary-light);
        color: var(--primary-blue);
        border: 1px solid var(--border-color);
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-request:hover {
        background: var(--primary-blue);
        color: white;
        transform: translateY(-2px);
    }

    .permission-badge {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-permission-pending { background: #fef3c7; color: #92400e; }
    .badge-permission-rejected { background: #fee2e2; color: #991b1b; }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--light-text);
    }

    .empty-state i {
        font-size: 48px;
        color: var(--border-color);
        margin-bottom: 20px;
    }

    .empty-state h4 {
        color: var(--dark-text);
        margin-bottom: 10px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 20px 15px;
        }

        .stats-container {
            grid-template-columns: 1fr;
        }

        .header-title {
            font-size: 24px;
        }

        .action-buttons {
            flex-direction: column;
            align-items: stretch;
            margin-top: 15px;
        }

        .table-responsive {
            border: none;
            border-radius: 0;
        }

        .table thead {
            display: none;
        }

        .table tbody tr {
            display: block;
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 15px;
            background: white;
        }

        .table tbody td {
            display: block;
            text-align: right;
            padding: 10px 15px;
            position: relative;
            border: none;
        }

        .table tbody td::before {
            content: attr(data-label);
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-weight: 600;
            color: var(--dark-text);
            font-size: 13px;
        }

        .action-group {
            justify-content: flex-end;
        }
    }

    /* Loading Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dashboard-header, .stats-container, .filter-card, .clients-table-container {
        animation: fadeIn 0.5s ease-out;
    }

    /* Scrollbar Styling */
    .table-container::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    .table-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .table-container::-webkit-scrollbar-thumb {
        background: var(--primary-blue);
        border-radius: 4px;
    }

    .table-container::-webkit-scrollbar-thumb:hover {
        background: var(--secondary-blue);
    }
</style>

<div class="dashboard-container">
    <!-- Header -->
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="header-title">
                    <i class="fas fa-users"></i>
                    Client Management Dashboard
                </h1>
                <p class="header-subtitle">
                    Manage all your clients, projects, and payments in one place
                    @if(request('month'))
                        • Filtered for {{ \Carbon\Carbon::parse(request('month'))->format('F Y') }}
                    @endif
                </p>
            </div>
            <div class="col-lg-4">
                <div class="action-buttons">
                    <a href="{{ route('marketing.clients.create') }}" class="btn-primary-gradient">
                        <i class="fas fa-plus"></i> New Client
                    </a>
                    <a href="{{ route('marketing.clients.index.pdf', ['month' => request('month')]) }}" 
                       class="btn-outline-blue">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-container">
        @php
            // Safely calculate statistics
            $totalClients = 0;
            $activeClients = 0;
            $totalRevenue = 0;
            $upcomingReminders = 0;
            $currentMonthCount = 0;
            
            if ($clientsByMonth) {
                foreach ($clientsByMonth as $monthYear => $clients) {
                    if ($clients && is_iterable($clients)) {
                        $totalClients += count($clients);
                        
                        // Get current month's count for percentage calculation
                        $currentDate = \Carbon\Carbon::now()->format('F Y');
                        if ($monthYear === $currentDate) {
                            $currentMonthCount = count($clients);
                        }
                        
                        foreach ($clients as $client) {
                            // Active clients
                            if (isset($client->status) && $client->status === 'active') {
                                $activeClients++;
                            }
                            
                            // Total revenue
                            if (isset($client->amount) && is_numeric($client->amount)) {
                                $totalRevenue += floatval($client->amount);
                            }
                            
                            // Upcoming reminders
                            if (isset($client->reminder_date) && $client->reminder_date) {
                                try {
                                    $reminderDate = \Carbon\Carbon::parse($client->reminder_date);
                                    if ($reminderDate->isFuture()) {
                                        $upcomingReminders++;
                                    }
                                } catch (Exception $e) {
                                    // Skip invalid dates
                                }
                            }
                        }
                    }
                }
            }
            
            // Calculate percentages safely
            $currentMonthPercentage = ($totalClients > 0) ? round(($currentMonthCount / $totalClients) * 100) : 0;
            $activeRatePercentage = ($totalClients > 0) ? round(($activeClients / $totalClients) * 100) : 0;
        @endphp

        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-users fa-lg"></i>
            </div>
            <h3 class="stat-value">{{ $totalClients }}</h3>
            <p class="stat-label">Total Clients</p>
            <div class="stat-change {{ $currentMonthCount > 0 ? 'positive' : 'negative' }}">
                <i class="fas {{ $currentMonthCount > 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                {{ $currentMonthPercentage }}% this month
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-check-circle fa-lg"></i>
            </div>
            <h3 class="stat-value">{{ $activeClients }}</h3>
            <p class="stat-label">Active Clients</p>
            <div class="stat-change {{ $activeClients > 0 ? 'positive' : 'negative' }}">
                <i class="fas {{ $activeClients > 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                {{ $activeRatePercentage }}% active rate
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-money-bill-wave fa-lg"></i>
            </div>
            <h3 class="stat-value">Rs. {{ number_format($totalRevenue, 0) }}</h3>
            <p class="stat-label">Total Revenue</p>
            <div class="stat-change {{ $totalRevenue > 0 ? 'positive' : 'negative' }}">
                <i class="fas {{ $totalRevenue > 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                All time revenue
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-bell fa-lg"></i>
            </div>
            <h3 class="stat-value">{{ $upcomingReminders }}</h3>
            <p class="stat-label">Upcoming Reminders</p>
            <div class="stat-change {{ $upcomingReminders > 0 ? 'positive' : 'negative' }}">
                <i class="fas fa-calendar-alt"></i>
                Need attention
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-card">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="filter-title">
                    <i class="fas fa-filter"></i>
                    Filter Clients by Month
                </h5>
            </div>
            <div class="col-md-6">
                <form method="GET" action="{{ route('marketing.clients.index') }}" class="month-selector">
                    <input type="month" 
                           name="month" 
                           id="month" 
                           class="month-input flex-grow-1"
                           value="{{ request('month') }}"
                           onchange="this.form.submit()">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-1"></i> Apply
                    </button>
                    @if(request('month'))
                        <a href="{{ route('marketing.clients.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Clear
                        </a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- Clients Table -->
    <div class="clients-table-container">
        @if (!$clientsByMonth || $totalClients === 0)
            <div class="empty-state">
                <i class="fas fa-inbox fa-3x mb-3"></i>
                <h4>No Clients Found</h4>
                <p class="mb-4">Get started by adding your first client</p>
                <a href="{{ route('marketing.clients.create') }}" class="btn-primary-gradient">
                    <i class="fas fa-plus me-2"></i> Add First Client
                </a>
            </div>
        @else
            @foreach ($clientsByMonth as $monthYear => $clients)
                @if($clients && count($clients) > 0)
                    <div class="month-section">
                        <div class="month-header">
                            <h3 class="month-title">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $monthYear }}
                                <span class="client-count">{{ count($clients) }}</span>
                            </h3>
                            @php
                                $fullPaymentsCount = 0;
                                foreach ($clients as $client) {
                                    if (isset($client->payment_status) && $client->payment_status === 'Full') {
                                        $fullPaymentsCount++;
                                    }
                                }
                            @endphp
                            <span class="text-muted">
                                {{ $fullPaymentsCount }} full payments
                            </span>
                        </div>

                        <div class="table-container">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Client</th>
                                            <th>Contact</th>
                                            <th>Project</th>
                                            <th>Type</th>
                                            <th>Payment</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Reminder</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($clients as $client)
                                            <tr>
                                                <td data-label="Client">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="rounded-circle bg-primary-light d-flex align-items-center justify-content-center" 
                                                                 style="width: 36px; height: 36px;">
                                                                <span class="text-primary fw-bold">
                                                                    {{ isset($client->name) ? strtoupper(substr($client->name, 0, 1)) : 'C' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <strong>{{ $client->name ?? 'Unknown' }}</strong>
                                                            <div class="text-muted small">
                                                                {{ $client->technology ?? 'No tech specified' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td data-label="Contact">
                                                    @if(isset($client->contact_number) && $client->contact_number)
                                                        <i class="fas fa-phone me-1 text-muted"></i>
                                                        {{ $client->contact_number }}
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                                <td data-label="Project">
                                                    <strong>{{ $client->project_name ?? '—' }}</strong>
                                                    @if(isset($client->note) && $client->note)
                                                        <div class="text-muted small mt-1" title="{{ $client->note }}">
                                                            <i class="fas fa-sticky-note me-1"></i>
                                                            {{ \Illuminate\Support\Str::limit($client->note, 30) }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td data-label="Type">
                                                    <span class="badge badge-info">
                                                        {{ $client->project_type ?? '—' }}
                                                    </span>
                                                </td>
                                                <td data-label="Payment">
                                                    @php
                                                        $paymentClass = 'payment-badge-none';
                                                        if (isset($client->payment_status)) {
                                                            if ($client->payment_status === 'Full') $paymentClass = 'payment-badge-full';
                                                            elseif ($client->payment_status === 'Advance') $paymentClass = 'payment-badge-advance';
                                                        }
                                                    @endphp
                                                    <span class="badge {{ $paymentClass }}">
                                                        <i class="fas fa-money-bill-wave me-1"></i>
                                                        {{ $client->payment_status ?? 'None' }}
                                                    </span>
                                                </td>
                                                <td data-label="Amount">
                                                    <strong>Rs. {{ isset($client->amount) ? number_format($client->amount, 0) : '0' }}</strong>
                                                </td>
                                                <td data-label="Status">
                                                    @php
                                                        $statusClass = 'badge-secondary';
                                                        if (isset($client->status)) {
                                                            if ($client->status === 'active') $statusClass = 'badge-success';
                                                            elseif ($client->status === 'pending') $statusClass = 'badge-warning';
                                                        }
                                                    @endphp
                                                    <span class="badge {{ $statusClass }}">
                                                        <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                                        {{ ucfirst($client->status ?? 'inactive') }}
                                                    </span>
                                                </td>
                                                <td data-label="Reminder">
                                                    @if(isset($client->reminder_date) && $client->reminder_date)
                                                        @php
                                                            try {
                                                                $reminderDate = \Carbon\Carbon::parse($client->reminder_date);
                                                                $today = \Carbon\Carbon::today();
                                                                $diffDays = $reminderDate->diffInDays($today, false);
                                                            } catch (Exception $e) {
                                                                $diffDays = 0;
                                                            }
                                                        @endphp
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-calendar-day me-2 
                                                                {{ $diffDays < 0 ? 'text-danger' : ($diffDays <= 7 ? 'text-warning' : 'text-success') }}"></i>
                                                            <div>
                                                                <div>{{ $reminderDate->format('M d, Y') ?? $client->reminder_date }}</div>
                                                                <small class="text-muted">
                                                                    @if($diffDays < 0)
                                                                        <span class="text-danger">Overdue</span>
                                                                    @elseif($diffDays == 0)
                                                                        <span class="text-warning">Today</span>
                                                                    @elseif($diffDays <= 7)
                                                                        <span class="text-warning">In {{ $diffDays }} days</span>
                                                                    @else
                                                                        <span class="text-success">Future</span>
                                                                    @endif
                                                                </small>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                                <td data-label="Actions">
                                                    @if (isset($client->edit_permission))
                                                        @if ($client->edit_permission === 'approved')
                                                            <div class="action-group">
                                                                <a href="{{ route('marketing.clients.edit', $client->id) }}" 
                                                                   class="btn-icon btn-icon-edit" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="{{ route('marketing.clients.destroy', $client->id) }}" 
                                                                      method="POST" 
                                                                      onsubmit="return confirm('Are you sure you want to delete this client?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn-icon btn-icon-delete" title="Delete">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @elseif ($client->edit_permission === 'pending')
                                                            <span class="badge-permission-pending permission-badge">
                                                                <i class="fas fa-clock me-1"></i> Pending
                                                            </span>
                                                        @elseif ($client->edit_permission === 'rejected')
                                                            <span class="badge-permission-rejected permission-badge">
                                                                <i class="fas fa-times-circle me-1"></i> Rejected
                                                            </span>
                                                        @else
                                                            <form action="{{ route('marketing.clients.request-permission', $client->id) }}" 
                                                                  method="POST">
                                                                @csrf
                                                                <button type="submit" class="btn-request" title="Request Permission">
                                                                    <i class="fas fa-key"></i> Request
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>

<script>
    // Auto-refresh page when filter changes (for better UX)
    document.getElementById('month').addEventListener('change', function() {
        if(this.value) {
            this.form.submit();
        }
    });

    // Add tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    // Add loading state to buttons
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if(submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                submitBtn.disabled = true;
            }
        });
    });

    // Auto-collapse old months if many
    const monthSections = document.querySelectorAll('.month-section');
    if(monthSections.length > 3) {
        for(let i = 3; i < monthSections.length; i++) {
            const table = monthSections[i].querySelector('table');
            if(table) {
                table.style.display = 'none';
                const toggleBtn = document.createElement('button');
                toggleBtn.className = 'btn btn-sm btn-outline-primary mt-2';
                toggleBtn.innerHTML = '<i class="fas fa-chevron-down"></i> Show Clients';
                toggleBtn.onclick = function() {
                    table.style.display = table.style.display === 'none' ? 'table' : 'none';
                    this.innerHTML = table.style.display === 'none' 
                        ? '<i class="fas fa-chevron-down"></i> Show Clients' 
                        : '<i class="fas fa-chevron-up"></i> Hide Clients';
                };
                monthSections[i].querySelector('.month-header').appendChild(toggleBtn);
            }
        }
    }
</script>
@endsection