@extends('layouts.developer')

@php
    $hideWelcome = true;
@endphp

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">
                        <i class="fas fa-history me-2 text-primary"></i>Attendance History
                    </h2>
                    <p class="text-muted mb-0">View your attendance records</p>
                </div>
                <a href="{{ route('developer.dashboard', $dev->id ?? 1) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-calendar-check fa-2x text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Days</h6>
                            <h3 class="mb-0">{{ $attendances->total() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">This Month</h6>
                            <h3 class="mb-0">{{ $attendances->where('date', '>=', now()->startOfMonth())->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-clock fa-2x text-info"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Avg Hours</h6>
                            <h3 class="mb-0">
                                @php
                                    $avgHours = $attendances->where('total_hours', '>', 0)->avg('total_hours');
                                @endphp
                                {{ $avgHours ? number_format($avgHours, 1) : '0' }}h
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-hourglass-half fa-2x text-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Hours</h6>
                            <h3 class="mb-0">{{ number_format($attendances->sum('total_hours'), 0) }}h</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>Attendance Records
                </h5>
                <div>
                    <button class="btn btn-sm btn-outline-primary" onclick="window.print()">
                        <i class="fas fa-print me-1"></i>Print
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($attendances->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Date</th>
                            <th class="py-3">Day</th>
                            <th class="py-3">Check In</th>
                            <th class="py-3">Check Out</th>
                            <th class="py-3">Total Hours</th>
                            <th class="py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $attendance)
                        <tr>
                            <td class="px-4 py-3">
                                <strong>{{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}</strong>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-light text-dark">
                                    {{ \Carbon\Carbon::parse($attendance->date)->format('l') }}
                                </span>
                            </td>
                            <td class="py-3">
                                @if($attendance->check_in)
                                    <span class="text-success">
                                        <i class="fas fa-sign-in-alt me-1"></i>
                                        {{ \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="py-3">
                                @if($attendance->check_out)
                                    <span class="text-danger">
                                        <i class="fas fa-sign-out-alt me-1"></i>
                                        {{ \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="py-3">
                                @if($attendance->check_in && $attendance->check_out)
                                    @php
                                        $checkIn = \Carbon\Carbon::parse($attendance->check_in);
                                        $checkOut = \Carbon\Carbon::parse($attendance->check_out);
                                        $diff = $checkIn->diff($checkOut);
                                    @endphp
                                    <span class="badge bg-info">
                                        {{ $diff->h }}h {{ $diff->i }}m
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="py-3 text-center">
                                @if($attendance->check_in && $attendance->check_out)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Complete
                                    </span>
                                @elseif($attendance->check_in)
                                    <span class="badge bg-warning">
                                        <i class="fas fa-clock me-1"></i>In Progress
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-minus-circle me-1"></i>Incomplete
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="card-footer bg-white border-top">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing {{ $attendances->firstItem() ?? 0 }} to {{ $attendances->lastItem() ?? 0 }} 
                        of {{ $attendances->total() }} records
                    </div>
                    <div>
                        {{ $attendances->links() }}
                    </div>
                </div>
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">No Attendance Records Found</h5>
                <p class="text-muted">Start tracking your attendance from the dashboard.</p>
                <a href="{{ route('developer.dashboard', $dev->id ?? 1) }}" class="btn btn-primary mt-3">
                    <i class="fas fa-arrow-left me-2"></i>Go to Dashboard
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .pagination, .navbar, .card-header button, .card-header a {
        display: none !important;
    }
    .card {
        border: 1px solid #dee2e6 !important;
        box-shadow: none !important;
    }
}
</style>
@endsection