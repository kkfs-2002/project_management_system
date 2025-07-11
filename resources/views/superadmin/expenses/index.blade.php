@extends('layouts.app')

@section('title', 'Monthly Expenses')

@section('content')
<div class="container mt-4">
    <h2>Monthly Expenses</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <!-- ✅ Correct route name here -->
        <form method="GET" action="{{ route('superadmin.expenses.index') }}">
            <input type="month" name="month" value="{{ request('month') }}" class="form-control d-inline" style="width: 200px;">
            <button type="submit" class="btn btn-sm btn-primary ms-2">Filter</button>
        </form>

        <!-- ✅ This is already correct -->
        <a href="{{ route('superadmin.expenses.create') }}" class="btn btn-success">+ Add Expense</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Amount (Rs)</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $expense)
                <tr>
                    <td>{{ $expense->title }}</td>
                    <td>{{ $expense->description }}</td>
                    <td>{{ number_format($expense->amount, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($expense->expense_date)->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">No expenses found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        <strong>Total: Rs. {{ number_format($total, 2) }}</strong>
    </div>
</div>
@endsection
