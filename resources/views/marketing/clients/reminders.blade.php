@extends('layouts.marketing')

@section('title', 'Client Reminders')

@section('content')
<div class="container mt-4">
    <h2>Clients by Reminder Date</h2>

    @if ($clients->isEmpty())
        <p>No reminder clients found.</p>
    @else
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>contact_number</th>
                    <th>Reminder Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                    <tr>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->contact_number }}</td>
                        <td>{{ $client->reminder_date }}</td>
                        <td>
                            <span class="badge {{ $client->status == 'success' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ ucfirst($client->status) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
