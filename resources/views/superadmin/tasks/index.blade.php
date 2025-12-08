@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #2c5aa0;
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
    
    .tasks-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .page-header {
        background: linear-gradient(135deg, var(--primary) 0%, #1e3d72 100%);
        border-radius: var(--radius);
        padding: 30px;
        color: white;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        margin-top: 60px;
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        transform: translate(60px, -60px);
    }
    
    .page-title {
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        z-index: 2;
    }
    
    .page-title i {
        font-size: 40px;
        background: rgba(255,255,255,0.2);
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
    }
    
    .page-title h1 {
        margin: 0;
        font-weight: 700;
        font-size: 32px;
    }
    
    .page-title p {
        margin: 8px 0 0 0;
        opacity: 0.9;
        font-size: 16px;
    }
    
    /* Status Tabs */
    .status-tabs {
        display: flex;
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        margin-bottom: 30px;
        overflow: hidden;
    }
    
    .status-tab {
        flex: 1;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        border-bottom: 3px solid transparent;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }
    
    .status-tab:hover {
        background: var(--primary-light);
    }
    
    .status-tab.active {
        border-bottom-color: var(--primary);
        background: var(--primary-light);
    }
    
    .tab-icon {
        font-size: 24px;
        margin-bottom: 5px;
    }
    
    .tab-title {
        font-weight: 600;
        color: var(--dark);
        font-size: 14px;
    }
    
    .tab-count {
        background: var(--primary);
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .status-tab.ongoing .tab-icon { color: var(--info); }
    .status-tab.pending .tab-icon { color: var(--warning); }
    .status-tab.completed .tab-icon { color: var(--success); }
    .status-tab.forwarded .tab-icon { color: var(--secondary); }
    
    .status-tab.active.ongoing { border-bottom-color: var(--info); }
    .status-tab.active.pending { border-bottom-color: var(--warning); }
    .status-tab.active.completed { border-bottom-color: var(--success); }
    .status-tab.active.forwarded { border-bottom-color: var(--secondary); }
    
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
        padding: 20px 25px;
        border-bottom: 1px solid var(--border);
    }
    
    .filters-header h3 {
        margin: 0;
        color: var(--primary);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .filters-body {
        padding: 25px;
    }
    
    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .filter-group {
        margin-bottom: 0;
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
        padding: 12px 15px;
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
    
    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%236c757d' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 14px;
        padding-right: 40px;
    }
    
    .filter-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        flex-wrap: wrap;
    }
    
    .btn {
        padding: 12px 24px;
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
        background: #1e3d72;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .btn-secondary {
        background: var(--secondary);
        color: white;
    }
    
    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }
    
    /* Tasks Table */
    .table-container {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }
    
    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        background: var(--light);
        border-bottom: 1px solid var(--border);
    }
    
    .table-header h2 {
        margin: 0;
        color: var(--dark);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .table-info {
        color: var(--secondary);
        font-size: 14px;
        font-weight: 500;
    }
    
    .tasks-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .tasks-table thead {
        background: var(--light);
    }
    
    .tasks-table th {
        padding: 16px 20px;
        text-align: left;
        font-weight: 600;
        color: var(--dark);
        border-bottom: 2px solid var(--border);
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .tasks-table td {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }
    
    .tasks-table tbody tr {
        transition: all 0.3s ease;
    }
    
    .tasks-table tbody tr:hover {
        background: var(--primary-light);
    }
    
    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .badge-pending {
        background: #fff3cd;
        color: #856404;
    }
    
    .badge-forwarded {
        background: #cce7ff;
        color: #004085;
    }
    
    .badge-completed {
        background: #d4edda;
        color: #155724;
    }
    
    .badge-ongoing {
        background: #d1ecf1;
        color: #0c5460;
    }
    
    .user-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
    }
    
    .user-info h6 {
        margin: 0;
        font-weight: 600;
        color: var(--dark);
        font-size: 14px;
    }
    
    .description-cell {
        max-width: 200px;
    }
    
    .description-text {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.4;
        font-size: 14px;
        color: var(--secondary);
    }
    
    .date-cell {
        white-space: nowrap;
    }
    
    .date-value {
        font-weight: 600;
        color: var(--dark);
        font-size: 14px;
    }
    
    .date-label {
        font-size: 12px;
        color: var(--secondary);
        display: block;
    }
    /* Enhanced Task Details Panel */
.details-panel {
    position: fixed;
    top: 0;
    right: -600px;
    width: 600px;
    height: 100vh;
    background: white;
    box-shadow: -5px 0 50px rgba(0,0,0,0.15);
    transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1000;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    margin-top:60px;
}

.details-panel.open {
    right: 0;
}

.details-header {
    background: linear-gradient(135deg, var(--primary) 0%, #1e3d72 100%);
    color: white;
    padding: 30px;
    position: sticky;
    top: 0;
    z-index: 10;
    box-shadow: 0 2px 20px rgba(0,0,0,0.1);
}

.task-header-info h3 {
    margin: 0 0 15px 0;
    font-weight: 700;
    font-size: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.task-header-info h3::before {
    content: '';
    width: 4px;
    height: 24px;
    background: rgba(255,255,255,0.5);
    border-radius: 2px;
}

.task-meta {
    display: flex;
    gap: 15px;
    align-items: center;
    flex-wrap: wrap;
}

.task-id {
    background: rgba(255,255,255,0.2);
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 600;
    backdrop-filter: blur(10px);
}

.task-priority {
    background: rgba(255,255,255,0.2);
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 600;
    backdrop-filter: blur(10px);
}

.details-close {
    position: absolute;
    top: 25px;
    right: 25px;
    background: rgba(255,255,255,0.2);
    border: none;
    color: white;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
    font-size: 16px;
    backdrop-filter: blur(10px);
}

.details-close:hover {
    background: rgba(255,255,255,0.3);
    transform: rotate(90deg);
}

.details-body {
    padding: 0;
    flex: 1;
    background: #f8fafc;
}

/* Task Overview Section */
.task-overview {
    background: white;
    margin: 20px;
    padding: 25px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border-left: 4px solid var(--primary);
}

.task-title-section {
    margin-bottom: 20px;
}

.task-main-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--dark);
    margin: 0 0 10px 0;
    line-height: 1.4;
}

.task-description {
    color: var(--secondary);
    line-height: 1.6;
    font-size: 14px;
    margin: 0;
}

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin: 20px;
}

.info-card {
    background: white;
    padding: 25px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border-top: 3px solid var(--primary);
}

.info-card h4 {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0 0 20px 0;
    color: var(--primary);
    font-weight: 600;
    font-size: 16px;
}

.info-card h4 i {
    width: 20px;
    text-align: center;
}

/* Detail Items */
.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid var(--border);
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-label {
    font-weight: 600;
    color: var(--dark);
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.detail-label i {
    color: var(--primary);
    width: 16px;
    text-align: center;
    font-size: 12px;
}

.detail-value {
    text-align: right;
    color: var(--secondary);
    font-weight: 500;
    font-size: 13px;
}

/* Progress Section */
.progress-section {
    background: white;
    margin: 20px;
    padding: 25px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
}

.progress-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.progress-header h4 {
    margin: 0;
    color: var(--primary);
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.progress-percentage {
    font-weight: 700;
    color: var(--primary);
    font-size: 18px;
}

.progress-bar-container {
    height: 8px;
    background: #f0f0f0;
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 10px;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, var(--primary), #4a90e2);
    border-radius: 10px;
    transition: width 1s ease-in-out;
    position: relative;
}

.progress-bar::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.progress-stats {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    color: var(--secondary);
}

/* Timeline Section */
.timeline-section {
    background: white;
    margin: 20px;
    padding: 25px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--primary-light);
}

.timeline-item {
    position: relative;
    margin-bottom: 25px;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 0;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: var(--primary);
    border: 3px solid white;
    box-shadow: 0 0 0 3px var(--primary-light);
}

.timeline-content h5 {
    margin: 0 0 5px 0;
    font-weight: 600;
    color: var(--dark);
    font-size: 14px;
}

.timeline-content p {
    margin: 0;
    color: var(--secondary);
    font-size: 13px;
}

.timeline-date {
    font-size: 12px;
    color: var(--primary);
    font-weight: 600;
}

/* Action Buttons */
.action-section {
    background: white;
    margin: 20px;
    padding: 25px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border-top: 3px solid var(--success);
}

.action-buttons-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 12px;
}

.action-btn {
    padding: 12px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.3s;
    cursor: pointer;
    font-size: 13px;
    text-decoration: none;
}

.action-btn-primary {
    background: var(--primary);
    color: white;
}

.action-btn-primary:hover {
    background: #1e3d72;
    transform: translateY(-2px);
}

.action-btn-success {
    background: var(--success);
    color: white;
}

.action-btn-success:hover {
    background: #218838;
    transform: translateY(-2px);
}

.action-btn-warning {
    background: var(--warning);
    color: white;
}

.action-btn-warning:hover {
    background: #e0a800;
    transform: translateY(-2px);
}

.action-btn-secondary {
    background: var(--secondary);
    color: white;
}

.action-btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-2px);
}

/* Status Badges in Details */
.status-badge-large {
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

/* User Info in Details */
.user-info-detailed {
    display: flex;
    align-items: center;
    gap: 12px;
}

.user-avatar-large {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 16px;
}

.user-details h5 {
    margin: 0;
    font-weight: 600;
    color: var(--dark);
    font-size: 14px;
}

.user-details p {
    margin: 2px 0 0 0;
    color: var(--secondary);
    font-size: 12px;
}

/* Responsive Design for Details Panel */
@media (max-width: 768px) {
    .details-panel {
        width: 100%;
        right: -100%;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
        margin: 15px;
    }
    
    .task-overview,
    .progress-section,
    .timeline-section,
    .action-section {
        margin: 15px;
    }
    
    .action-buttons-grid {
        grid-template-columns: 1fr;
    }
}

/* Animation for panel opening */
@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.details-panel.open .details-body > * {
    animation: slideInRight 0.5s ease-out;
}

.details-panel.open .details-body > *:nth-child(1) { animation-delay: 0.1s; }
.details-panel.open .details-body > *:nth-child(2) { animation-delay: 0.2s; }
.details-panel.open .details-body > *:nth-child(3) { animation-delay: 0.3s; }
.details-panel.open .details-body > *:nth-child(4) { animation-delay: 0.4s; }
.details-panel.open .details-body > *:nth-child(5) { animation-delay: 0.5s; }
    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
    }
    
    .btn-action {
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        text-decoration: none;
        font-size: 12px;
        min-width: 100px;
        justify-content: center;
    }
    
    .btn-view {
        background: var(--info);
        color: white;
    }
    
    .btn-view:hover {
        background: #138496;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    
    .btn-edit {
        background: var(--warning);
        color: white;
    }
    
    .btn-edit:hover {
        background: #e0a800;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    
    /* Task Details Panel */
    .details-panel {
        position: fixed;
        top: 0;
        right: -500px;
        width: 500px;
        height: 100vh;
        background: white;
        box-shadow: -5px 0 25px rgba(0,0,0,0.1);
        transition: right 0.3s ease;
        z-index: 1000;
        overflow-y: auto;
    }
    
    .details-panel.open {
        right: 0;
    }
    
    .details-header {
        background: var(--primary);
        color: white;
        padding: 25px;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    .details-header h3 {
        margin: 0 0 10px 0;
        font-weight: 600;
    }
    
    .details-close {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(255,255,255,0.2);
        border: none;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .details-close:hover {
        background: rgba(255,255,255,0.3);
    }
    
    .details-body {
        padding: 25px;
    }
    
    .detail-section {
        margin-bottom: 30px;
    }
    
    .detail-section h4 {
        color: var(--primary);
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 2px solid var(--primary-light);
        font-weight: 600;
    }
    
    .detail-grid {
        display: grid;
        gap: 15px;
    }
    
    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 12px 0;
        border-bottom: 1px solid var(--border);
    }
    
    .detail-item:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        font-weight: 600;
        color: var(--dark);
        flex: 1;
    }
    
    .detail-value {
        flex: 1;
        text-align: right;
        color: var(--secondary);
    }
    
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 999;
        display: none;
    }
    
    .overlay.active {
        display: block;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    
    .empty-state i {
        font-size: 64px;
        color: var(--secondary);
        margin-bottom: 20px;
        opacity: 0.5;
    }
    
    .empty-state h4 {
        margin-bottom: 10px;
        color: var(--dark);
    }
    
    .empty-state p {
        color: var(--secondary);
        margin-bottom: 20px;
    }
    
    /* Results Count */
    .results-count {
        padding: 15px 25px;
        background: var(--light);
        border-top: 1px solid var(--border);
        color: var(--secondary);
        font-size: 14px;
        font-weight: 500;
    }
    
    @media (max-width: 768px) {
        .page-header {
            padding: 25px 20px;
        }
        
        .page-title {
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }
        
        .status-tabs {
            flex-direction: column;
        }
        
        .filters-grid {
            grid-template-columns: 1fr;
        }
        
        .filter-actions {
            justify-content: stretch;
        }
        
        .filter-actions .btn {
            flex: 1;
            justify-content: center;
        }
        
        .table-header {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }
        
        .tasks-table {
            display: block;
            overflow-x: auto;
        }
        
        .description-cell {
            max-width: 150px;
        }
        
        .details-panel {
            width: 100%;
            right: -100%;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-action {
            min-width: 80px;
        }
    }
    
    /* Loading Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .tasks-table tbody tr {
        animation: fadeIn 0.5s ease-out;
    }
</style>

<div class="tasks-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <i class="fas fa-tasks"></i>
            <div>
                <h1>Project Management</h1>
                <p>Monitor and manage all assigned tasks across projects</p>
            </div>
        </div>
    </div>

    <!-- Status Tabs -->
    <div class="status-tabs">
        <div class="status-tab ongoing active" data-status="all">
            <i class="fas fa-layer-group tab-icon"></i>
            <span class="tab-title">All Tasks</span>
            <span class="tab-count" id="all-count">{{ $tasks->count() }}</span>
        </div>
        <div class="status-tab ongoing" data-status="ongoing">
            <i class="fas fa-spinner tab-icon"></i>
            <span class="tab-title">Ongoing</span>
            <span class="tab-count" id="ongoing-count">0</span>
        </div>
        <div class="status-tab pending" data-status="pending">
            <i class="fas fa-clock tab-icon"></i>
            <span class="tab-title">Pending</span>
            <span class="tab-count" id="pending-count">0</span>
        </div>
        <div class="status-tab completed" data-status="completed">
            <i class="fas fa-check-circle tab-icon"></i>
            <span class="tab-title">Completed</span>
            <span class="tab-count" id="completed-count">0</span>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filters-card">
        <div class="filters-header">
            <h3><i class="fas fa-filter"></i> Filter Tasks</h3>
        </div>
        <div class="filters-body">
            <form method="GET" action="{{ route('superadmin.tasks') }}">
                <div class="filters-grid">
                    <!-- Project Filter -->
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-project-diagram"></i>Project
                        </label>
                        <select name="project_id" id="project_id" class="form-control">
                            <option value="">All Projects</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" 
                                    {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Month Filter -->
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-calendar-alt"></i>Month
                        </label>
                        <input type="month" id="month" name="month" class="form-control" 
                               value="{{ request('month') }}">
                    </div>

                    <!-- Status Filter -->
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-status"></i>Status
                        </label>
                        <select name="status" id="status" class="form-control">
                            <option value="">All Statuses</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Forwarded" {{ request('status') == 'Forwarded' ? 'selected' : '' }}>Forwarded</option>
                            <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Apply Filters
                    </button>
                    <a href="{{ route('superadmin.tasks') }}" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Reset Filters
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tasks Table -->
    <div class="table-container">
        <div class="table-header">
            <h2><i class="fas fa-list"></i> Assigned Tasks</h2>
            <div class="table-info">
                Total: <span id="table-count">{{ $tasks->count() }}</span> tasks
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="tasks-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Project</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Developer</th>
                        <th>Project Manager</th>
                        <th>Start Date</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tasks-body">
                    @forelse($tasks as $task)
                        <tr class="task-row" data-task-id="{{ $task->id }}" data-status="{{ strtolower($task->status) }}">
                            <td>
                                <strong>#{{ $task->id }}</strong>
                            </td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">
                                        {{ substr($task->project->name ?? 'N/A', 0, 1) }}
                                    </div>
                                    <div class="user-info">
                                        <h6>{{ $task->project->name ?? 'N/A' }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <strong>{{ $task->title }}</strong>
                            </td>
                            <td class="description-cell">
                                <div class="description-text" title="{{ $task->description }}">
                                    {{ $task->description }}
                                </div>
                            </td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">
                                        {{ substr($task->developer_name, 0, 1) }}
                                    </div>
                                    <div class="user-info">
                                        <h6>{{ $task->developer_name }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">
                                        {{ substr($task->project_manager_name, 0, 1) }}
                                    </div>
                                    <div class="user-info">
                                        <h6>{{ $task->project_manager_name }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td class="date-cell">
                                <span class="date-value">
                                    {{ \Carbon\Carbon::parse($task->start_date)->format('M d, Y') }}
                                </span>
                                <span class="date-label">
                                    {{ \Carbon\Carbon::parse($task->start_date)->format('D') }}
                                </span>
                            </td>
                            <td class="date-cell">
                                <span class="date-value">
                                    {{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y') }}
                                </span>
                                <span class="date-label">
                                    {{ \Carbon\Carbon::parse($task->deadline)->format('D') }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusConfig = [
                                        'Pending' => ['class' => 'badge-pending', 'icon' => 'clock'],
                                        'Forwarded' => ['class' => 'badge-forwarded', 'icon' => 'share'],
                                        'Completed' => ['class' => 'badge-completed', 'icon' => 'check-circle'],
                                        'Ongoing' => ['class' => 'badge-ongoing', 'icon' => 'spinner']
                                    ];
                                    $config = $statusConfig[$task->status] ?? $statusConfig['Pending'];
                                @endphp
                                <span class="badge {{ $config['class'] }}">
                                    <i class="fas fa-{{ $config['icon'] }}"></i>
                                    {{ $task->status }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-action btn-view" onclick="showTaskDetails({{ $task->id }})">
                                        <i class="fas fa-eye"></i> View Details
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <h4>No Tasks Found</h4>
                                    <p>No tasks match the selected filters. Try adjusting your search criteria.</p>
                                    <a href="{{ route('superadmin.tasks') }}" class="btn btn-primary">
                                        <i class="fas fa-redo"></i> Clear Filters
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Results Count -->
        <div class="results-count">
            Total Results: <span id="results-count">{{ $tasks->count() }}</span> tasks
        </div>
    </div>
</div>

<!-- Task Details Panel -->
<div class="overlay" id="details-overlay"></div>
<div class="details-panel" id="details-panel">
    <div class="details-header">
        <button class="details-close" id="details-close">
            <i class="fas fa-times"></i>
        </button>
        <div class="task-header-info">
            <h3>Task Details</h3>
            <div class="task-meta">
                <span class="task-id" id="task-id-display">#TASK-001</span>
                <span class="task-priority" id="task-priority">High Priority</span>
            </div>
        </div>
    </div>
    <div class="details-body" id="details-body">
        <!-- Details will be loaded here -->
    </div>
</div>
<!-- Font Awesome for icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize task counts
        updateTaskCounts();
       
        // Status tab functionality
        const statusTabs = document.querySelectorAll('.status-tab');
        statusTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const status = this.getAttribute('data-status');
               
                // Update active tab
                statusTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
               
                // Filter tasks
                filterTasksByStatus(status);
            });
        });
       
        // Close details panel
        document.getElementById('details-close').addEventListener('click', closeDetails);
        document.getElementById('details-overlay').addEventListener('click', closeDetails);
       
        // Tooltips for truncated descriptions
        const descriptionElements = document.querySelectorAll('.description-text');
        descriptionElements.forEach(element => {
            if (element.scrollWidth > element.clientWidth) {
                element.setAttribute('title', element.textContent);
            }
        });
       
        // Auto-submit form when certain filters change
        const autoSubmitFilters = ['project_id', 'status'];
        autoSubmitFilters.forEach(filterId => {
            const element = document.getElementById(filterId);
            if (element) {
                element.addEventListener('change', function() {
                    this.form.submit();
                });
            }
        });
    });
   
   function updateTaskCounts() {
    const tasks = document.querySelectorAll('.task-row');
    const counts = {
        'all': tasks.length,
        'ongoing': 0,
        'pending': 0,
        'completed': 0
    };
   
    tasks.forEach(task => {
        const status = task.getAttribute('data-status').toLowerCase();
        
        // Count each status
        if (status === 'pending') counts['pending']++;
        if (status === 'completed') counts['completed']++;
        if (status === 'forwarded') {
            counts['ongoing']++; // Forwarded tasks are ongoing
        }
    });
   
    // Update tab counts
    document.getElementById('all-count').textContent = counts.all;
    document.getElementById('ongoing-count').textContent = counts.ongoing;
    document.getElementById('pending-count').textContent = counts.pending;
    document.getElementById('completed-count').textContent = counts.completed;
}
   
    function filterTasksByStatus(status) {
        const tasks = document.querySelectorAll('.task-row');
        let visibleCount = 0;
       
        tasks.forEach(task => {
            const taskStatus = task.getAttribute('data-status').toLowerCase();
            let shouldShow = false;
            
            if (status === 'all') {
                shouldShow = true;
            } else if (status === 'ongoing') {
                // Ongoing shows forwarded tasks (they are the same)
                shouldShow = (taskStatus === 'forwarded');
            } else {
                // Other statuses match exactly
                shouldShow = (taskStatus === status);
            }
            
            if (shouldShow) {
                task.style.display = '';
                visibleCount++;
            } else {
                task.style.display = 'none';
            }
        });
       
        // Update counts
        document.getElementById('table-count').textContent = visibleCount;
        document.getElementById('results-count').textContent = visibleCount;
        
        // Handle empty state
        const tbody = document.getElementById('tasks-body');
        const emptyState = tbody.querySelector('.empty-state');
        
        if (visibleCount === 0 && !emptyState) {
            const emptyRow = document.createElement('tr');
            emptyRow.innerHTML = `
                <td colspan="10">
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h4>No Tasks Found</h4>
                        <p>No tasks match the selected filter.</p>
                    </div>
                </td>
            `;
            tbody.appendChild(emptyRow);
        } else if (visibleCount > 0 && emptyState) {
            emptyState.closest('tr').remove();
        }
    }
    
    function closeDetails() {
        document.getElementById('details-panel').classList.remove('open');
        document.getElementById('details-overlay').classList.remove('active');
    }

    function showTaskDetails(taskId) {
        const taskRow = document.querySelector(`[data-task-id="${taskId}"]`);
        if (!taskRow) return;
        
        // Extract task data from the row
        const taskData = {
            id: taskId,
            title: taskRow.querySelector('td:nth-child(3) strong').textContent,
            description: taskRow.querySelector('.description-text').textContent,
            project: taskRow.querySelector('.user-cell h6').textContent,
            developer: taskRow.querySelector('td:nth-child(5) .user-cell h6').textContent,
            projectManager: taskRow.querySelector('td:nth-child(6) .user-cell h6').textContent,
            startDate: taskRow.querySelector('td:nth-child(7) .date-value').textContent,
            deadline: taskRow.querySelector('td:nth-child(8) .date-value').textContent,
            status: taskRow.querySelector('.badge').textContent.trim(),
            statusClass: taskRow.querySelector('.badge').className
        };
        
        // Update details panel
        document.getElementById('task-id-display').textContent = `#TASK-${taskId.toString().padStart(3, '0')}`;
        document.getElementById('task-priority').textContent = 'High Priority';
       
        const detailsBody = document.getElementById('details-body');
        detailsBody.innerHTML = `
            <!-- Task Overview -->
            <div class="task-overview">
                <div class="task-title-section">
                    <h2 class="task-main-title">${taskData.title}</h2>
                    <p class="task-description">${taskData.description}</p>
                </div>
                <div class="detail-item">
                    <span class="detail-label">
                        <i class="fas fa-tag"></i>Current Status
                    </span>
                    <span class="detail-value">
                        <span class="status-badge-large ${taskData.statusClass}">
                            <i class="fas fa-${getStatusIcon(taskData.status)}"></i>
                            ${taskData.status}
                        </span>
                    </span>
                </div>
            </div>
            
            <!-- Information Grid -->
            <div class="info-grid">
                <!-- Project Information -->
                <div class="info-card">
                    <h4><i class="fas fa-project-diagram"></i> Project Details</h4>
                    <div class="detail-item">
                        <span class="detail-label">Project Name</span>
                        <span class="detail-value">${taskData.project}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Project Type</span>
                        <span class="detail-value">Web Application</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Client</span>
                        <span class="detail-value">ABC Corporation</span>
                    </div>
                </div>
                
                <!-- Team Information -->
                <div class="info-card">
                    <h4><i class="fas fa-users"></i> Team Assignment</h4>
                    <div class="detail-item">
                        <span class="detail-label">Developer</span>
                        <span class="detail-value">
                            <div class="user-info-detailed">
                                <div class="user-avatar-large">
                                    ${taskData.developer.charAt(0)}
                                </div>
                                <div class="user-details">
                                    <h5>${taskData.developer}</h5>
                                    <p>Senior Developer</p>
                                </div>
                            </div>
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Project Manager</span>
                        <span class="detail-value">
                            <div class="user-info-detailed">
                                <div class="user-avatar-large">
                                    ${taskData.projectManager.charAt(0)}
                                </div>
                                <div class="user-details">
                                    <h5>${taskData.projectManager}</h5>
                                    <p>Project Lead</p>
                                </div>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Progress Section -->
            <div class="progress-section">
                <div class="progress-header">
                    <h4><i class="fas fa-chart-line"></i> Progress Tracking</h4>
                    <div class="progress-percentage">75%</div>
                </div>
                <div class="progress-bar-container">
                    <div class="progress-bar" style="width: 75%"></div>
                </div>
                <div class="progress-stats">
                    <span>Started: ${taskData.startDate}</span>
                    <span>Deadline: ${taskData.deadline}</span>
                </div>
            </div>
            
            <!-- Timeline Section -->
            <div class="timeline-section">
                <h4><i class="fas fa-history"></i> Activity Timeline</h4>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h5>Task Created</h5>
                            <p>Task was assigned and added to the system</p>
                            <div class="timeline-date">${taskData.startDate}</div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h5>Development Started</h5>
                            <p>Developer began working on the task</p>
                            <div class="timeline-date">2 days later</div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h5>Code Review</h5>
                            <p>Code submitted for review and testing</p>
                            <div class="timeline-date">In Progress</div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Show details panel
        document.getElementById('details-panel').classList.add('open');
        document.getElementById('details-overlay').classList.add('active');
        
        // Animate progress bar
        setTimeout(() => {
            const progressBar = document.querySelector('.progress-bar');
            if (progressBar) progressBar.style.width = '75%';
        }, 100);
    }

    // Helper function for status icons
    function getStatusIcon(status) {
        const icons = {
            'Pending': 'clock',
            'Forwarded': 'spinner',
            'Completed': 'check-circle',
            'Ongoing': 'spinner'
        };
        return icons[status] || 'clock';
    }
</script>

@endsection