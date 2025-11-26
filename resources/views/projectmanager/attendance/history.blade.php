@extends('layouts.projectmanager')

@php
    $hideWelcome = true;
@endphp

@section('content')
<div class="container mt-4" style="padding-top:80px;">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-history me-2"></i>My Attendance History
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Day</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Total Hours</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendances as $attendance)
                                    <tr>
                                        <td>{{ $attendance->date->format('M d, Y') }}</td>
                                        <td>{{ $attendance->date->format('l') }}</td>
                                        <td>
                                            @if($attendance->check_in)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-sign-in-alt me-1"></i>
                                                    {{ \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($attendance->check_out)
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-sign-out-alt me-1"></i>
                                                    {{ \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($attendance->check_in && $attendance->check_out)
                                                @php
                                                    $checkIn = \Carbon\Carbon::parse($attendance->check_in);
                                                    $checkOut = \Carbon\Carbon::parse($attendance->check_out);
                                                    $diff = $checkIn->diff($checkOut);
                                                @endphp
                                                <strong>{{ $diff->h }}h {{ $diff->i }}m</strong>
                                                @if($attendance->total_hours)
                                                    <small class="text-muted">({{ number_format($attendance->total_hours, 2) }}h)</small>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                            No attendance records found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $attendances->links() }}
                    </div>

                    <!-- Summary Statistics -->
                    @if($attendances->count() > 0)
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center">
                                        <h3>{{ $attendances->whereNotNull('check_in')->count() }}</h3>
                                        <p class="mb-0">Total Days Present</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-info text-white">
                                    <div class="card-body text-center">
                                        <h3>
                                            @php
                                                $totalMinutes = 0;
                                                foreach($attendances as $att) {
                                                    if($att->check_in && $att->check_out) {
                                                        $checkIn = \Carbon\Carbon::parse($att->check_in);
                                                        $checkOut = \Carbon\Carbon::parse($att->check_out);
                                                        $totalMinutes += $checkIn->diffInMinutes($checkOut);
                                                    }
                                                }
                                                $totalHours = floor($totalMinutes / 60);
                                                $remainingMinutes = $totalMinutes % 60;
                                            @endphp
                                            {{ $totalHours }}h {{ $remainingMinutes }}m
                                        </h3>
                                        <p class="mb-0">Total Hours Worked</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-warning text-dark">
                                    <div class="card-body text-center">
                                        <h3>
                                            @php
                                                $daysPresent = $attendances->whereNotNull('check_in')->whereNotNull('check_out')->count();
                                                $avgHours = $daysPresent > 0 ? floor($totalMinutes / $daysPresent / 60) : 0;
                                                $avgMinutes = $daysPresent > 0 ? round(($totalMinutes / $daysPresent) % 60) : 0;
                                            @endphp
                                            {{ $avgHours }}h {{ $avgMinutes }}m
                                        </h3>
                                        <p class="mb-0">Average Hours/Day</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('projectmanager.dashboard', $pm->id ?? 1) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection