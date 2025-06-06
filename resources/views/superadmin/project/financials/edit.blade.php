@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Financials for {{ $account->project->name }}</h2>

    <form action="{{ route('superadmin.project.financials.update', $account->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Total Payment</label>
            <input type="number" name="total_payment" class="form-control" value="{{ old('total_payment', $account->total_payment) }}" required>
        </div>

        <div class="mb-3">
            <label>Advance</label>
            <input type="number" name="advance" class="form-control" value="{{ old('advance', $account->advance) }}" required>
        </div>

        <div class="mb-3">
            <label>Hosting Fee</label>
            <input type="number" name="hosting_fee" class="form-control" value="{{ old('hosting_fee', $account->hosting_fee) }}" required>
        </div>

        <div class="mb-3">
            <label>Developer Fee</label>
            <input type="number" name="developer_fee" class="form-control" value="{{ old('developer_fee', $account->developer_fee) }}" required>
        </div>

        <button type="submit" class="btn btn-primary" style="background-color: #001f4d;">Update</button>
        <a href="{{ route('superadmin.project.transactions') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection