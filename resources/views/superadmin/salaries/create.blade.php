@extends('layouts.app')

@section('title', 'Add Salary')

@section('content')
<div class="container mt-4">
    <h2>Add New Salary</h2>

    <form method="POST" action="{{ route('superadmin.salary.store') }}"> 
        @csrf

        <div class="mb-3">
            <label for="profile_id">Select Employee</label>
            <select name="profile_id" class="form-control" required>
                <option value="">-- Select Employee --</option>
                @foreach($profiles as $profile)
                    <option value="{{ $profile->id }}">{{ $profile->full_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="amount">Salary Amount (Rs)</label>
            <input type="number" name="amount" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="salary_month">Salary Date</label>
            <input type="date" name="salary_month" class="form-control" required>

        </div>

        <button type="submit" class="btn btn-primary">Add Salary</button>
    </form>
</div>
@endsection
