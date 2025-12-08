<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Client Management Report</title>
    <style>
        /* Base Styles */
        @page {
            margin: 40px 30px;
        }
        
        body {
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            font-size: 10px;
            color: #333;
            line-height: 1.4;
            background: #ffffff;
        }
        
        /* Header Section */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #0066cc;
        }
        
        .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .logo {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #0066cc 0%, #0044aa 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
        }
        
        .company-info h1 {
            margin: 0;
            font-size: 18px;
            color: #0066cc;
            font-weight: 600;
        }
        
        .company-info p {
            margin: 2px 0 0 0;
            color: #666;
            font-size: 9px;
        }
        
        .report-info {
            text-align: right;
        }
        
        .report-title {
            font-size: 20px;
            color: #1a365d;
            font-weight: 600;
            margin: 0 0 5px 0;
        }
        
        .report-subtitle {
            font-size: 12px;
            color: #666;
            margin: 0 0 8px 0;
        }
        
        .report-date {
            font-size: 9px;
            color: #888;
            background: #f8fbff;
            padding: 4px 10px;
            border-radius: 4px;
            display: inline-block;
        }
        
        /* Filter Badges */
        .filter-badges {
            margin: 15px 0 20px 0;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 8px;
            font-weight: 500;
            display: inline-block;
        }
        
        .badge-primary {
            background: #e6f0ff;
            color: #0066cc;
            border: 1px solid #c5d5ff;
        }
        
        .badge-secondary {
            background: #f0f7ff;
            color: #4a5568;
            border: 1px solid #e1e8ff;
        }
        
        /* Summary Cards */
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin: 20px 0 30px 0;
        }
        
        .card {
            background: #f8fbff;
            border: 1px solid #e1e8ff;
            border-radius: 8px;
            padding: 12px;
            text-align: center;
        }
        
        .card-value {
            font-size: 18px;
            font-weight: 700;
            color: #0066cc;
            margin: 0;
        }
        
        .card-label {
            font-size: 9px;
            color: #666;
            margin: 4px 0 0 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Table Styles */
        .table-container {
            margin: 25px 0;
            overflow: hidden;
            border-radius: 8px;
            border: 1px solid #e1e8ff;
        }
        
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 9px;
        }
        
        thead {
            background: linear-gradient(135deg, #0066cc 0%, #0044aa 100%);
        }
        
        thead th {
            color: white;
            font-weight: 600;
            padding: 12px 8px;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-right: 1px solid rgba(255,255,255,0.1);
        }
        
        thead th:last-child {
            border-right: none;
        }
        
        tbody tr {
            border-bottom: 1px solid #e1e8ff;
            transition: background-color 0.2s;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f8fbff;
        }
        
        tbody tr:hover {
            background-color: #e6f0ff;
        }
        
        tbody td {
            padding: 10px 8px;
            text-align: left;
            vertical-align: top;
            border-right: 1px solid #e1e8ff;
            color: #333;
        }
        
        tbody td:last-child {
            border-right: none;
        }
        
        /* Status Badges */
        .status-badge {
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: 500;
            display: inline-block;
            min-width: 60px;
            text-align: center;
        }
        
        .status-active {
            background: #c6f6d5;
            color: #22543d;
            border: 1px solid #9ae6b4;
        }
        
        .status-pending {
            background: #fefcbf;
            color: #975a16;
            border: 1px solid #faf089;
        }
        
        .status-inactive {
            background: #fed7d7;
            color: #c53030;
            border: 1px solid #fc8181;
        }
        
        /* Payment Status */
        .payment-status {
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: 500;
            display: inline-block;
            min-width: 70px;
            text-align: center;
        }
        
        .payment-full {
            background: #e6fffa;
            color: #234e52;
            border: 1px solid #81e6d9;
        }
        
        .payment-advance {
            background: #e6f0ff;
            color: #2c5282;
            border: 1px solid #90cdf4;
        }
        
        .payment-none {
            background: #fff5f5;
            color: #c53030;
            border: 1px solid #fc8181;
        }
        
        /* Project Type */
        .project-type {
            font-weight: 500;
            color: #2d3748;
        }
        
        /* Note Styling */
        .note-cell {
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .note-cell:hover {
            white-space: normal;
            overflow: visible;
            position: relative;
            z-index: 100;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 8px;
            border-radius: 4px;
        }
        
        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e1e8ff;
            text-align: center;
            color: #666;
            font-size: 8px;
        }
        
        .footer-info {
            display: flex;
            justify-content: space-between;
            margin-top: 8px;
        }
        
        .page-info {
            font-size: 8px;
            color: #888;
            text-align: right;
            margin-top: 20px;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #666;
            font-size: 11px;
        }
        
        .empty-state svg {
            width: 40px;
            height: 40px;
            fill: #cbd5e0;
            margin-bottom: 10px;
        }
        
        /* Column Specific Styles */
        .client-name {
            font-weight: 600;
            color: #2d3748;
        }
        
        .contact-cell {
            font-family: 'Courier New', monospace;
            color: #4a5568;
        }
        
        .date-cell {
            color: #666;
            white-space: nowrap;
        }
        
        .reminder-cell {
            font-weight: 500;
        }
        
        .reminder-upcoming {
            color: #2b6cb0;
            font-weight: 600;
        }
        
        .reminder-past {
            color: #c53030;
            font-weight: 600;
        }
        
        /* Page Break Avoidance */
        .avoid-break {
            page-break-inside: avoid;
        }
        
        /* Column Widths */
        .col-name { width: 12%; }
        .col-contact { width: 10%; }
        .col-project { width: 12%; }
        .col-type { width: 8%; }
        .col-payment { width: 10%; }
        .col-status { width: 8%; }
        .col-reminder { width: 10%; }
        .col-note { width: 15%; }
        .col-created { width: 10%; }
        
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo-section">
            <div class="logo">CM</div>
            <div class="company-info">
                <h1>Client Management System</h1>
                <p>Professional Client Management & Reporting</p>
                <p>{{ config('app.name', 'Your Company') }}</p>
            </div>
        </div>
        
        <div class="report-info">
            <h2 class="report-title">Client Management Report</h2>
            <p class="report-subtitle">
                {{ $month ? \Carbon\Carbon::parse($month)->format('F Y') . ' Report' : 'Complete Client List' }}
            </p>
            <div class="report-date">
                Generated: {{ \Carbon\Carbon::now()->format('M d, Y h:i A') }}
            </div>
        </div>
    </div>
    
    <!-- Filter Badges -->
    <div class="filter-badges">
        <span class="badge badge-primary">
            {{ $clients->count() }} Client{{ $clients->count() !== 1 ? 's' : '' }}
        </span>
        
        @if($month)
            <span class="badge badge-secondary">
                Period: {{ \Carbon\Carbon::parse($month)->format('F Y') }}
            </span>
        @else
            <span class="badge badge-secondary">All Time Records</span>
        @endif
        
        @php
            $activeCount = $clients->where('status', 'active')->count();
            $pendingCount = $clients->where('status', 'pending')->count();
        @endphp
        
        <span class="badge badge-primary">
            Active: {{ $activeCount }}
        </span>
        
        <span class="badge badge-secondary">
            Pending: {{ $pendingCount }}
        </span>
    </div>
    
    <!-- Summary Cards -->
    <div class="summary-cards avoid-break">
        <div class="card">
            <p class="card-value">{{ $clients->count() }}</p>
            <p class="card-label">Total Clients</p>
        </div>
        
        <div class="card">
            <p class="card-value">{{ $clients->where('payment_status', 'Full')->count() }}</p>
            <p class="card-label">Full Payments</p>
        </div>
        
        <div class="card">
            <p class="card-value">
                @php
                    $upcomingReminders = $clients->filter(function($client) {
                        return $client->reminder_date && 
                               \Carbon\Carbon::parse($client->reminder_date)->isFuture();
                    })->count();
                @endphp
                {{ $upcomingReminders }}
            </p>
            <p class="card-label">Upcoming Reminders</p>
        </div>
        
        <div class="card">
            <p class="card-value">
                {{ $clients->where('project_type', 'Website')->count() }}
            </p>
            <p class="card-label">Website Projects</p>
        </div>
    </div>
    
    <!-- Main Table -->
    <div class="table-container avoid-break">
        <table>
            <thead>
                <tr>
                    <th class="col-name">Client Name</th>
                    <th class="col-contact">Contact</th>
                    <th class="col-project">Project</th>
                    <th class="col-type">Type</th>
                    <th class="col-payment">Payment</th>
                    <th class="col-status">Status</th>
                    <th class="col-reminder">Reminder</th>
                    <th class="col-note">Note</th>
                    <th class="col-created">Created</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($clients as $client)
                    @php
                        $reminderClass = '';
                        if ($client->reminder_date) {
                            $reminderDate = \Carbon\Carbon::parse($client->reminder_date);
                            $today = \Carbon\Carbon::today();
                            
                            if ($reminderDate->isPast()) {
                                $reminderClass = 'reminder-past';
                            } elseif ($reminderDate->diffInDays($today) <= 7) {
                                $reminderClass = 'reminder-upcoming';
                            }
                        }
                    @endphp
                    
                    <tr>
                        <td class="client-name">{{ $client->name }}</td>
                        <td class="contact-cell">{{ $client->contact_number ?: '—' }}</td>
                        <td>{{ $client->project_name ?: '—' }}</td>
                        <td class="project-type">{{ $client->project_type }}</td>
                        <td>
                            @php
                                $paymentClass = 'payment-none';
                                if ($client->payment_status === 'Full') $paymentClass = 'payment-full';
                                elseif ($client->payment_status === 'Advance') $paymentClass = 'payment-advance';
                            @endphp
                            <span class="payment-status {{ $paymentClass }}">
                                {{ $client->payment_status }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusClass = 'status-inactive';
                                if ($client->status === 'active') $statusClass = 'status-active';
                                elseif ($client->status === 'pending') $statusClass = 'status-pending';
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                {{ ucfirst($client->status) }}
                            </span>
                        </td>
                        <td class="reminder-cell {{ $reminderClass }}">
                            @if($client->reminder_date)
                                {{ \Carbon\Carbon::parse($client->reminder_date)->format('M d, Y') }}
                                @if(\Carbon\Carbon::parse($client->reminder_date)->isPast())
                                    <br><small>(Overdue)</small>
                                @elseif(\Carbon\Carbon::parse($client->reminder_date)->diffInDays(\Carbon\Carbon::today()) <= 7)
                                    <br><small>(Upcoming)</small>
                                @endif
                            @else
                                —
                            @endif
                        </td>
                        <td class="note-cell">{{ $client->note ?: '—' }}</td>
                        <td class="date-cell">{{ $client->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M19 5v14H5V5h14m0-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/>
                                    <path d="M0 0h24v24H0z" fill="none"/>
                                </svg>
                                <p>No clients found for the selected period</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Footer -->
    <div class="footer">
        <div class="footer-info">
            <div>
                <strong>Report ID:</strong> CMS-{{ date('Ymd') }}-{{ str_pad($clients->count(), 4, '0', STR_PAD_LEFT) }}
            </div>
            <div>
                <strong>Page:</strong> <span class="page-number">1</span>
            </div>
        </div>
        <p>Confidential - For internal use only • © {{ date('Y') }} Client Management System</p>
        <p>Generated by: {{ Auth::user()->name ?? 'System' }} • Data as of {{ \Carbon\Carbon::now()->format('F j, Y') }}</p>
    </div>
    
    <div class="page-info">
        Page 1 of 1 • Generated with Client Management System v1.0
    </div>
    
    <script type="text/javascript">
        // Add page numbers for multi-page PDFs
        window.onload = function() {
            var totalPages = Math.ceil(document.querySelectorAll('tbody tr').length / 25);
            if (totalPages > 1) {
                document.querySelector('.page-number').textContent = '1 of ' + totalPages;
                document.querySelector('.page-info').textContent = 
                    'Page 1 of ' + totalPages + ' • Generated with Client Management System v1.0';
            }
        };
    </script>
</body>
</html>