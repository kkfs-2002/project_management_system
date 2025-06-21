@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3">Project Transactions</h4>

    <!-- Filter + Download -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <form method="GET" class="d-flex align-items-center gap-2">
            <label for="month" class="form-label mb-0">Filter by Month:</label>
            <input type="month" name="month" id="month" value="{{ $month }}" required class="form-control" style="max-width: 180px;">
            <button class="btn btn-primary" type="submit">Filter</button>
        </form>

        <a href="{{ route('superadmin.project.transactions.downloadPdf', ['month' => $month]) }}" class="btn btn-dark">
            <i class="fa fa-file-pdf-o me-1"></i> Download PDF
        </a>
    </div>

    <!-- Accordions -->
    <div class="accordion" id="transactionsAccordion">
        @foreach($allMonths as $monthItem)
            @php
                $monthKey = $monthItem['value'];
                $monthlyAccounts = $groupedAccounts[$monthKey] ?? collect();
                $isActive = $month === $monthKey;
            @endphp

            <div class="accordion-item mb-2">
                <h2 class="accordion-header" id="heading{{ $loop->index }}">
                    <button class="accordion-button {{ $isActive ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $loop->index }}" aria-expanded="{{ $isActive ? 'true' : 'false' }}"
                            aria-controls="collapse{{ $loop->index }}">
                        {{ $monthItem['label'] }}
                    </button>
                </h2>
                <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse {{ $isActive ? 'show' : '' }}"
                     aria-labelledby="heading{{ $loop->index }}" data-bs-parent="#transactionsAccordion">
                    <div class="accordion-body">
                        @if($monthlyAccounts->isEmpty())
                            <div class="alert alert-info text-center mb-0">
                                 No transactions found for this month.
                            </div>
                        @else
                            <table class="table table-striped table-bordered shadow"
                                   style="border-radius: 10px; overflow: hidden; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                                <thead style="background-color: #001f4d; color: white;">
                                    <tr>
                                        <th>Project Name</th>
                                        <th>Type</th>
                                        <th>Total Payment (Rs.)</th>
                                        <th>Advance (Rs.)</th>
                                        <th>Credit (Rs.)</th>
                                        <th>Hosting Fee (Rs.)</th>
                                        <th>Developer Fee (Rs.)</th>
                                        <th>Profit (Rs.)</th>
                                        <th style="width: 120px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($monthlyAccounts as $account)
                                        <tr>
                                            <td>{{ $account->project->name }}</td>
                                            <td>{{ $account->project->type }}</td>
                                            <td>{{ number_format($account->total_payment, 2) }}</td>
                                            <td>{{ number_format($account->advance, 2) }}</td>
                                            <td>{{ number_format($account->credit, 2) }}</td>
                                            <td>{{ number_format($account->hosting_fee, 2) }}</td>
                                            <td>{{ number_format($account->developer_fee, 2) }}</td>
                                            <td>{{ number_format($account->profit, 2) }}</td>
                                            <td>
                                                <a href="{{ route('superadmin.project.financials.edit', $account->id) }}"
                                                   class="btn btn-sm" style="background-color: #001f4d; color: white;" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('superadmin.project.financials.destroy', $account->id) }}"
                                                      method="POST" style="display:inline-block;"
                                                      onsubmit="return confirm('Are you sure you want to delete this transaction?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm" style="background-color: red; color: white;" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('styles')
<style>
    table {
        border-collapse: separate !important;
        border-spacing: 0 10px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    th, td {
        vertical-align: middle !important;
    }

    tbody tr {
        background: white;
        border: 1px solid #ddd;
        transition: background-color 0.3s ease;
    }

    tbody tr:hover {
        background-color: #f1f5ff;
    }

    .btn-sm:hover {
        background-color: #004080;
        color: white;
    }
</style>
@endsection