@extends('layouts.app')

@section('title', 'Monthly Expenses')

@section('content')
<div class="container mt-4">
    <h2>Monthly Expenses</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Filter and Buttons -->
    <div class="row mb-3 align-items-end">
        <div class="col-md-6 col-lg-5">
            <form method="GET" action="{{ route('superadmin.expenses.index') }}" class="d-flex align-items-end gap-2">
                <div>
                    <label for="month" class="form-label">Filter by Month</label>
                    <input type="month" id="month" name="month" value="{{ $selectedMonth }}" class="form-control">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                </div>
            </form>
        </div>

        <div class="col-md-6 col-lg-7 text-end mt-3 mt-md-0">
            <a href="{{ route('superadmin.expenses.create') }}" class="btn btn-success btn-sm me-2">+ Add Expense</a>
            <a href="{{ route('superadmin.expenses.pdf', ['month' => $selectedMonth]) }}" class="btn btn-outline-secondary btn-sm">Download PDF</a>
        </div>
    </div>

    <!-- Accordion Display -->
    <div class="accordion" id="expenseAccordion">
        @foreach($expensesByMonth as $month => $monthExpenses)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading-{{ \Illuminate\Support\Str::slug($month) }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse-{{ \Illuminate\Support\Str::slug($month) }}"
                        aria-expanded="false" aria-controls="collapse-{{ \Illuminate\Support\Str::slug($month) }}">
                        {{ $month }}
                    </button>
                </h2>
                <div id="collapse-{{ \Illuminate\Support\Str::slug($month) }}" class="accordion-collapse collapse"
                    aria-labelledby="heading-{{ \Illuminate\Support\Str::slug($month) }}" data-bs-parent="#expenseAccordion">
                    <div class="accordion-body">
                        @if($monthExpenses->isEmpty())
                            <p>No expenses found.</p>
                        @else
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Amount (Rs)</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($monthExpenses as $expense)
                                        <tr>
                                            <td>{{ $expense->title }}</td>
                                            <td>{{ $expense->description }}</td>
                                            <td>{{ number_format($expense->amount, 2) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($expense->expense_date)->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-end">
                                <strong>Month Total: Rs. {{ number_format($monthExpenses->sum('amount'), 2) }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Grand Total -->
    <div class="mt-4 text-end">
        <h5>Grand Total: Rs. {{ number_format($total, 2) }}</h5>
    </div>
</div>
@endsection
