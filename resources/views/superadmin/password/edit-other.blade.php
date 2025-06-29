
@extends('layouts.app')
@section('content')
<div class="container py-4">
  <h4>Reset Password for {{ $profile->full_name }}</h4>
  <form method="POST" action="{{ route('superadmin.password.updateOther', $profile->id) }}">
    @csrf

    <div class="mb-3">
      <label>New Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Confirm Password</label>
      <input type="password" name="password_confirmation" class="form-control" required>
    </div>

    <button class="btn btn-danger">Reset Password</button>
  </form>

  @if(session('success'))
    <div class="alert alert-success mt-3">{{ session('success') }}</div>
  @endif
</div>
@endsection