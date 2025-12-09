@extends('layouts.marketing')

@section('title', 'Reminder Management')

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

    .reminders-container {
        background: #f5f9ff;
        min-height: 100vh;
        padding: 30px;
    }

    /* Header Section */
    .reminders-header {
        background: white;
        border-radius: 16px;
        padding: 25px 30px;
        margin-bottom: 30px;
        box-shadow: 0 4px 20px rgba(0, 102, 204, 0.08);
        border: 1px solid var(--border-color);
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
    .stat-icon.orange { background: #ffedd5; color: #f97316; }
    .stat-icon.red { background: #fee2e2; color: #ef4444; }
    .stat-icon.green { background: #d1fae5; color: #10b981; }

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

    .filter-controls {
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
        flex-grow: 1;
    }

    .month-input:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .btn-view-hidden {
        background: var(--light-bg);
        color: var(--danger);
        border: 2px solid #fee2e2;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-view-hidden:hover {
        background: #fee2e2;
        transform: translateY(-2px);
        color: var(--danger);
    }

    .btn-filter {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 102, 204, 0.25);
        color: white;
    }

    .btn-clear {
        background: #e5e7eb;
        color: #4b5563;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .btn-clear:hover {
        background: #d1d5db;
        transform: translateY(-2px);
        color: #4b5563;
    }

    /* Reminders Table */
    .reminders-table-container {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--border-color);
    }

    .table-header {
        background: var(--light-bg);
        padding: 20px 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid var(--border-color);
    }

    .table-title {
        color: var(--dark-text);
        font-weight: 600;
        font-size: 18px;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .table-title i {
        color: var(--primary-blue);
    }

    .table-count {
        background: var(--primary-blue);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
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

    /* Reminder Status Badges */
    .reminder-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-upcoming {
        background: #fef3c7;
        color: #92400e;
    }

    .status-today {
        background: #fef3c7;
        color: #92400e;
        animation: pulse 2s infinite;
    }

    .status-overdue {
        background: #fee2e2;
        color: #991b1b;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.7; }
        100% { opacity: 1; }
    }

    /* Action Buttons */
    .action-buttons-small {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-confirm {
        background: #d1fae5;
        color: #065f46;
    }

    .btn-confirm:hover {
        background: #a7f3d0;
        transform: translateY(-2px);
    }

    .btn-cancel {
        background: #fee2e2;
        color: #dc2626;
    }

    .btn-cancel:hover {
        background: #fecaca;
        transform: translateY(-2px);
    }

    /* Client Info */
    .client-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--primary-light);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: var(--primary-blue);
        font-size: 16px;
    }

    .client-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .client-details {
        display: flex;
        flex-direction: column;
    }

    .client-name {
        font-weight: 600;
        color: var(--dark-text);
    }

    .client-contact {
        font-size: 12px;
        color: var(--light-text);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Note Styling */
    .note-preview {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: var(--light-text);
    }

    .note-preview:hover {
        white-space: normal;
        overflow: visible;
        position: absolute;
        background: white;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        z-index: 100;
        max-width: 300px;
    }

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

    /* Modal Styling */
    .modal-content {
        border-radius: 12px;
        border: 1px solid var(--border-color);
    }

    .modal-header {
        background: var(--light-bg);
        border-bottom: 1px solid var(--border-color);
        padding: 20px 24px;
    }

    .modal-title {
        color: var(--dark-text);
        font-weight: 600;
    }

    .modal-body {
        padding: 24px;
    }

    .form-label {
        color: var(--dark-text);
        font-weight: 500;
        margin-bottom: 8px;
    }

    .modal-footer {
        border-top: 1px solid var(--border-color);
        padding: 20px 24px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .reminders-container {
            padding: 20px 15px;
        }

        .stats-container {
            grid-template-columns: 1fr;
        }

        .header-title {
            font-size: 24px;
        }

        .filter-controls {
            flex-direction: column;
            align-items: stretch;
        }

        .action-buttons {
            flex-direction: column;
            align-items: stretch;
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

        .action-buttons-small {
            justify-content: flex-end;
        }
    }

    /* Animation */
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

    .reminders-header, .stats-container, .filter-card, .reminders-table-container {
        animation: fadeIn 0.5s ease-out;
    }
</style>

<div class="reminders-container">
    <!-- Header -->
    <div class="reminders-header">
        <h1 class="header-title">
            <i class="fas fa-bell"></i>
            Reminder Management
        </h1>
        <p class="header-subtitle">
            Track and manage client reminders
            @if(request('month'))
                • Filtered for {{ \Carbon\Carbon::parse(request('month'))->format('F Y') }}
            @endif
        </p>
    </div>

    <!-- Stats Cards -->
    <div class="stats-container">
        @php
            $today = \Carbon\Carbon::today();
            $upcomingCount = 0;
            $overdueCount = 0;
            $todayCount = 0;
            $totalReminders = $clients->count();
            
            foreach ($clients as $client) {
                if ($client->reminder_date) {
                    $reminderDate = \Carbon\Carbon::parse($client->reminder_date);
                    if ($reminderDate->isToday()) {
                        $todayCount++;
                    } elseif ($reminderDate->isPast()) {
                        $overdueCount++;
                    } else {
                        $upcomingCount++;
                    }
                }
            }
        @endphp

        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-bell fa-lg"></i>
            </div>
            <h3 class="stat-value">{{ $totalReminders }}</h3>
            <p class="stat-label">Total Reminders</p>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-exclamation-triangle fa-lg"></i>
            </div>
            <h3 class="stat-value">{{ $todayCount }}</h3>
            <p class="stat-label">Due Today</p>
        </div>

        <div class="stat-card">
            <div class="stat-icon red">
                <i class="fas fa-clock fa-lg"></i>
            </div>
            <h3 class="stat-value">{{ $overdueCount }}</h3>
            <p class="stat-label">Overdue</p>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-calendar-plus fa-lg"></i>
            </div>
            <h3 class="stat-value">{{ $upcomingCount }}</h3>
            <p class="stat-label">Upcoming</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-card">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="filter-title">
                    <i class="fas fa-filter"></i>
                    Filter Reminders
                </h5>
            </div>
            <div class="col-md-6">
                <form action="{{ route('marketing.clients.reminders') }}" method="GET" class="filter-controls">
                    <input type="month" 
                           name="month" 
                           id="month" 
                           class="month-input"
                           value="{{ request('month') }}"
                           onchange="this.form.submit()">
                    <button type="submit" class="btn-filter">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    @if(request('month'))
                        <a href="{{ route('marketing.clients.reminders') }}" class="btn-clear">
                            <i class="fas fa-times me-1"></i> Clear
                        </a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('marketing.clients.cancelled') }}" class="btn-view-hidden">
            <i class="fas fa-eye-slash me-1"></i> View Hidden Clients
        </a>
    </div>

    <!-- Reminders Table -->
    <div class="reminders-table-container">
        @if ($clients->isEmpty())
            <div class="empty-state">
                <i class="fas fa-bell-slash fa-3x mb-3"></i>
                <h4>No Reminders Found</h4>
                <p class="mb-4">No clients with reminders for the selected period</p>
            </div>
        @else
            <div class="table-header">
                <h3 class="table-title">
                    <i class="fas fa-list"></i>
                    Client Reminders
                    <span class="table-count">{{ $clients->count() }}</span>
                </h3>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Reminder Date</th>
                            <th>Note</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            @php
                                $reminderDate = $client->reminder_date ? \Carbon\Carbon::parse($client->reminder_date) : null;
                                $statusClass = 'status-upcoming';
                                $statusText = 'Upcoming';
                                
                                if ($reminderDate) {
                                    if ($reminderDate->isToday()) {
                                        $statusClass = 'status-today';
                                        $statusText = 'Due Today';
                                    } elseif ($reminderDate->isPast()) {
                                        $statusClass = 'status-overdue';
                                        $statusText = 'Overdue';
                                    } elseif ($reminderDate->diffInDays($today) <= 7) {
                                        $statusClass = 'status-today';
                                        $statusText = 'This Week';
                                    }
                                }
                            @endphp
                            <tr>
                                <td data-label="Client">
                                    <div class="client-info">
                                        <div class="client-avatar">
                                            {{ strtoupper(substr($client->name, 0, 1)) }}
                                        </div>
                                        <div class="client-details">
                                            <div class="client-name">{{ $client->name }}</div>
                                            @if($client->contact_number)
                                                <div class="client-contact">
                                                    <i class="fas fa-phone"></i>
                                                    {{ $client->contact_number }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Reminder Date">
                                    @if($reminderDate)
                                        <div class="d-flex flex-column">
                                            <strong>{{ $reminderDate->format('M d, Y') }}</strong>
                                            <small class="text-muted">
                                                @if($reminderDate->isToday())
                                                    <span class="text-warning">Today</span>
                                                @elseif($reminderDate->isPast())
                                                    <span class="text-danger">
                                                        {{ $reminderDate->diffForHumans() }}
                                                    </span>
                                                @else
                                                    <span class="text-success">
                                                        in {{ $reminderDate->diffForHumans() }}
                                                    </span>
                                                @endif
                                            </small>
                                        </div>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td data-label="Note">
                                    <div class="note-preview" title="{{ $client->note }}">
                                        {{ $client->note ? \Illuminate\Support\Str::limit($client->note, 50) : '—' }}
                                    </div>
                                </td>
                                <td data-label="Status">
                                    <span class="reminder-status {{ $statusClass }}">
                                        <i class="fas fa-circle" style="font-size: 8px;"></i>
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td data-label="Actions">
                                    <div class="action-buttons-small">
                                        <!-- Confirm Button -->
                                        <form method="POST" action="{{ route('marketing.clients.confirm', $client->id) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn-action btn-confirm" title="Confirm Client">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>

                                        <!-- Cancel Button -->
                                        <button class="btn-action btn-cancel" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#cancelModal{{ $client->id }}"
                                                title="Cancel Client">
                                            <i class="fas fa-eye-slash"></i>
                                        </button>
                                    </div>

                                    <!-- Cancel Modal -->
                                    <div class="modal fade" id="cancelModal{{ $client->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Cancel Client</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form method="POST" action="{{ route('marketing.clients.cancel', $client->id) }}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Client Details</label>
                                                            <div class="alert alert-info">
                                                                <strong>{{ $client->name }}</strong><br>
                                                                <small>{{ $client->contact_number }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Reason for Cancellation *</label>
                                                            <textarea name="cancel_reason" 
                                                                      class="form-control" 
                                                                      rows="4" 
                                                                      placeholder="Enter the reason for cancelling this client..."
                                                                      required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-eye-slash me-1"></i> Cancel Client
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<script>
    // Auto-submit filter on month change
    document.getElementById('month').addEventListener('change', function() {
        if(this.value) {
            this.form.submit();
        }
    });

    // Add loading state to confirm buttons
    document.querySelectorAll('form[action*="confirm"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if(submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                submitBtn.disabled = true;
            }
        });
    });

    // Show note preview on hover
    document.querySelectorAll('.note-preview').forEach(note => {
        note.addEventListener('mouseenter', function() {
            if(this.scrollWidth > this.offsetWidth) {
                this.style.whiteSpace = 'normal';
                this.style.overflow = 'visible';
                this.style.position = 'absolute';
                this.style.background = 'white';
                this.style.padding = '10px';
                this.style.borderRadius = '8px';
                this.style.boxShadow = '0 4px 15px rgba(0,0,0,0.1)';
                this.style.zIndex = '100';
                this.style.maxWidth = '300px';
            }
        });
        
        note.addEventListener('mouseleave', function() {
            this.style.whiteSpace = 'nowrap';
            this.style.overflow = 'hidden';
            this.style.position = 'static';
            this.style.background = 'transparent';
            this.style.padding = '0';
            this.style.boxShadow = 'none';
            this.style.maxWidth = '200px';
        });
    });

    // Sort table by reminder date (most urgent first)
    document.addEventListener('DOMContentLoaded', function() {
        const table = document.querySelector('table');
        if(table) {
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            
            // Sort rows by date urgency (today -> overdue -> upcoming)
            rows.sort((a, b) => {
                const statusA = a.querySelector('.reminder-status').textContent;
                const statusB = b.querySelector('.reminder-status').textContent;
                
                const priority = {
                    'Overdue': 1,
                    'Due Today': 2,
                    'This Week': 3,
                    'Upcoming': 4
                };
                
                return (priority[statusA] || 5) - (priority[statusB] || 5);
            });
            
            // Reorder rows
            rows.forEach(row => tbody.appendChild(row));
        }
    });
</script>
@endsection