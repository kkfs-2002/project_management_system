@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Add New Project</h3>
    <form method="POST" action="{{ route('superadmin.project.store') }}">
        @csrf
        <div class="mb-3">
            <label>Project Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Type</label>
            <select name="type" class="form-control" required>
                <option value="">Select Type</option>
                <option value="Website">Website</option>
                <option value="System">System</option>
                <option value="Mobile App">Mobile App</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <button class="btn btn-success">Save Project</button>
    </form>
</div>
@endsection
