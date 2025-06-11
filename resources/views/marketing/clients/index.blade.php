@extends('layouts.marketing')

@section('title', 'All Clients')

@section('content')
<div class="container mt-4">
    <h2>All Clients</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('marketing.clients.create') }}" class="btn btn-primary mb-3">+ Create New Client</a>

    @if ($clients->isEmpty())
        <p>No clients found.</p>
    @else
        <table class="table table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Contact Number</th>
                    <th>Project Name</th>
                    <th>Project Type</th>
                    <th>Technology</th>
                    <th>Payment Status</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Reminder Date</th>
                    <th>Note</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                    <tr>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->contact_number }}</td>
                        <td>{{ $client->project_name }}</td>
                        <td>{{ $client->project_type }}</td>
                        <td>{{ $client->technology }}</td>
                        <td>{{ $client->payment_status }}</td>
                        <td>{{ number_format($client->amount, 2) }}</td>
                        <td>{{ ucfirst($client->status) }}</td>
                        <td>{{ $client->reminder_date }}</td>
                        <td>{{ $client->note }}</td>
                        <td>
                            <a href="{{ route('marketing.clients.edit', $client->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('marketing.clients.destroy', $client->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
