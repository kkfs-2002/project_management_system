@extends('layouts.marketing')

@section('title', 'Cancelled Clients')

@section('content')
<div class="container mt-4">
    <h2>Hidden/Cancelled Clients</h2>

    <a href="{{ route('marketing.clients.reminders') }}" class="btn btn-sm btn-outline-secondary mb-3">
        ← Back to Reminders
    </a>

    @if ($clients->isEmpty())
        <div class="alert alert-info">No cancelled clients found.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Reminder Date</th>
                        <th>Note</th>
                        <th>Cancel Reason</th>
                        <th>Cancelled At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $client)
                        <tr>
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->contact_number }}</td>
                            <td>{{ \Carbon\Carbon::parse($client->reminder_date)->format('M d, Y') }}</td>
                            <td>{{ $client->note }}</td>
                            <td class="text-danger">{{ $client->cancel_reason ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($client->updated_at)->format('M d, Y h:i A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
