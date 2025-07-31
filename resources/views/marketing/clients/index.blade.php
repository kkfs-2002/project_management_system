@extends('layouts.marketing')

@section('title', 'All Clients')

@section('content')
<div class="container mt-4">
    <h2>All Clients</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('marketing.clients.create') }}" class="btn btn-primary mb-3">+ Create New Client</a>
    <a href="{{ route('marketing.clients.index.pdf', ['month' => request('month')]) }}" class="btn btn-outline-secondary mb-3">
    <i class="fas fa-file-pdf me-1"></i> Download PDF
</a>


    {{-- Compact Month Filter --}}
    <div class="d-flex justify-content-end mb-3">
        <form method="GET" action="{{ route('marketing.clients.index') }}" class="d-flex align-items-center">
            <input type="month" name="month" id="month" class="form-control form-control-sm me-2"
                   value="{{ request('month') }}" >
            <button type="submit" class="btn btn-sm btn-outline-primary me-2">
                <i class="fas fa-filter me-1"></i> Filter
            </button>
            @if(request('month'))
                <a href="{{ route('marketing.clients.index') }}" class="btn btn-sm btn-outline-secondary">
                    Clear
                </a>
            @endif
        </form>
    </div>

    @if ($clientsByMonth->isEmpty())
        <p>No clients found.</p>
    @else
        @foreach ($clientsByMonth as $monthYear => $clients)
            <div class="mb-5">
                <h4 class="month-heading border-bottom pb-2 mb-3">
                    <i class="fas fa-calendar-alt me-2"></i>{{ $monthYear }}
                    <span class="badge bg-secondary ms-2">{{ $clients->count() }} client(s)</span>
                </h4>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Project</th>
                                <th>Type</th>
                                <th>Tech</th>
                                <th>Payment</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Reminder</th>
                                <th>Note</th>
                                <th>Created</th>
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
                                    <td>
                                        <span class="badge bg-{{ $client->payment_status === 'Full' ? 'success' : ($client->payment_status === 'Advance' ? 'warning' : 'danger') }}">
                                            {{ $client->payment_status }}
                                        </span>
                                    </td>
                                    <td>Rs. {{ number_format($client->amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $client->status === 'active' ? 'success' : ($client->status === 'pending' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($client->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $client->reminder_date ? \Carbon\Carbon::parse($client->reminder_date)->format('M d, Y') : '-' }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($client->note, 50) ?? '-' }}</td>
                                    <td>{{ $client->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if ($client->edit_permission === 'approved')
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('marketing.clients.edit', $client->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('marketing.clients.destroy', $client->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this client?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" type="submit" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif ($client->edit_permission === 'pending')
                                            <span class="badge bg-warning text-dark">Permission Pending</span>
                                        @elseif ($client->edit_permission === 'rejected')
                                            <span class="badge bg-danger">Permission Rejected</span>
                                        @else
                                            <form action="{{ route('marketing.clients.request-permission', $client->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-info" title="Request Permission">
                                                    <i class="fas fa-key me-1"></i>Request Permission
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif
</div>

<style>
.table-responsive {
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0,0,0,0.05);
}

.badge {
    font-size: 0.75em;
}

.btn-group .btn {
    margin-right: 2px;
}

.border-bottom {
    border-width: 2px !important;
}

.month-heading {
    color: #6c757d;
    font-weight: 600;
    font-size: 1.25rem;
}

form input[type="month"] {
    max-width: 150px;
}
</style>
@endsection
