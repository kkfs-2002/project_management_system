@extends('layouts.app')

@section('title', 'Employee Salaries')

@section('content')
<div class="container mt-4">
    <h2>Employee Salary Records</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <form method="GET" action="{{ route('superadmin.salary.index') }}">
            <!-- Keep input type month for filtering -->
            <input type="month" name="month" value="{{ request('month') }}" class="form-control d-inline" style="width: 200px;">
            <button type="submit" class="btn btn-sm btn-primary ms-2">Filter</button>
        </form>

        <a href="{{ route('superadmin.salary.create') }}" class="btn btn-success">+ Add Salary</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Amount (Rs)</th>
                <th>Date</th>  <!-- Show full date -->
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($salaries as $salary)
                <tr>
                    <td>{{ $salary->profile->full_name }}</td>
                    <td>{{ number_format($salary->amount, 2) }}</td>
                    <!-- Display full date (d M Y) -->
                    <td>{{ \Carbon\Carbon::parse($salary->salary_month)->format('d M Y') }}</td>
                    <td><span class="badge bg-success">{{ $salary->status }}</span></td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">No salaries found for selected month.</td></tr>
            @endforelse
        </tbody>
    </table>

    @if($salaries->count())
        <div class="mt-3">
            <strong>Total:</strong> Rs {{ number_format($total, 2) }}
        </div>
    @endif
</div>
@endsection
