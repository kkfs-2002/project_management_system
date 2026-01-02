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
    
    .finance-container {
        max-width: 1200px;
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
        margin-top: 90px;
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
    
    .filters-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 20px;
        flex-wrap: wrap;
    }
    
    .filter-group {
        flex: 1;
        min-width: 250px;
    }
    
    .filter-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--dark);
        font-size: 14px;
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
    
    .btn-success {
        background: var(--success);
        color: white;
    }
    
    .btn-success:hover {
        background: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .btn-outline {
        background: white;
        color: var(--primary);
        border: 2px solid var(--primary);
    }
    
    .btn-outline:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
        color: var(--primary);
    }
    
    /* Projects List */
    .projects-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    
    .project-card {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border-left: 5px solid var(--primary);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .project-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .project-header {
        padding: 25px;
        border-bottom: 1px solid var(--border);
    }
    
    .project-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }
    
    .project-details h4 {
        margin: 0 0 5px 0;
        font-weight: 600;
        color: var(--dark);
    }
    
    .project-details .project-type {
        color: var(--secondary);
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .project-actions {
        display: flex;
        gap: 12px;
        align-items: center;
    }
    
    .badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .badge-success {
        background: #d4edda;
        color: #155724;
    }
    
    .badge-outline {
        background: white;
        color: var(--primary);
        border: 2px solid var(--primary);
    }
    
    /* Financial Form - Fixed Size */
    .financial-form-container {
        padding: 25px;
        background: var(--light);
        border-top: 1px solid var(--border);
    }
    
    .financial-form {
        max-width: 900px;
        margin: 0 auto;
        background: white;
        padding: 30px;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
    }
    
    .form-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--primary-light);
    }
    
    .form-header i {
        color: var(--primary);
        font-size: 20px;
    }
    
    .form-header h5 {
        margin: 0;
        color: var(--primary);
        font-weight: 600;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }
    
    .form-group {
        margin-bottom: 0;
    }
    
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--dark);
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .form-label i {
        color: var(--primary);
        width: 16px;
        text-align: center;
    }
    
    .form-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }
    
    .btn-sm {
        padding: 10px 20px;
        font-size: 13px;
    }
    
    /* Financial Summary */
    .financial-summary {
        background: var(--primary-light);
        border-radius: var(--radius);
        padding: 20px;
        margin-top: 20px;
    }
    
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }
    
    .summary-item {
        text-align: center;
        padding: 15px;
        background: white;
        border-radius: 8px;
        border: 1px solid var(--border);
    }
    
    .summary-label {
        font-size: 12px;
        color: var(--secondary);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }
    
    .summary-value {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary);
    }
    
    /* Auto Calculation Display */
    .calculation-display {
        background: #f8f9fa;
        border-radius: var(--radius);
        padding: 20px;
        margin: 20px 0;
        border-left: 4px solid var(--success);
    }
    
    .calculation-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }
    
    .calculation-item {
        text-align: center;
        padding: 12px;
        background: white;
        border-radius: 6px;
        border: 1px solid var(--border);
    }
    
    .calculation-label {
        font-size: 11px;
        color: var(--secondary);
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 4px;
    }
    
    .calculation-value {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
    }
    
    .calculation-value.profit {
        color: var(--success);
    }
    
    .calculation-value.balance {
        color: var(--primary);
    }
    
    /* Date Display */
    .date-display {
        display: flex;
        gap: 20px;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid var(--border);
    }
    
    .date-item {
        flex: 1;
        text-align: center;
        padding: 10px;
        background: white;
        border-radius: 6px;
        border: 1px solid var(--border);
    }
    
    .date-label {
        font-size: 11px;
        color: var(--secondary);
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 4px;
    }
    
    .date-value {
        font-size: 14px;
        font-weight: 600;
        color: var(--dark);
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
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
    
    /* Success Alert */
    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        border-radius: var(--radius);
        padding: 15px 20px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .alert-success i {
        font-size: 18px;
    }
    
    @media (max-width: 768px) {
        .filters-row {
            flex-direction: column;
            align-items: stretch;
        }
        
        .filter-group {
            min-width: auto;
        }
        
        .project-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .project-actions {
            width: 100%;
            justify-content: flex-start;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            justify-content: stretch;
        }
        
        .form-actions .btn {
            flex: 1;
            justify-content: center;
        }
        
        .summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .calculation-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .date-display {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>

<div class="finance-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <i class="fas fa-chart-line"></i>
            <div>
                <h1>Project Finance Management</h1>
                <p>Track and manage financial details for all projects</p>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Filters Section -->
    <div class="filters-card">
        <div class="filters-header">
            <h3><i class="fas fa-filter"></i> Filter Projects</h3>
        </div>
        <div class="filters-body">
            <form method="GET">
                <div class="filters-row">
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-calendar-alt"></i> Select Month
                        </label>
                        <input type="month" name="month" value="{{ $month }}" class="form-control" required>
                    </div>
                    <div class="filter-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Apply Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Projects List -->
    <div class="projects-list">
        @forelse($projects as $project)
            <div class="project-card">
                <div class="project-header">
                    <div class="project-info">
                        <div class="project-details">
                            <h4>{{ $project->name }}</h4>
                            <div class="project-type">
                                <i class="fas fa-tag"></i> {{ $project->type }}
                            </div>
                        </div>
                        <div class="project-actions">
                            @if (!$project->account)
                                <button class="btn btn-outline btn-sm" onclick="toggleForm('{{ $project->id }}')" id="btn-{{ $project->id }}">
                                    <i class="fas fa-plus"></i> Add Financial Details
                                </button>
                            @else
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle"></i> Financials Added
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                @if ($project->account)
                    <!-- Financial Summary -->
                    <div class="financial-summary">
                        <div class="summary-grid">
                            <div class="summary-item">
                                <div class="summary-label">Total Payment</div>
                                <div class="summary-value">Rs{{ number_format($project->account->total_payment, 2) }}</div>
                            </div>
                            <div class="summary-item">
                                <div class="summary-label">Advance Paid</div>
                                <div class="summary-value">Rs{{ number_format($project->account->advance, 2) }}</div>
                            </div>
                            <div class="summary-item">
                                <div class="summary-label">Hosting Fee</div>
                                <div class="summary-value">Rs{{ number_format($project->account->hosting_fee, 2) }}</div>
                            </div>
                            <div class="summary-item">
                                <div class="summary-label">Developer Fee</div>
                                <div class="summary-value">Rs{{ number_format($project->account->developer_fee, 2) }}</div>
                            </div>
                            <div class="summary-item">
                                <div class="summary-label">Profit</div>
                                <div class="summary-value" style="color: var(--success);">Rs{{ number_format($project->account->profit, 2) }}</div>
                            </div>
                            <div class="summary-item">
                                <div class="summary-label">Balance</div>
                                <div class="summary-value" style="color: var(--primary);">Rs{{ number_format($project->account->balance, 2) }}</div>
                            </div>
                        </div>
                        
                        <!-- Dates Display -->
                        <div class="date-display">
                            <div class="date-item">
                                <div class="date-label">Added Date</div>
                                <div class="date-value">{{ \Carbon\Carbon::parse($project->account->created_at)->format('M d, Y') }}</div>
                            </div>
                            <div class="date-item">
                                <div class="date-label">Renewal Date</div>
                                <div class="date-value">{{ \Carbon\Carbon::parse($project->account->renewal_date)->format('M d, Y') }}</div>
                            </div>
                        </div>
                    </div>
                @else
                   <!-- Financial Form - Enhanced with Auto Calculations -->
<div class="financial-form-container" id="form-{{ $project->id }}" style="display:none;">
    <div class="financial-form">
        <div class="form-header">
            <i class="fas fa-money-bill-wave"></i>
            <h5>Add Financial Details - {{ $project->name }}</h5>
        </div>
        
        <form action="{{ route('superadmin.project.financials.store') }}" method="POST" id="financial-form-{{ $project->id }}">
            @csrf
            <input type="hidden" name="project_id" value="{{ $project->id }}">

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-dollar-sign"></i>Total Payment
                    </label>
                    <input type="number" name="total_payment" class="form-control calculate-total" 
                           placeholder="0.00" step="0.01" min="0" required 
                           data-project="{{ $project->id }}">
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-hand-holding-usd"></i>Advance Payment
                    </label>
                    <input type="number" name="advance" class="form-control calculate-advance" 
                           placeholder="0.00" step="0.01" min="0" required
                           data-project="{{ $project->id }}">
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-server"></i>Hosting Fee
                    </label>
                    <input type="number" name="hosting_fee" class="form-control calculate-costs" 
                           placeholder="0.00" step="0.01" min="0" required
                           data-project="{{ $project->id }}">
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-code"></i>Developer Fee
                    </label>
                    <input type="number" name="developer_fee" class="form-control calculate-costs" 
                           placeholder="0.00" step="0.01" min="0" required
                           data-project="{{ $project->id }}">
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-calendar-day"></i>Renewal Date
                    </label>
                    <input type="date" name="renewal_date" class="form-control" required>
                </div>
            </div>

            <!-- Auto Calculation Display -->
            <div class="calculation-display" id="calculation-{{ $project->id }}">
                <div class="calculation-grid">
                    <div class="calculation-item">
                        <div class="calculation-label">Total Costs</div>
                        <div class="calculation-value" id="total-costs-{{ $project->id }}">Rs0.00</div>
                    </div>
                    <div class="calculation-item">
                        <div class="calculation-label">Profit</div>
                        <div class="calculation-value profit" id="profit-{{ $project->id }}">Rs0.00</div>
                    </div>
                    <div class="calculation-item">
                        <div class="calculation-label">Balance Due</div>
                        <div class="calculation-value balance" id="balance-{{ $project->id }}">Rs0.00</div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-outline btn-sm" onclick="toggleForm('{{ $project->id }}')">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-save"></i> Save Financial Details
                </button>
            </div>
        </form>
    </div>
</div>
                                <!-- Auto Calculation Display -->
                                <div class="calculation-display" id="calculation-{{ $project->id }}">
                                    <div class="calculation-grid">
                                        <div class="calculation-item">
                                            <div class="calculation-label">Total Costs</div>
                                            <div class="calculation-value" id="total-costs-{{ $project->id }}">$0.00</div>
                                        </div>
                                        <div class="calculation-item">
                                            <div class="calculation-label">Profit</div>
                                            <div class="calculation-value profit" id="profit-{{ $project->id }}">$0.00</div>
                                        </div>
                                        <div class="calculation-item">
                                            <div class="calculation-label">Balance Due</div>
                                            <div class="calculation-value balance" id="balance-{{ $project->id }}">$0.00</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="button" class="btn btn-outline btn-sm" onclick="toggleForm('{{ $project->id }}')">
                                        <i class="fas fa-times"></i> Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-save"></i> Save Financial Details
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-folder-open"></i>
                <h4>No Projects Found</h4>
                <p>No projects available for the selected month.</p>
                <a href="{{ route('superadmin.project.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create Your First Project
                </a>
            </div>
        @endforelse
    </div>
</div>

<script>
    function toggleForm(projectId) {
        const form = document.getElementById(`form-${projectId}`);
        const btn = document.getElementById(`btn-${projectId}`);

        if (form && btn) {
            if (form.style.display === 'none') {
                form.style.display = 'block';
                btn.style.display = 'none';
            } else {
                form.style.display = 'none';
                btn.style.display = 'flex';
            }
        }
    }

    // Auto calculation functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize calculations for all forms
        document.querySelectorAll('.financial-form').forEach(form => {
            const projectId = form.querySelector('input[name="project_id"]').value;
            calculateFinancials(projectId);
        });

        // Add event listeners for calculation inputs
        document.querySelectorAll('.calculate-total, .calculate-advance, .calculate-costs').forEach(input => {
            input.addEventListener('input', function() {
                const projectId = this.getAttribute('data-project');
                calculateFinancials(projectId);
            });
        });

        // Add input formatting for currency fields
        const currencyInputs = document.querySelectorAll('input[type="number"]');
        currencyInputs.forEach(input => {
            input.addEventListener('focus', function() {
                if (this.value === '0' || this.value === '') {
                    this.value = '';
                }
            });
            
            input.addEventListener('blur', function() {
                if (this.value === '') {
                    this.value = '0';
                }
            });
        });
    });

    function calculateFinancials(projectId) {
        const form = document.getElementById(`financial-form-${projectId}`);
        if (!form) return;

        // Get input values
        const totalPayment = parseFloat(form.querySelector('input[name="total_payment"]').value) || 0;
        const advance = parseFloat(form.querySelector('input[name="advance"]').value) || 0;
        const hostingFee = parseFloat(form.querySelector('input[name="hosting_fee"]').value) || 0;
        const developerFee = parseFloat(form.querySelector('input[name="developer_fee"]').value) || 0;

        // Calculate values
        const totalCosts = hostingFee + developerFee;
        const profit = totalPayment - totalCosts;
        const balance = totalPayment - advance;

        // Update display
        document.getElementById(`total-costs-${projectId}`).textContent = `$${totalCosts.toFixed(2)}`;
        document.getElementById(`profit-${projectId}`).textContent = `$${profit.toFixed(2)}`;
        document.getElementById(`balance-${projectId}`).textContent = `$${balance.toFixed(2)}`;

        // Update colors based on values
        const profitElement = document.getElementById(`profit-${projectId}`);
        const balanceElement = document.getElementById(`balance-${projectId}`);

        profitElement.className = profit >= 0 ? 'calculation-value profit' : 'calculation-value';
        profitElement.style.color = profit >= 0 ? 'var(--success)' : 'var(--danger)';

        balanceElement.className = balance >= 0 ? 'calculation-value balance' : 'calculation-value';
        balanceElement.style.color = balance >= 0 ? 'var(--primary)' : 'var(--danger)';
    }
</script>

<!-- Font Awesome for icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

@endsection