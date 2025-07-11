@extends('layouts.app')

@section('title', 'Add Expense')

@section('content')
<div class="container mt-4">
    <h2>Add New Expense</h2>

    <form method="POST" action="{{ route('superadmin.expenses.store') }}">
        @csrf
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Amount (Rs)</label>
            <input type="number" name="amount" step="0.01" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Expense Date</label>
            <input type="date" name="expense_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Expense</button>
    </form>
</div>
@endsection
