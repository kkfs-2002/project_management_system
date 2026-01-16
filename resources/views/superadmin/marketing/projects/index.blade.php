@extends('layouts.app')
@section('title', 'Marketing Projects')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    :root {
        --primary: #2c5aa0;
        --primary-dark: #1e3d72;
        --secondary: #6c757d;
        --success: #28a745;
        --warning: #ffc107;
        --danger: #dc3545;
        --info: #17a2b8;
        --light: #f8f9fa;
        --dark: #343a40;
        --border: #dee2e6;
        --shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
   
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
   
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f7fa;
        color: #333;
        line-height: 1.6;
    }
   
    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }
   
    .header {
        text-align: center;
        margin-bottom: 30px;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: var(--shadow);
        margin-top: 90px;
    }
   
    .header h1 {
        color: var(--primary);
        margin-bottom: 10px;
        font-weight: 600;
    }
   
    .header p {
        color: var(--secondary);
        font-size: 16px;
    }
    /* Reminder Alerts Container */
    .reminder-alerts-container {
        margin-bottom: 20px;
    }
    .reminder-alert {
        color: #2c3e50;
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        border-left: 4px solid;
        transition: all 0.3s ease;
        animation: slideIn 0.5s ease-out;
    }
   
    @keyframes slideIn {
        from {
            transform: translateX(-20px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
   
    .reminder-alert.hidden {
        display: none;
    }
   
    .reminder-alert i {
        font-size: 24px;
        margin-right: 15px;
    }
   
    .reminder-alert-content {
        flex: 1;
    }
   
    .reminder-alert h4 {
        margin-bottom: 5px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }
   
    .reminder-alert p {
        margin-bottom: 0;
        font-size: 14px;
    }
   
    .reminder-count {
        display: inline-block;
        background: rgba(0,0,0,0.1);
        padding: 2px 8px;
        border-radius: 10px;
        margin: 0 3px;
        font-weight: bold;
        font-size: 12px;
    }
   
    /* Week indicator */
    .reminder-week {
        margin-top: 8px;
        padding: 5px 10px;
        background: rgba(0,0,0,0.1);
        border-radius: 6px;
        font-size: 12px;
        display: inline-block;
        font-weight: 500;
    }
   
    /* Light Colors for Week Styles */
    .reminder-alert.week-1 {
        background: linear-gradient(135deg, #87CEEB, #B0E0E6);
        border-left-color: #4682B4;
    }
   
    .reminder-alert.week-2 {
        background: linear-gradient(135deg, #98FB98, #90EE90);
        border-left-color: #32CD32;
    }
   
    .reminder-alert.week-3 {
        background: linear-gradient(135deg, #FFDAB9, #FFE4B5);
        border-left-color: #FFA500;
    }
   
    .reminder-alert.week-4 {
        background: linear-gradient(135deg, #FFB6C1, #FFC0CB);
        border-left-color: #FF69B4;
    }
   
    .reminder-alert.overdue {
        background: linear-gradient(135deg, #FF7F7F, #FF9999);
        border-left-color: #FF4500;
        animation: pulse 2s infinite;
    }
   
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.8; }
        100% { opacity: 1; }
    }
   
    /* Alert Controls */
    .alert-controls {
        display: flex;
        gap: 10px;
        align-items: center;
    }
   
    .dismiss-btn {
        background: rgba(0,0,0,0.1);
        border: 1px solid rgba(0,0,0,0.2);
        color: #2c3e50;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
    }
   
    .dismiss-btn:hover {
        background: rgba(0,0,0,0.2);
        transform: rotate(90deg);
    }
   
    .snooze-btn {
        background: rgba(0,0,0,0.1);
        border: 1px solid rgba(0,0,0,0.2);
        color: #2c3e50;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 5px;
    }
   
    .snooze-btn:hover {
        background: rgba(0,0,0,0.2);
    }
   
    /* Auto-Removal Panel */
    .auto-removal-panel {
        margin-top: 20px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid var(--info);
    }
   
    .auto-removal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
   
    .auto-removal-header h4 {
        color: var(--info);
        margin: 0;
    }
   
    .auto-removal-toggle {
        padding: 5px 15px;
        background: var(--info);
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s;
    }
   
    .auto-removal-toggle.on {
        background: var(--success);
    }
   
    .auto-removal-info {
        margin: 0;
        font-size: 13px;
        color: #666;
        display: flex;
        align-items: center;
        gap: 5px;
    }
   
    .filters-card {
        background: white;
        border-radius: 10px;
        box-shadow: var(--shadow);
        padding: 25px;
        margin-bottom: 20px;
    }
    .filters-title {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        color: var(--primary);
        font-weight: 600;
        font-size: 18px;
    }
    .filters-title i {
        margin-right: 10px;
    }
    .filters-row {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: flex-end;
    }
    .filter-group {
        flex: 1;
        min-width: 200px;
    }
    .filter-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: var(--dark);
        font-size: 14px;
    }
    .filter-control {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid var(--border);
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s;
    }
    .filter-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.1);
    }
    .btn-filter {
        padding: 10px 25px;
        background-color: var(--primary);
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        height: 42px;
    }
    .btn-filter:hover {
        background-color: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    .btn-reset {
        padding: 10px 25px;
        background-color: var(--secondary);
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        height: 42px;
    }
    .btn-reset:hover {
        background-color: #5a6268;
    }
    .projects-card {
        background: white;
        border-radius: 10px;
        box-shadow: var(--shadow);
        padding: 25px;
    }
    .projects-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e9ecef;
    }
    .projects-title {
        display: flex;
        align-items: center;
        color: var(--primary);
        font-weight: 600;
        font-size: 20px;
    }
    .projects-title i {
        margin-right: 10px;
    }
    .btn-add {
        padding: 10px 20px;
        background-color: var(--success);
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-add:hover {
        background-color: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    .table-responsive {
        overflow-x: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    thead {
        background-color: #f8f9fa;
    }
    th {
        padding: 12px;
        text-align: left;
        font-weight: 600;
        color: var(--dark);
        border-bottom: 2px solid var(--border);
        white-space: nowrap;
    }
    td {
        padding: 12px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }
    tr:hover {
        background-color: #f8f9fa;
    }
    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }
    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }
    .status-in_progress {
        background-color: #d1ecf1;
        color: #0c5460;
    }
    .status-completed {
        background-color: #d4edda;
        color: #155724;
    }
    .status-hold {
        background-color: #f8d7da;
        color: #721c24;
    }
    .status-cancelled {
        background-color: #e2e3e5;
        color: #383d41;
    }
    .action-buttons {
        display: flex;
        gap: 8px;
    }
    .btn-action {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .btn-view {
        background-color: var(--info);
        color: white;
    }
    .btn-view:hover {
        background-color: #138496;
    }
    .btn-edit {
        background-color: var(--warning);
        color: #000;
    }
    .btn-edit:hover {
        background-color: #e0a800;
    }
    .call-info {
        font-size: 12px;
        color: var(--secondary);
    }
    .price {
        font-weight: 600;
        color: var(--success);
    }
    .no-data {
        text-align: center;
        padding: 40px;
        color: var(--secondary);
    }
    .no-data i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        animation: fadeIn 0.3s;
    }
    .modal.active {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .modal-content {
        background: white;
        border-radius: 10px;
        padding: 30px;
        max-width: 600px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        animation: slideUp 0.3s;
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e9ecef;
    }
    .modal-title {
        font-size: 22px;
        font-weight: 600;
        color: var(--primary);
    }
    .close-modal {
        font-size: 28px;
        cursor: pointer;
        color: var(--secondary);
        background: none;
        border: none;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .close-modal:hover {
        color: var(--danger);
    }
    .detail-row {
        display: flex;
        margin-bottom: 15px;
        padding: 10px;
        border-radius: 6px;
        background-color: #f8f9fa;
    }
    .detail-label {
        font-weight: 600;
        min-width: 180px;
        color: var(--dark);
    }
    .detail-value {
        color: var(--secondary);
        flex: 1;
    }
    .status-section {
        margin-top: 25px;
        padding: 20px;
        background-color: #fff3cd;
        border-radius: 6px;
        border-left: 4px solid var(--warning);
    }
    .status-section h3 {
        margin-bottom: 15px;
        color: var(--dark);
        font-size: 18px;
    }
    .status-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .btn-status {
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-status-hold {
        background-color: var(--danger);
        color: white;
    }
    .btn-status-hold:hover {
        background-color: #c82333;
    }
    .btn-status-complete {
        background-color: var(--success);
        color: white;
    }
    .btn-status-complete:hover {
        background-color: #218838;
    }
    .btn-status:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .status-info {
        margin-top: 10px;
        font-size: 13px;
        color: #856404;
    }
    /* Notification Styles */
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        color: white;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 9999;
        animation: slideInRight 0.3s ease-out;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .notification.success {
        background: var(--success);
    }
    .notification.warning {
        background: var(--warning);
        color: #000;
    }
    .notification.info {
        background: var(--info);
    }
    .notification.error {
        background: var(--danger);
    }
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOutRight {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes slideUp {
        from {
            transform: translateY(50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    @media (max-width: 768px) {
        .filters-row {
            flex-direction: column;
        }
        .filter-group {
            min-width: 100%;
        }
        .table-responsive {
            font-size: 14px;
        }
        th, td {
            padding: 8px;
        }
        .action-buttons {
            flex-direction: column;
        }
        .detail-row {
            flex-direction: column;
        }
        .detail-label {
            margin-bottom: 5px;
        }
    }
    .alert-success {
        padding: 15px;
        background-color: #d4edda;
        color: #155724;
        border-radius: 6px;
        margin-bottom: 20px;
        border-left: 4px solid var(--success);
        display: none;
    }
    .alert-success.show {
        display: block;
    }
    .btn-delete {
        background-color: var(--danger);
        color: white;
    }
    .btn-delete:hover {
        background-color: #c82333;
    }
    /* Confirmation Modal Styles */
    .confirm-modal {
        display: none;
        position: fixed;
        z-index: 1100;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        animation: fadeIn 0.3s;
    }
    .confirm-modal.active {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .confirm-modal-content {
        background: white;
        border-radius: 10px;
        padding: 30px;
        max-width: 450px;
        width: 90%;
        animation: slideUp 0.3s;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .confirm-modal-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }
    .confirm-modal-header i {
        font-size: 24px;
        color: var(--danger);
        margin-right: 15px;
    }
    .confirm-modal-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--danger);
    }
    .confirm-modal-body {
        margin-bottom: 25px;
        line-height: 1.6;
        color: #555;
    }
    .confirm-modal-buttons {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
    }
    .btn-cancel {
        padding: 10px 25px;
        background-color: var(--secondary);
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-cancel:hover {
        background-color: #5a6268;
    }
    .btn-confirm-delete {
        padding: 10px 25px;
        background-color: var(--danger);
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-confirm-delete:hover {
        background-color: #c82333;
    }
</style>
<div class="container">
    <div class="header">
        <h1><i class="fas fa-chart-line"></i> Marketing Projects Dashboard</h1>
        <p>View and manage all marketing projects</p>
    </div>
    @if(session('success'))
    <div class="alert-success show">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif
    <!-- Reminder Alerts Section -->
    <div class="reminder-alerts-container">
        @php
            use Carbon\Carbon;
            $today = Carbon::today();
         
            // Count reminders by status
            $overdueReminders = 0;
            $week1Reminders = 0;
            $week2Reminders = 0;
            $week3Reminders = 0;
            $week4Reminders = 0;
         
            foreach($projects as $project) {
                if($project->reminder_date) {
                    $reminderDate = Carbon::parse($project->reminder_date);
                 
                    // Check if overdue
                    if($reminderDate->lt($today)) {
                        $overdueReminders++;
                    } else {
                        // Calculate week difference from today
                        $weekDifference = floor($today->diffInDays($reminderDate) / 7);
                     
                        if($weekDifference == 0) {
                            $week1Reminders++;
                        } elseif($weekDifference == 1) {
                            $week2Reminders++;
                        } elseif($weekDifference == 2) {
                            $week3Reminders++;
                        } elseif($weekDifference >= 3) {
                            $week4Reminders++;
                        }
                    }
                }
            }
        @endphp
        <!-- Week 1 Alert - Auto-hidden if Week 4 exists -->
        @if($week1Reminders > 0 && $week4Reminders == 0)
        <div id="reminderAlert-week-1" class="reminder-alert week-1">
            <i class="fas fa-calendar-week"></i>
            <div class="reminder-alert-content">
                <h4>
                    This Week Reminders
                    <span class="reminder-count">{{ $week1Reminders }}</span>
                </h4>
                <p>Project reminder(s) are due this week</p>
                <div class="reminder-week">Due within 7 days</div>
            </div>
            <div class="alert-controls">
                <button onclick="snoozeReminder('week-1')" class="snooze-btn" title="Snooze for 1 day">
                    <i class="fas fa-clock"></i> Snooze
                </button>
                <button onclick="dismissReminderAlert('week-1')" class="dismiss-btn" title="Dismiss">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        @endif
        <!-- Week 2 Alert -->
        @if($week2Reminders > 0)
        <div id="reminderAlert-week-2" class="reminder-alert week-2">
            <i class="fas fa-calendar-alt"></i>
            <div class="reminder-alert-content">
                <h4>
                    Next Week Reminders
                    <span class="reminder-count">{{ $week2Reminders }}</span>
                </h4>
                <p>Project reminder(s) are due next week</p>
                <div class="reminder-week">Due within 8-14 days</div>
            </div>
            <div class="alert-controls">
                <button onclick="snoozeReminder('week-2')" class="snooze-btn" title="Snooze for 1 day">
                    <i class="fas fa-clock"></i> Snooze
                </button>
                <button onclick="dismissReminderAlert('week-2')" class="dismiss-btn" title="Dismiss">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        @endif
        <!-- Week 3 Alert -->
        @if($week3Reminders > 0)
        <div id="reminderAlert-week-3" class="reminder-alert week-3">
            <i class="fas fa-calendar-check"></i>
            <div class="reminder-alert-content">
                <h4>
                    Week 3 Reminders
                    <span class="reminder-count">{{ $week3Reminders }}</span>
                </h4>
                <p>Project reminder(s) are due in two weeks</p>
                <div class="reminder-week">Due within 15-21 days</div>
            </div>
            <div class="alert-controls">
                <button onclick="snoozeReminder('week-3')" class="snooze-btn" title="Snooze for 1 day">
                    <i class="fas fa-clock"></i> Snooze
                </button>
                <button onclick="dismissReminderAlert('week-3')" class="dismiss-btn" title="Dismiss">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        @endif
        <!-- Week 4 Alert -->
        @if($week4Reminders > 0)
        <div id="reminderAlert-week-4" class="reminder-alert week-4">
            <i class="fas fa-calendar-times"></i>
            <div class="reminder-alert-content">
                <h4>
                    Final Week Reminders
                    <span class="reminder-count">{{ $week4Reminders }}</span>
                </h4>
                <p>Project reminder(s) are due in three weeks or more</p>
                <div class="reminder-week">Due after 21+ days</div>
            </div>
            <div class="alert-controls">
                <button onclick="snoozeReminder('week-4')" class="snooze-btn" title="Snooze for 1 day">
                    <i class="fas fa-clock"></i> Snooze
                </button>
                <button onclick="dismissReminderAlert('week-4')" class="dismiss-btn" title="Dismiss">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        @endif
        <!-- Overdue Alerts -->
        @if($overdueReminders > 0)
        <div id="reminderAlert-overdue" class="reminder-alert overdue">
            <i class="fas fa-exclamation-triangle"></i>
            <div class="reminder-alert-content">
                <h4>
                    Overdue Reminders
                    <span class="reminder-count">{{ $overdueReminders }}</span>
                </h4>
                <p>Project reminder(s) have passed their due date</p>
                <div class="reminder-week">Urgent attention needed</div>
            </div>
            <div class="alert-controls">
                <button onclick="snoozeReminder('overdue')" class="snooze-btn" title="Snooze for 1 day">
                    <i class="fas fa-clock"></i> Snooze
                </button>
                <button onclick="dismissReminderAlert('overdue')" class="dismiss-btn" title="Dismiss">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        @endif
        <!-- Auto-Removal Info Panel (informational only, since auto-hiding is now server-side) -->
        @if($week4Reminders > 0 && $week1Reminders > 0)
        <div class="auto-removal-panel">
            <div class="auto-removal-header">
                <h4><i class="fas fa-robot"></i> Auto-Hide Active</h4>
            </div>
            <p class="auto-removal-info">
                <i class="fas fa-info-circle"></i> Week 1 reminders automatically hidden due to presence of Week 4 reminders.
            </p>
        </div>
        @endif
    </div>
    <!-- Filters -->
    <div class="filters-card">
        <div class="filters-title">
            <i class="fas fa-filter"></i> Filter Projects
        </div>
        <form action="{{ route('superadmin.marketing.projects.index') }}" method="GET">
            <div class="filters-row">
                <div class="filter-group">
                    <label for="manager">Marketing Manager</label>
                    <select name="manager" id="manager" class="filter-control">
                        <option value="">All Managers</option>
                        @foreach($managers as $manager)
                            <option value="{{ $manager->employee_id }}" {{ request('manager') == $manager->employee_id ? 'selected' : '' }}>
                                {{ $manager->user->name ?? $manager->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="filter-control">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="hold" {{ request('status') == 'hold' ? 'selected' : '' }}>Hold</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="project_type">Project Type</label>
                    <select name="project_type" id="project_type" class="filter-control">
                        <option value="">All Types</option>
                        <option value="web" {{ request('project_type') == 'web' ? 'selected' : '' }}>Web Development</option>
                        <option value="mobile_app" {{ request('project_type') == 'mobile_app' ? 'selected' : '' }}>Mobile App</option>
                        <option value="graphic_design" {{ request('project_type') == 'graphic_design' ? 'selected' : '' }}>Graphic Design</option>
                        <option value="social_media" {{ request('project_type') == 'social_media' ? 'selected' : '' }}>Social Media</option>
                        <option value="seo" {{ request('project_type') == 'seo' ? 'selected' : '' }}>SEO Services</option>
                        <option value="branding" {{ request('project_type') == 'branding' ? 'selected' : '' }}>Branding</option>
                        <option value="video_production" {{ request('project_type') == 'video_production' ? 'selected' : '' }}>Video Production</option>
                        <option value="content_writing" {{ request('project_type') == 'content_writing' ? 'selected' : '' }}>Content Writing</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="date_from">Date From</label>
                    <input type="date" name="date_from" id="date_from" class="filter-control" value="{{ request('date_from') }}">
                </div>
                <div class="filter-group">
                    <label for="date_to">Date To</label>
                    <input type="date" name="date_to" id="date_to" class="filter-control" value="{{ request('date_to') }}">
                </div>
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn-filter">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('superadmin.marketing.projects.index') }}" class="btn-reset">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
    <!-- Projects Table -->
    <div class="projects-card">
        <div class="projects-header">
            <div class="projects-title">
                <i class="fas fa-list"></i> Projects List ({{ $projects->count() }})
            </div>
            <a href="{{ route('superadmin.clients.add') }}" class="btn-add">
                <i class="fas fa-plus"></i> Add New Project
            </a>
        </div>
        <div class="table-responsive">
            @if($projects->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client Name</th>
                        <th>Phone</th>
                        <th>Project Type</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Manager</th>
                        <th>Status</th>
                        <th>Call Info</th>
                        <th>Date</th>
                        <th>Reminder</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $project)
                    <tr>
                        <td>#{{ $project->id }}</td>
                        <td><strong>{{ $project->client_name }}</strong></td>
                        <td>{{ $project->phone_number }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $project->project_type)) }}</td>
                        <td>{{ $project->project_category }}</td>
                        <td class="price">LKR {{ number_format($project->project_price, 2) }}</td>
                        <td>{{ $project->marketingManager->user->name ?? $project->marketingManager->full_name ?? 'N/A' }}</td>
                        <td>
                            <span class="status-badge status-{{ $project->status }}">
                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                            </span>
                        </td>
                        <td>
                            <div class="call-info">
                                <strong>{{ $project->call_sequence }} Call</strong><br>
                                {{ $project->contact_method }}
                            </div>
                        </td>
                        <td>{{ $project->date->format('d M Y') }}</td>
                        <td>
                            @if($project->reminder_date)
                                @php
                                    $reminderDate = \Carbon\Carbon::parse($project->reminder_date);
                                    $today = \Carbon\Carbon::today();
                                @endphp
                               
                                @if($reminderDate->lt($today))
                                    <span style="color: #dc3545; font-size: 11px; background: #f8d7da; padding: 3px 8px; border-radius: 10px;">
                                        <i class="fas fa-exclamation-circle"></i> {{ $reminderDate->format('d M') }}
                                    </span>
                                @elseif($reminderDate->eq($today))
                                    <span style="color: #ffc107; font-size: 11px; background: #fff3cd; padding: 3px 8px; border-radius: 10px;">
                                        <i class="fas fa-bell"></i> Today
                                    </span>
                                @else
                                    <span style="color: #17a2b8; font-size: 11px; background: #d1ecf1; padding: 3px 8px; border-radius: 10px;">
                                        <i class="fas fa-clock"></i> {{ $reminderDate->format('d M') }}
                                    </span>
                                @endif
                            @else
                                <span style="color: #6c757d; font-size: 11px; background: #e2e3e5; padding: 3px 8px; border-radius: 10px;">
                                    <i class="fas fa-ban"></i> None
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action btn-view" onclick="viewProject({{ $project->id }})">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <a href="{{ route('superadmin.marketing.projects.edit', $project->id) }}"
                                   class="btn-action btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button class="btn-action btn-delete" onclick="confirmDelete({{ $project->id }})">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="no-data">
                <i class="fas fa-inbox"></i>
                <p>No projects found</p>
            </div>
            @endif
        </div>
    </div>
</div>
<!-- View Project Modal -->
<div id="projectModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Project Details</h2>
            <button class="close-modal" onclick="closeModal()">&times;</button>
        </div>
        <div id="modalBody">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>
<!-- Delete Confirmation Modal -->
<div id="confirmDeleteModal" class="confirm-modal">
    <div class="confirm-modal-content" id="confirmModalBody">
        <!-- Content will be loaded here -->
    </div>
</div>
<script>
    const projects = @json($projects);
  
    // Show notification function
    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            ${message}
        `;
       
        document.body.appendChild(notification);
       
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease-out';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }
  
    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        // Load dismissed alerts
        const dismissedAlerts = JSON.parse(localStorage.getItem('dismissedAlerts') || '[]');
        dismissedAlerts.forEach(week => {
            const alert = document.getElementById(`reminderAlert-${week}`);
            if (alert) {
                alert.classList.add('hidden');
            }
        });
       
        // Load snoozed alerts
        const snoozedAlerts = JSON.parse(localStorage.getItem('snoozedAlerts') || '{}');
        Object.keys(snoozedAlerts).forEach(week => {
            if (snoozedAlerts[week] > Date.now()) {
                const alert = document.getElementById(`reminderAlert-${week}`);
                if (alert) {
                    alert.style.opacity = '0.5';
                }
            }
        });
       
        // Auto-hide success message
        setTimeout(() => {
            const alert = document.querySelector('.alert-success.show');
            if (alert) {
                alert.classList.remove('show');
            }
        }, 5000);
    });
  
    // Dismiss reminder alert
    function dismissReminderAlert(week) {
        const alert = document.getElementById(`reminderAlert-${week}`);
        if (alert) {
            alert.classList.add('hidden');
           
            // Store dismissal in localStorage
            const dismissedAlerts = JSON.parse(localStorage.getItem('dismissedAlerts') || '[]');
            if (!dismissedAlerts.includes(week)) {
                dismissedAlerts.push(week);
                localStorage.setItem('dismissedAlerts', JSON.stringify(dismissedAlerts));
            }
           
            showNotification(`Reminder alert for ${week} dismissed`, 'info');
        }
    }
  
    // Snooze reminder alert
    function snoozeReminder(week) {
        const alert = document.getElementById(`reminderAlert-${week}`);
        if (alert) {
            alert.style.opacity = '0.5';
           
            // Store snooze in localStorage for 1 day
            const snoozedAlerts = JSON.parse(localStorage.getItem('snoozedAlerts') || '{}');
            snoozedAlerts[week] = Date.now() + (24 * 60 * 60 * 1000);
            localStorage.setItem('snoozedAlerts', JSON.stringify(snoozedAlerts));
           
            showNotification(`Reminder for ${week} snoozed for 24 hours`, 'info');
           
            // Hide for 1 day
            setTimeout(() => {
                if (alert) {
                    alert.style.opacity = '1';
                    delete snoozedAlerts[week];
                    localStorage.setItem('snoozedAlerts', JSON.stringify(snoozedAlerts));
                }
            }, 24 * 60 * 60 * 1000);
        }
    }
  
    // Original project view function
    function viewProject(id) {
        const project = projects.find(p => p.id === id);
        if (!project) return;
        const createdDate = new Date(project.created_at);
        const currentDate = new Date();
        const daysDifference = Math.floor((currentDate - createdDate) / (1000 * 60 * 60 * 24));
        const canChangeStatus = daysDifference <= 30;
        const modalBody = document.getElementById('modalBody');
        modalBody.innerHTML = `
            <div class="detail-row">
                <div class="detail-label">Client Name:</div>
                <div class="detail-value">${project.client_name}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Phone Number:</div>
                <div class="detail-value">${project.phone_number}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Project Type:</div>
                <div class="detail-value">${project.project_type.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Project Category:</div>
                <div class="detail-value">${project.project_category}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Project Price:</div>
                <div class="detail-value price">LKR ${parseFloat(project.project_price).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Contact Method:</div>
                <div class="detail-value">${project.contact_method}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Call Sequence:</div>
                <div class="detail-value">${project.call_sequence} Call</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">1st Call Date:</div>
                <div class="detail-value">${project.first_call_date || 'Not set'}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">2nd Call Date:</div>
                <div class="detail-value">${project.second_call_date || 'Not set'}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">3rd Call Date:</div>
                <div class="detail-value">${project.third_call_date || 'Not set'}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Reminder Date:</div>
                <div class="detail-value">
                    ${project.reminder_date
                        ? new Date(project.reminder_date).toLocaleDateString('en-GB', {day: '2-digit', month: 'short', year: 'numeric'})
                        : 'Not set'}
                    ${project.reminder_date
                        ? (new Date(project.reminder_date) < new Date()
                            ? '<br><span style="color: #dc3545; font-size: 12px;"><i class="fas fa-exclamation-circle"></i> Reminder date has passed</span>'
                            : new Date(project.reminder_date).toDateString() === new Date().toDateString()
                                ? '<br><span style="color: #ffc107; font-size: 12px;"><i class="fas fa-bell"></i> Reminder is today!</span>'
                                : '<br><span style="color: #17a2b8; font-size: 12px;"><i class="fas fa-clock"></i> Reminder pending</span>'
                        )
                        : ''}
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Marketing Manager:</div>
                <div class="detail-value">${project.marketing_manager?.user?.name || project.marketing_manager?.full_name || 'N/A'}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Date:</div>
                <div class="detail-value">${new Date(project.date).toLocaleDateString('en-GB', {day: '2-digit', month: 'short', year: 'numeric'})}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Current Status:</div>
                <div class="detail-value">
                    <span class="status-badge status-${project.status}">
                        ${project.status.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}
                    </span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Comments:</div>
                <div class="detail-value">${project.comments}</div>
            </div>
            <div class="status-section">
                <h3><i class="fas fa-cog"></i> Change Project Status</h3>
                <p class="status-info">
                    ${canChangeStatus
                        ? '<i class="fas fa-info-circle"></i> You can change the status to Hold or Completed within 30 days of project creation.'
                        : '<i class="fas fa-exclamation-triangle"></i> Status change is only available within 30 days of project creation (Created: ' + daysDifference + ' days ago)'}
                </p>
                <form action="/superadmin/marketing/projects/${project.id}/status" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="status-buttons">
                        <button type="submit" name="status" value="hold" class="btn-status btn-status-hold" ${!canChangeStatus ? 'disabled' : ''}>
                            <i class="fas fa-pause-circle"></i> Mark as Hold
                        </button>
                        <button type="submit" name="status" value="completed" class="btn-status btn-status-complete" ${!canChangeStatus ? 'disabled' : ''}>
                            <i class="fas fa-check-circle"></i> Mark as Completed
                        </button>
                    </div>
                </form>
            </div>
        `;
        document.getElementById('projectModal').classList.add('active');
    }
  
    function closeModal() {
        document.getElementById('projectModal').classList.remove('active');
    }
  
    // Delete Confirmation
    function confirmDelete(id) {
        const project = projects.find(p => p.id === id);
        if (!project) return;
       
        const modal = document.getElementById('confirmDeleteModal');
        const modalBody = document.getElementById('confirmModalBody');
       
        modalBody.innerHTML = `
            <div class="confirm-modal-header">
                <i class="fas fa-exclamation-triangle"></i>
                <h2 class="confirm-modal-title">Confirm Deletion</h2>
            </div>
            <div class="confirm-modal-body">
                <p>Are you sure you want to delete the project for <strong>${project.client_name}</strong>?</p>
                <p style="color: #dc3545; font-size: 14px; margin-top: 10px;">
                    <i class="fas fa-exclamation-circle"></i> This action cannot be undone.
                </p>
            </div>
            <div class="confirm-modal-buttons">
                <button class="btn-cancel" onclick="closeConfirmModal()">Cancel</button>
                <form id="deleteForm${id}" action="/superadmin/marketing/projects/${id}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-confirm-delete">
                        <i class="fas fa-trash"></i> Delete Project
                    </button>
                </form>
            </div>
        `;
       
        modal.classList.add('active');
    }
  
    function closeConfirmModal() {
        document.getElementById('confirmDeleteModal').classList.remove('active');
    }
  
    // Close modals when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('projectModal');
        if (event.target == modal) {
            closeModal();
        }
       
        const confirmModal = document.getElementById('confirmDeleteModal');
        if (event.target == confirmModal) {
            closeConfirmModal();
        }
    };
</script>
@endsection
