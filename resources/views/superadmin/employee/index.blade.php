@extends('layouts.app')

@section('title', 'Employee List')

@section('content')
<style>
    .employee-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .employee-table th, .employee-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }
    .employee-table th {
        background-color: #005a99;
        color: white;
        text-transform: uppercase;
        font-weight: 600;
    }
    .employee-table tr:hover {
        background-color: #f1faff;
    }
    .action-icons a {
        margin-right: 10px;
        color: #005a99;
        font-size: 18px;
        transition: color 0.3s ease;
    }
    .action-icons a:hover {
        color: #d4af37;
    }
    .profile-photo {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #d4af37;
    }
    .pagination {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }
</style>

<h2>Employee List</h2>

@if(session('success'))
    <div style="color: green; background: #e6ffed; padding: 10px; border-left: 4px solid green; margin-bottom: 15px;">
        {{ session('success') }}
    </div>
@endif

<table class="employee-table">
    <thead>
        <tr>
            <th>Full Name</th>
            <th>Employee ID</th>
            <th>Email</th>
            <th>Department</th>
            <th>Job Title</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($employees as $emp)
            <tr>
                <td>{{ $emp->full_name }}</td>
                <td>{{ $emp->employee_id }}</td>
                <td>{{ $emp->email }}</td>
                <td>{{ $emp->department }}</td>
                <td>{{ $emp->job_title }}</td>
                <td class="action-icons">
                    <a href="{{ route('superadmin.employee.show', $emp->id) }}" title="View">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('superadmin.employee.edit', $emp->id) }}" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('superadmin.employee.destroy', $emp->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this employee?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background:none; border:none; color:#c0392b; cursor:pointer;" title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="pagination">
    {{ $employees->links() }}
</div>

@endsection
