@extends('layouts.admin')
@section('content')

<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #F5F5F5;
    }

    form {
        background-color: #ffffff;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        max-width: 900px;
        margin: 0 auto;
        color: #333;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #383838;
    }

    h4 {
        margin-top: 30px;
        color: #005a99;
        border-bottom: 2px solid #cce7ff;
        padding-bottom: 5px;
    }

    input, select, textarea {
        display: block;
        width: 100%;
        padding: 10px 12px;
        margin: 10px 0;
        border-radius: 6px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        font-size: 14px;
    }

    input[type="file"] {
        background-color: #f2f2f2;
    }

    button {
        margin-top: 30px;
        width: 100%;
        padding: 12px;
        background-color:#d4af37;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        transition: 0.3s;
    }

    button:hover {
        background-color: #005f9e;
    }

    .alert-success {
        color: green;
        background: #e6ffed;
        padding: 10px;
        border-left: 4px solid green;
        margin-bottom: 15px;
    }

    label {
        font-weight: 600;
        margin-top: 10px;
        display: block;
    }

    


</style>

<h2>Profile List</h2>

<!-- Filter Form -->
<form method="GET" action="{{ route('profiles.index') }}" 
      style="max-width: 1300px; margin: 0 auto 30px auto; background-color: #ffffff; border-radius: 10px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
    <label for="role">Filter by Role:</label>
    <select name="role" id="role" onchange="this.form.submit()">
        <option value="">-- All Roles --</option>
        @foreach($roles as $role)
            <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
        @endforeach
    </select>
</form>



<table class="table table-bordered">
    <thead>
        <tr>
            <th>Full Name</th>
            <th>Email</th>
            <th>Username</th>
            <th>Password (Hashed)</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($profiles as $profile)
        <tr>
            <td>{{ $profile->full_name }}</td>
            <td>{{ $profile->email }}</td>
            <td>{{ $profile->username }}</td>
            <td>{{ $profile->password }}</td>
            <td>{{ $profile->role }}</td>
            <td><a href="{{ route('profile.show', $profile->id) }}" class="btn btn-secondary btn-sm">Show</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
