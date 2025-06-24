@extends('layouts.app')

@section('title', 'All Clients')

@section('content')
<div class="container mt-4">

    {{-- Header with Send button --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
        <h2 class="mb-0">All Clients</h2>
        <a href="{{ route('superadmin.clients.create') }}" class="btn btn-primary flex-shrink-0">
            <i class="fas fa-paper-plane me-1"></i> Send
        </a>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('superadmin.clients.index') }}" class="row g-2 justify-content-end align-items-center mb-3">
        {{-- Month Filter --}}
        <div class="col-12 col-sm-auto">
            <input type="month" name="month" id="month" class="form-control form-control-sm" value="{{ request('month') }}">
        </div>

        {{-- Marketing Manager Filter --}}
        <div class="col-12 col-sm-auto">
            <select name="manager" id="manager" class="form-select form-select-sm">
                <option value="">Select Marketing Manager</option>
                @foreach($managers as $manager)
                    <option value="{{ $manager->employee_id }}" 
                        {{ request('manager') == $manager->employee_id ? 'selected' : '' }}>
                        {{ $manager->full_name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Filter Button --}}
        <div class="col-12 col-sm-auto">
            <button type="submit" class="btn btn-sm btn-outline-primary w-100">
                <i class="fas fa-filter me-1"></i> Filter
            </button>
        </div>

        {{-- Clear Button --}}
        @if(request('month') || request('manager'))
        <div class="col-12 col-sm-auto">
            <a href="{{ route('superadmin.clients.index') }}" class="btn btn-sm btn-outline-secondary w-100">
                <i class="fas fa-times"></i> Clear
            </a>
        </div>
        @endif
    </form>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($clientsByMonth->isEmpty())
        <p>No clients found.</p>
    @else
        @foreach ($clientsByMonth as $monthYear => $clients)
            <div class="mb-5">
                <h4 class="month-heading border-bottom pb-2 mb-3">
                    <i class="fas fa-calendar-alt me-2"></i>{{ $monthYear }}
                    <span class="badge bg-secondary ms-2">{{ $clients->count() }} client(s)</span>
                    @php
                        $monthPendingCount = $clients->where('edit_permission', 'pending')->count();
                    @endphp
                    @if($monthPendingCount > 0)
                        <span class="badge bg-warning text-dark ms-1">{{ $monthPendingCount }} pending</span>
                    @endif
                </h4>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-primary">
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
                                <th>Created Date</th>
                                <th>Edit/Delete Permission</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr class="{{ $client->edit_permission === 'pending' ? 'table-warning' : '' }}">
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->contact_number }}</td>
                                    <td>{{ $client->project_name }}</td>
                                    <td>{{ $client->project_type }}</td>
                                    <td>{{ $client->technology }}</td>
                                    <td>
                                        <span class="badge bg-{{ $client->payment_status === 'paid' ? 'success' : ($client->payment_status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($client->payment_status) }}
                                        </span>
                                    </td>
                                    <td>Rs.{{ number_format($client->amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $client->status === 'active' ? 'success' : ($client->status === 'pending' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($client->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $client->reminder_date ? \Carbon\Carbon::parse($client->reminder_date)->format('M d, Y') : '-' }}</td>
                                    <td>{{ Str::limit($client->note, 30) ?? '-' }}</td>
                                    <td>{{ $client->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if ($client->edit_permission === 'pending')
                                            <div class="btn-group-vertical" role="group">
                                                <form action="{{ route('superadmin.clients.approve-permission', $client->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    <button class="btn btn-success btn-sm mb-1" title="Approve Permission">
                                                        <i class="fas fa-check me-1"></i>Approve
                                                    </button>
                                                </form>

                                                <form action="{{ route('superadmin.clients.reject-permission', $client->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    <button class="btn btn-danger btn-sm" title="Reject Permission">
                                                        <i class="fas fa-times me-1"></i>Reject
                                                    </button>
                                                </form>
                                            </div>

                                        @elseif ($client->edit_permission === 'approved')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Approved
                                            </span>

                                        @elseif ($client->edit_permission === 'rejected')
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times-circle me-1"></i>Rejected
                                            </span>

                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-minus-circle me-1"></i>No Request
                                            </span>
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

    @if($pendingRequests->count() > 0)
        <div class="mt-4 p-3 bg-light rounded">
            <h5 class="text-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Total Pending Permission Requests: {{ $pendingRequests->count() }}
            </h5>
        </div>
    @endif
</div>

<style>
.table-responsive {
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.badge {
    font-size: 0.75em;
}

.btn-group-vertical .btn {
    margin-bottom: 2px;
}

.border-bottom {
    border-width: 2px !important;
}

.table-warning {
    background-color: rgba(255, 193, 7, 0.1) !important;
}

.month-heading {
    color: #6c757d;
    font-weight: 600;
    font-size: 1.25rem;
}
</style>
@endsection
