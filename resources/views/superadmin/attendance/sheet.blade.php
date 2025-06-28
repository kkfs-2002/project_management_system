@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Attendance Sheet</h2>

    <form method="GET" action="{{ route('attendance.sheet') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="date" class="form-label">Filter by Day</label>
            <input type="date" class="form-control" name="date" value="{{ request('date') }}">
        </div>
        <div class="col-md-4">
            <label for="month" class="form-label">Filter by Month</label>
            <select class="form-select" name="month">
                <option value="">Select Month</option>
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                    </option>
                @endfor
            </select>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Employee Name</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attendances as $attendance)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $attendance->profile->full_name ?? 'N/A' }}</td>
                    <td>{{ $attendance->check_in }}</td>
                    <td>{{ $attendance->check_out }}</td>
                    <td>{{ \Carbon\Carbon::parse($attendance->date)->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No attendance records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
