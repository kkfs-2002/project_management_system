{{-- 
    Reusable Attendance Card Component
    Save as: resources/views/components/attendancecard.blade.php
    
    Usage in any blade file:
    @include('components.attendancecard', ['todayAttendance' => $todayAttendance, 'routePrefix' => 'projectmanager'])
--}}

@php
    $routePrefix = $routePrefix ?? 'attendance'; // Default route prefix
@endphp

<div class="row mb-4">
    <div class="col-lg-6 mx-auto">
        <div class="attendance-card">
            <div class="text-center">
                <h3 class="mb-3">
                    <i class="fas fa-clock me-2"></i>My Attendance
                </h3>
                
                <div class="time-display" id="currentTime">
                    {{ now()->format('h:i:s A') }}
                </div>
                
                <div class="attendance-status mb-3">
                    {{ now()->format('l, F d, Y') }}
                </div>

                @if(session('attendance_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('attendance_message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('attendance_error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('attendance_error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(isset($todayAttendance) && $todayAttendance)
                    <div class="attendance-info">
                        <div class="row">
                            <div class="col-6">
                                <p class="mb-1"><strong>Check In:</strong></p>
                                <p class="h5">{{ $todayAttendance->check_in ? \Carbon\Carbon::parse($todayAttendance->check_in)->format('h:i A') : '-' }}</p>
                            </div>
                            <div class="col-6">
                                <p class="mb-1"><strong>Check Out:</strong></p>
                                <p class="h5">{{ $todayAttendance->check_out ? \Carbon\Carbon::parse($todayAttendance->check_out)->format('h:i A') : '-' }}</p>
                            </div>
                        </div>
                        @if($todayAttendance->check_in && $todayAttendance->check_out)
                            <div class="mt-2">
                                <p class="mb-1"><strong>Total Hours:</strong></p>
                                <p class="h5">
                                    @php
                                        $checkIn = \Carbon\Carbon::parse($todayAttendance->check_in);
                                        $checkOut = \Carbon\Carbon::parse($todayAttendance->check_out);
                                        $diff = $checkIn->diff($checkOut);
                                    @endphp
                                    {{ $diff->h }}h {{ $diff->i }}m
                                </p>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="mt-4">
                    @if(!isset($todayAttendance) || !$todayAttendance || !$todayAttendance->check_in)
                        <form action="{{ route($routePrefix . '.attendance.checkin') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-attendance btn-check-in text-white">
                                <i class="fas fa-sign-in-alt me-2"></i>Check In
                            </button>
                        </form>
                    @elseif($todayAttendance->check_in && !$todayAttendance->check_out)
                        <form action="{{ route($routePrefix . '.attendance.checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-attendance btn-check-out text-white">
                                <i class="fas fa-sign-out-alt me-2"></i>Check Out
                            </button>
                        </form>
                    @else
                        <div class="alert alert-light" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            You have completed your attendance for today!
                        </div>
                    @endif
                </div>

                @if(isset($todayAttendance) && $todayAttendance)
                    <div class="mt-3">
                        <a href="{{ route($routePrefix . '.attendance.history') }}" class="btn btn-sm btn-outline-light">
                            <i class="fas fa-history me-2"></i>View History
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .attendance-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 25px;
        color: white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .attendance-status {
        font-size: 1.2rem;
        font-weight: 600;
    }
    .time-display {
        font-size: 2rem;
        font-weight: bold;
        margin: 15px 0;
    }
    .btn-attendance {
        padding: 12px 30px;
        font-size: 1.1rem;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-check-in {
        background-color: #10b981;
        border: none;
    }
    .btn-check-in:hover {
        background-color: #059669;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
    }
    .btn-check-out {
        background-color: #ef4444;
        border: none;
    }
    .btn-check-out:hover {
        background-color: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(239, 68, 68, 0.4);
    }
    .attendance-info {
        background-color: rgba(255,255,255,0.2);
        border-radius: 10px;
        padding: 15px;
        margin-top: 20px;
    }
</style>

<script>
// Real-time clock update
function updateTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('en-US', { 
        hour: '2-digit', 
        minute: '2-digit', 
        second: '2-digit',
        hour12: true 
    });
    const timeElement = document.getElementById('currentTime');
    if (timeElement) {
        timeElement.textContent = timeString;
    }
}

// Update time every second
setInterval(updateTime, 1000);
updateTime();
</script>