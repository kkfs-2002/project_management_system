@extends('layouts.marketing')

@section('title', 'Create Client')

@section('content')
<style>
    .client-form {
        max-width: 600px;
        margin: 0 auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    .client-form input,
    .client-form select,
    .client-form textarea {
        margin-bottom: 15px;
    }

    .client-form h2 {
        text-align: center;
        margin-bottom: 20px;
    }
</style>

<div class="client-form">
    <h2>Create New Client</h2>

    <form method="POST" action="{{ route('marketing.clients.store') }}">
        @csrf

        <label>Client Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>

        <label>Contact Number</label>
        <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number') }}">

        <label>Project Name</label>
        <input type="text" name="project_name" class="form-control" value="{{ old('project_name') }}">

        <label>Project Type</label>
        <select name="project_type" class="form-select" required>
            <option value="" disabled selected>Select Project Type</option>
            <option value="Website" {{ old('project_type') == 'Website' ? 'selected' : '' }}>Website</option>
            <option value="System" {{ old('project_type') == 'System' ? 'selected' : '' }}>System</option>
            <option value="Mobile App" {{ old('project_type') == 'Mobile App' ? 'selected' : '' }}>Mobile App</option>
            <option value="Other" {{ old('project_type') == 'Other' ? 'selected' : '' }}>Other</option>
        </select>

        <label>Technology</label>
        <input type="text" name="technology" class="form-control" value="{{ old('technology') }}">

        <label>Reminder Date</label>
        <input type="date" name="reminder_date" class="form-control" value="{{ old('reminder_date') }}">

        <label>Note</label>
        <textarea name="note" class="form-control" rows="3">{{ old('note') }}</textarea>

        <label>Amount</label>
        <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount') }}">

        <label>Payment Status</label>
        <select name="payment_status" class="form-select" required>
            <option value="" disabled selected>Select Payment Status</option>
            <option value="No Payment" {{ old('payment_status') == 'No Payment' ? 'selected' : '' }}>No Payment</option>
            <option value="Advance" {{ old('payment_status') == 'Advance' ? 'selected' : '' }}>Advance</option>
            <option value="Full" {{ old('payment_status') == 'Full' ? 'selected' : '' }}>Full</option>
        </select>

        <div class="mt-4 d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ route('marketing.clients.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
@endsection
