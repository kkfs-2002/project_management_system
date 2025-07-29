@extends('layouts.marketing')

@section('title', 'Marketing Dashboard')

@section('content')
<div class="container py-4">

  <!-- Welcome Banner with Image -->
  <div class="mb-5 position-relative">
    <img src="{{ asset('images/company-bg.jpeg') }}" class="img-fluid w-100"
         style="max-height: 350px; object-fit: cover; filter: brightness(0.5);"
         alt="Company Background">

    <div class="position-absolute top-50 start-50 translate-middle bg-white bg-opacity-75 p-4 rounded shadow"
         style="max-width: 700px;">
      <h3 class="fw-bold mb-2 text-primary">Welcome to NetIT Solutions....!</h3>
      <p class="mb-0 text-dark">
        We specialize in delivering cutting-edge software and digital solutions that drive results.
        From enterprise web apps to mobile platforms, we empower businesses to scale and succeed.
      </p>
    </div>
  </div>

  <!-- Stats Cards Section -->
  <div class="row g-4 justify-content-center text-center">

    <!-- Total Clients -->
    <div class="col-md-5">
      <div class="p-4 bg-white border border-primary rounded shadow-sm h-100">
        <i class="fas fa-users fa-3x text-primary mb-3"></i>
        <h2 class="text-primary fw-bold">
          {{ $totalClients ?? 0 }}
        </h2>
        <p class="text-muted mb-0">Total Clients</p>
        <a href="{{ route('marketing.clients.index') }}" class="btn btn-primary mt-3 w-100">View Clients</a>
      </div>
    </div>

    <!-- Total Reminders -->
    <div class="col-md-5">
      <div class="p-4 bg-white border border-warning rounded shadow-sm h-100">
        <i class="fas fa-bell fa-3x text-warning mb-3"></i>
        <h2 class="text-warning fw-bold">
          {{ $totalReminders ?? 0 }}
        </h2>
        <p class="text-muted mb-0">Total Reminders</p>
        <a href="{{ route('marketing.clients.reminders') }}" class="btn btn-warning text-white mt-3 w-100">View Reminders</a>
      </div>
    </div>

  </div>

</div>
@endsection
