<h3>Attendance Summary for {{ $month }}</h3>

<h4>Daily Attendance</h4>
<ul>
    @foreach ($dailyCount as $date => $count)
        <li>{{ $date }}: {{ $count }} present</li>
    @endforeach
</ul>

<h4>Employee Total Hours</h4>
<ul>
    @foreach ($employeeProgress as $emp)
        <li>{{ $emp['name'] }}: {{ $emp['hours'] }} hours</li>
    @endforeach
</ul>
