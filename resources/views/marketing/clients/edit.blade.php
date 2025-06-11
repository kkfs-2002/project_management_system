@extends('layouts.marketing')

@section('title', 'Edit Client')

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
    <h2>Edit Client</h2>

    <form method="POST" action="{{ route('marketing.clients.update', $client->id) }}">
        @csrf
        @method('PUT')

        <label>Client Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $client->name) }}" required>

        <label>Contact Number</label>
        <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', $client->contact_number) }}">

        <label>Project Name</label>
        <input type="text" name="project_name" class="form-control" value="{{ old('project_name', $client->project_name) }}">

        <label>Project Type</label>
        <select name="project_type" class="form-select">
            <option value="" disabled>Select Project Type</option>
            <option value="Web" {{ old('project_type', $client->project_type) == 'Web' ? 'selected' : '' }}>Web</option>
            <option value="Mobile" {{ old('project_type', $client->project_type) == 'Mobile' ? 'selected' : '' }}>Mobile</option>
        </select>

        <label>Technology</label>
        <input type="text" name="technology" class="form-control" value="{{ old('technology', $client->technology) }}">

        <label>Reminder Date</label>
        <input type="date" name="reminder_date" class="form-control" value="{{ old('reminder_date', $client->reminder_date) }}">

        <label>Note</label>
        <textarea name="note" class="form-control" rows="3">{{ old('note', $client->note) }}</textarea>

        <label>Amount</label>
        <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount', $client->amount) }}">

        <label>Payment Status</label>
        <select name="payment_status" class="form-select" required>
            <option value="No Payment" {{ old('payment_status', $client->payment_status) == 'No Payment' ? 'selected' : '' }}>No Payment</option>
            <option value="Advance" {{ old('payment_status', $client->payment_status) == 'Advance' ? 'selected' : '' }}>Advance</option>
            <option value="Full" {{ old('payment_status', $client->payment_status) == 'Full' ? 'selected' : '' }}>Full</option>
        </select>

        <div class="mt-4 d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('marketing.clients.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
@endsection
