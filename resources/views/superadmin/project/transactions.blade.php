@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Project Transactions</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filter & PDF Download --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <form method="GET" class="d-flex align-items-center" style="gap: 0.75rem;">
            <label for="month" class="mb-0">Filter by Month:</label>
            <input type="month" id="month" name="month" value="{{ $month }}" required class="form-control" style="max-width: 180px;">
            <button class="btn btn-primary" type="submit">Filter</button>
        </form>

        <a href="{{ route('superadmin.project.transactions.downloadPdf', ['month' => $month]) }}" class="btn btn-primary" style="background-color: #001f4d; border-color: #001f4d;">
            <i class="fa fa-file-pdf-o"></i> Download PDF
        </a>
    </div>

    @if($accounts->isEmpty())
        <p>No transactions found for this month.</p>
    @else
        <table class="table table-striped table-bordered shadow" style="border-radius: 10px; overflow: hidden; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
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
                @foreach($accounts as $account)
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
                        <a href="{{ route('superadmin.project.financials.edit', $account->id) }}" class="btn btn-sm" style="background-color: #001f4d; color: white;" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>

                        <form action="{{ route('superadmin.project.financials.destroy', $account->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this transaction?');">
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

