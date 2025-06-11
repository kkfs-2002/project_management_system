@extends('layouts.marketing')

@section('title', 'Marketing Dashboard')

@section('content')
<div class="container">
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body text-center">
          <i class="fas fa-users fa-2x text-primary mb-3"></i>
          <h5 class="card-title">View All Clients</h5>
          <p class="card-text">Browse and manage all existing clients.</p>
          <a href="{{ route('marketing.clients.index') }}" class="btn btn-primary w-100">Go</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body text-center">
          <i class="fas fa-user-plus fa-2x text-success mb-3"></i>
          <h5 class="card-title">Add New Client</h5>
          <p class="card-text">Create a new client entry quickly.</p>
          <a href="{{ route('marketing.clients.create') }}" class="btn btn-success w-100">Add</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body text-center">
          <i class="fas fa-bell fa-2x text-warning mb-3"></i>
          <h5 class="card-title">View Reminders</h5>
          <p class="card-text">Check client follow-up reminders.</p>
          <a href="{{ route('marketing.clients.reminders') }}" class="btn btn-warning w-100 text-white">Reminders</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
