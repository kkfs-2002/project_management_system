@extends('layouts.marketing')

@section('title', 'Client Reminders')

@section('content')
<div class="container mt-4">
    <h2>Clients by Reminder Date</h2>

    {{-- Filter by Month --}}
    <div class="d-flex justify-content-end mb-3">
        <form action="{{ route('marketing.clients.reminders') }}" method="GET" class="d-flex align-items-center">
            <label for="month" class="me-2 fw-bold">Filter by Month:</label>
            <input type="month" name="month" id="month" class="form-control form-control-sm me-2"
                   value="{{ request('month') }}">
            <button type="submit" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-filter me-1"></i> Filter
            </button>

            @if(request('month'))
                <a href="{{ route('marketing.clients.reminders') }}" class="btn btn-sm btn-outline-secondary ms-2">
                    Clear
                </a>
            @endif
        </form>
    </div>

    {{-- Client Table --}}
    @if ($clients->isEmpty())
        <p>No reminder clients found.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>Name</th>
                        <th>Contact Number</th>
                        <th>Reminder Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $client)
                        <tr>
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->contact_number }}</td>
                            <td>{{ \Carbon\Carbon::parse($client->reminder_date)->format('M d, Y') }}</td>
                            <td>
                                <span class="badge {{ $client->status == 'success' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ ucfirst($client->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
