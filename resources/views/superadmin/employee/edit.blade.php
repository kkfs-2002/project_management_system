@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Employee</h2>
    <form method="POST" action="{{ route('superadmin.employee.update', $employee->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="full_name" value="{{ $employee->full_name }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ $employee->email }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" value="{{ $employee->phone }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
