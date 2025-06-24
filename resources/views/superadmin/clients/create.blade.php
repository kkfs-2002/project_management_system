@extends('layouts.app')

@section('title', 'Add Client')

@section('content')
<div class="container mt-4">
    <h2>Add Client for Marketing Manager</h2>

    <form method="POST" action="{{ route('superadmin.clients.store') }}">
        @csrf

        {{-- Select Marketing Manager --}}
        <div class="mb-3">
            <label for="marketing_manager_id" class="form-label">Marketing Manager</label>
            <select name="marketing_manager_id" id="marketing_manager_id" class="form-select" required>
                <option value="">Select Manager</option>
                @foreach($managers as $manager)
                    <option value="{{ $manager->employee_id }}">{{ $manager->full_name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Client Form Fields --}}
          <div class="row">
            <div class="col-md-6 mb-3">
              <label>Client Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label>Contact Number</label>
              <input type="text" name="contact_number" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label>Project Name</label>
              <input type="text" name="project_name" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label>Project Type</label>
              <select name="project_type" class="form-select">
                <option value="">Select Type</option>
                <option value="Web">Web</option>
                <option value="Mobile">Mobile</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label>Technology</label>
              <input type="text" name="technology" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label>Reminder Date</label>
              <input type="date" name="reminder_date" class="form-control">
            </div>
            <div class="col-md-12 mb-3">
              <label>Note</label>
              <textarea name="note" class="form-control" rows="2"></textarea>
            </div>
            <div class="col-md-6 mb-3">
              <label>Amount</label>
              <input type="number" step="0.01" name="amount" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label>Payment Status</label>
              <select name="payment_status" class="form-select">
                <option value="">Select Status</option>
                <option value="No Payment">No Payment</option>
                <option value="Advance">Advance</option>
                <option value="Full">Full</option>
              </select>
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-success">Add Client</button>
        <a href="{{ route('superadmin.clients.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
