@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2><i class="fas fa-calendar-alt"></i> Monthly Profit Report</h2>
                <div>
                    <a href="{{ route('superadmin.project.yearly-profit') }}" class="btn btn-outline-primary">
                        <i class="fas fa-calendar"></i> View Yearly Profit
                    </a>
                    <a href="{{ route('superadmin.project.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Projects
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Month Filter -->
    <div class="row mb-4">
        <div class="col-md-6 mt-5">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-filter"></i> Select Month</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('superadmin.project.monthly-profit') }}" class="row">
                        <div class="col-md-8">
                            <select name="month" class="form-control" onchange="this.form.submit()">
                                @foreach($months as $monthOption)
                                    <option value="{{ $monthOption['value'] }}" 
                                        {{ $monthOption['value'] == $month ? 'selected' : '' }}>
                                        {{ $monthOption['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('superadmin.project.download-monthly-pdf', ['month' => $month]) }}" 
                               class="btn btn-danger w-100">
                                <i class="fas fa-file-pdf"></i> Download PDF
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-5">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h4>{{ \Carbon\Carbon::parse($month)->format('F Y') }}</h4>
                    <h2>Rs {{ number_format($monthlySummary['total_profit'], 2) }}</h2>
                    <p class="mb-0">Total Monthly Profit</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card card-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted">Total Projects</h6>
                            <h3>{{ $monthlySummary['total_projects'] }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-project-diagram fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card card-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted">Total Payment</h6>
                            <h3>Rs {{ number_format($monthlySummary['total_payment'], 2) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-money-bill-wave fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card card-danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted">Total Expenses</h6>
                            @php
                                $totalExpenses = $monthlySummary['total_hosting'] + $monthlySummary['total_developer'];
                            @endphp
                            <h3>Rs {{ number_format($totalExpenses, 2) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-receipt fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card card-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted">Balance Due</h6>
                            <h3>Rs {{ number_format($monthlySummary['total_balance'], 2) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-hand-holding-usd fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Projects Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-list"></i> Projects for {{ \Carbon\Carbon::parse($month)->format('F Y') }}</h5>
                </div>
                <div class="card-body">
                    @if($monthlyData->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Project Name</th>
                                        <th>Type</th>
                                        <th>Total Payment</th>
                                        <th>Advance</th>
                                        <th>Hosting Fee</th>
                                        <th>Developer Fee</th>
                                        <th>Profit</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($monthlyData as $index => $account)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $account->project->name }}</td>
                                            <td>{{ $account->project->type }}</td>
                                            <td class="text-right">Rs {{ number_format($account->total_payment, 2) }}</td>
                                            <td class="text-right">Rs {{ number_format($account->advance, 2) }}</td>
                                            <td class="text-right">Rs {{ number_format($account->hosting_fee, 2) }}</td>
                                            <td class="text-right">Rs {{ number_format($account->developer_fee, 2) }}</td>
                                            <td class="text-right {{ $account->profit >= 0 ? 'text-success' : 'text-danger' }}">
                                                <strong>Rs {{ number_format($account->profit, 2) }}</strong>
                                            </td>
                                            <td class="text-right">Rs {{ number_format($account->balance, 2) }}</td>
                                        </tr>
                                    @endforeach
                                    <!-- Total Row -->
                                    <tr class="table-active">
                                        <td colspan="3" class="text-right"><strong>TOTAL:</strong></td>
                                        <td class="text-right"><strong>Rs {{ number_format($monthlySummary['total_payment'], 2) }}</strong></td>
                                        <td class="text-right"><strong>Rs {{ number_format($monthlySummary['total_advance'], 2) }}</strong></td>
                                        <td class="text-right"><strong>Rs {{ number_format($monthlySummary['total_hosting'], 2) }}</strong></td>
                                        <td class="text-right"><strong>Rs {{ number_format($monthlySummary['total_developer'], 2) }}</strong></td>
                                        <td class="text-right"><strong>Rs {{ number_format($monthlySummary['total_profit'], 2) }}</strong></td>
                                        <td class="text-right"><strong>Rs {{ number_format($monthlySummary['total_balance'], 2) }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                            <h4>No projects found for this month</h4>
                            <p class="text-muted">Try selecting a different month</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card-primary { border-left: 4px solid #007bff; }
    .card-success { border-left: 4px solid #28a745; }
    .card-danger { border-left: 4px solid #dc3545; }
    .card-info { border-left: 4px solid #17a2b8; }
    .table th { background-color: #f8f9fa; }
</style>
@endpush