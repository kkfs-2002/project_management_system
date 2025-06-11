<form method="POST" action="{{ isset($client) ? route('marketing.clients.update', $client->id) : route('marketing.clients.store') }}">
    @csrf
    @if(isset($client))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label">Client Name</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $client->name ?? '') }}" required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="contact_number" class="form-label">Contact Number</label>
            <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', $client->contact_number ?? '') }}">
        </div>

        <div class="col-md-6 mb-3">
            <label for="project_name" class="form-label">Project Name</label>
            <input type="text" name="project_name" class="form-control" value="{{ old('project_name', $client->project_name ?? '') }}">
        </div>

        <div class="col-md-6 mb-3">
            <label for="project_type" class="form-label">Project Type</label>
            <select name="project_type" class="form-select">
                <option value="" disabled {{ old('project_type', $client->project_type ?? '') == '' ? 'selected' : '' }}>Select Project Type</option>
                <option value="Web" {{ old('project_type', $client->project_type ?? '') == 'Web' ? 'selected' : '' }}>Web</option>
                <option value="Mobile" {{ old('project_type', $client->project_type ?? '') == 'Mobile' ? 'selected' : '' }}>Mobile</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label for="technology" class="form-label">Technology</label>
            <input type="text" name="technology" class="form-control" value="{{ old('technology', $client->technology ?? '') }}">
        </div>

        <div class="col-md-6 mb-3">
            <label for="reminder_date" class="form-label">Reminder Date</label>
            <input type="date" name="reminder_date" class="form-control" value="{{ old('reminder_date', $client->reminder_date ?? '') }}">
        </div>

        <div class="col-12 mb-3">
            <label for="note" class="form-label">Note</label>
            <textarea name="note" class="form-control" rows="3">{{ old('note', $client->note ?? '') }}</textarea>
        </div>

        <div class="col-md-6 mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" step="0.01" class="form-control" name="amount" value="{{ old('amount', $client->amount ?? '') }}">
        </div>

        <div class="col-md-6 mb-3">
            <label for="payment_status" class="form-label">Payment Status</label>
            <select name="payment_status" class="form-select" required>
                <option value="No Payment" {{ old('payment_status', $client->payment_status ?? '') == 'No Payment' ? 'selected' : '' }}>No Payment</option>
                <option value="Advance" {{ old('payment_status', $client->payment_status ?? '') == 'Advance' ? 'selected' : '' }}>Advance</option>
                <option value="Full" {{ old('payment_status', $client->payment_status ?? '') == 'Full' ? 'selected' : '' }}>Full</option>
            </select>
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary">{{ isset($client) ? 'Update' : 'Create' }}</button>
        <a href="{{ route('marketing.clients.index') }}" class="btn btn-secondary">Back</a>
    </div>
</form>
