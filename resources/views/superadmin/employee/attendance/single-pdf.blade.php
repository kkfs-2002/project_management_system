
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Attendance – {{ $employee->full_name }}</title>
<style>
 body{font-family:DejaVu Sans, sans-serif; font-size:12px;}
 h3{margin:0 0 6px 0;}
 table{width:100%;border-collapse:collapse;margin-top:10px;}
 th,td{border:1px solid #000;padding:4px 6px;}
</style>
</head>
<body>

<h3>Attendance Summary – {{ $month }}</h3>
<p><strong>Employee:</strong> {{ $employee->full_name }}</p>
<p><strong>Days Present:</strong> {{ $daysPresent }}</p>
<p><strong>Total Hours:</strong> {{ $totalHours }}</p>
<p><strong>Generated:</strong> {{ $generatedDate ?? now()->format('d M Y') }}</p>

<h4 style="margin-top:20px;">Daily Hours</h4>
<table>
  <thead>
     <tr><th>Date</th><th>Hours</th></tr>
  </thead>
  <tbody>
    @foreach($dailyHours as $date=>$hrs)
      <tr><td>{{ $date }}</td><td>{{ $hrs }}</td></tr>
    @endforeach
  </tbody>
</table>

</body>
</html>