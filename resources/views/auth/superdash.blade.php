@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
 <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Stats Rectangles</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background: #f0f2f5;
    padding: 20px;
  }
  .stats-container {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
  }
  .stat-box {
    background: white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-radius: 8px;
    padding: 25px 30px;
    flex: 1 1 200px;
    min-width: 180px;
    text-align: center;
  }
  .stat-number {
    font-size: 2.5rem;
    font-weight: bold;
    color: #2a9d8f;
    margin-bottom: 8px;
  }
  .stat-label {
    font-size: 1.1rem;
    color: #555;
    text-transform: uppercase;
    letter-spacing: 1.2px;
  }
</style>
</head>
<body>

<div class="stats-container">
  <div class="stat-box">
    <div class="stat-number">1200</div>
    <div class="stat-label">Total Users</div>
  </div>

  <div class="stat-box">
    <div class="stat-number">850</div>
    <div class="stat-label">Active Users</div>
  </div>

  <div class="stat-box">
    <div class="stat-number">400</div>
    <div class="stat-label">Total Orders</div>
  </div>

  <div class="stat-box">
    <div class="stat-number">50</div>
    <div class="stat-label">Pending</div>
  </div>
</div>

</body>
</html>

@endsection
