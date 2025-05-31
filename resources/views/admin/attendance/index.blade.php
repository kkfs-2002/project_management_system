@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 fw-bold">Attendance Tracker</h2>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

    <!-- Filter Section -->
    <form method="GET" action="{{ route('attendance.index') }}" class="row g-3 align-items-center mb-4">
        <div class="col-auto">
            <input type="date" name="date" value="{{ request('date') ?? date('Y-m-d') }}" class="form-control">
        </div>

        <div class="col-auto">
            <select name="department" class="form-select">
                <option value="">All Departments</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->department }}" {{ request('department') == $dept->department ? 'selected' : '' }}>
                        {{ $dept->department }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-auto">
            <button class="btn btn-primary px-4">Filter</button>
        </div>
    </form>

    <!-- Attendance Form -->
    <form method="POST" action="{{ route('attendance.store') }}">
        @csrf
        <input type="hidden" name="date" value="{{ $date }}">

        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Present</th>
                        <th>Name</th>
                        <th>Check-In</th>
                        <th>Check-Out</th>
                        <th>Total Hours</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($profiles as $profile)
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input present-toggle" name="attendances[{{ $profile->id }}][present]">
                        </td>
                        <td>{{ $profile->full_name }}</td>
                        <td>
                            <input type="time" class="form-control check-in" name="attendances[{{ $profile->id }}][check_in]" disabled>
                        </td>
                        <td>
                            <input type="time" class="form-control check-out" name="attendances[{{ $profile->id }}][check_out]" disabled>
                        </td>
                        <td>
                            <input type="text" class="form-control total-hours bg-light" name="attendances[{{ $profile->id }}][total_hours]" readonly>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success px-5 py-2">Save Attendance</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.present-toggle').forEach(toggle => {
        toggle.addEventListener('change', function () {
            const row = this.closest('tr');
            const checkIn = row.querySelector('.check-in');
            const checkOut = row.querySelector('.check-out');
            const total = row.querySelector('.total-hours');

            if (this.checked) {
                checkIn.removeAttribute('disabled');
                checkOut.removeAttribute('disabled');
            } else {
                checkIn.value = '';
                checkOut.value = '';
                total.value = '';
                checkIn.setAttribute('disabled', true);
                checkOut.setAttribute('disabled', true);
            }
        });
    });

    document.querySelectorAll('.check-in, .check-out').forEach(input => {
        input.addEventListener('input', function () {
            const row = this.closest('tr');
            const checkIn = row.querySelector('.check-in').value;
            const checkOut = row.querySelector('.check-out').value;
            const total = row.querySelector('.total-hours');

            if (checkIn && checkOut) {
                const inTime = new Date(`1970-01-01T${checkIn}`);
                const outTime = new Date(`1970-01-01T${checkOut}`);
                const hours = (outTime - inTime) / (1000 * 60 * 60);
                total.value = hours > 0 ? hours.toFixed(2) : '0.00';
            } else {
                total.value = '';
            }
        });
    });
});
</script>
@endsection
