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
                        <th>Contact</th>
                        <th>Reminder</th>
                        <th>Note</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $client)
                        <tr>
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->contact_number }}</td>
                            <td>{{ \Carbon\Carbon::parse($client->reminder_date)->format('M d, Y') }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($client->note, 50) ?? '-' }}</td>
                            <td>
                                <span class="badge bg-warning text-dark">
                                    {{ ucfirst($client->status) }}
                                </span>
                            </td>
                            <td>
                                {{-- Mark as Confirmed --}}
                                <form method="POST" action="{{ route('marketing.clients.confirm', $client->id) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-success" title="Mark as Confirmed">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>

                                {{-- Cancel (Hide) --}}
                                <button class="btn btn-sm btn-danger" title="Cancel Client" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $client->id }}">
                                    <i class="fas fa-eye-slash"></i>
                                </button>

                                {{-- Modal --}}
                                <div class="modal fade" id="cancelModal{{ $client->id }}" tabindex="-1" aria-labelledby="cancelModalLabel{{ $client->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form method="POST" action="{{ route('marketing.clients.cancel', $client->id) }}">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Cancel Client</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to cancel this client?</p>
                                                    <div class="mb-3">
                                                        <label for="cancel_reason" class="form-label">Reason for Cancellation</label>
                                                        <textarea name="cancel_reason" class="form-control" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-danger">Yes, Cancel</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
