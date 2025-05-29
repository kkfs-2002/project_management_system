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
    .action-icons a, .action-icons button {
        margin-right: 10px;
        color: #005a99;
        font-size: 18px;
        transition: color 0.3s ease;
        background: none;
        border: none;
        cursor: pointer;
    }
    .action-icons a:hover, .action-icons button:hover {
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
    .inline-edit-form input {
        padding: 5px 8px;
        margin-right: 10px;
        width: 150px;
    }
    .inline-edit-form button {
        font-size: 14px;
        padding: 5px 10px;
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
            <th>Phone</th>
            <th>Department</th>
            <th>Job Title</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($employees as $emp)
            <tr id="employee-row-{{ $emp->id }}">
                <td>{{ $emp->full_name }}</td>
                <td>{{ $emp->employee_id }}</td>
                <td>{{ $emp->email }}</td>
                <td>{{ $emp->phone }}</td>
                <td>{{ $emp->department }}</td>
                <td>{{ $emp->job_title }}</td>
                <td class="action-icons">
                    <a href="{{ route('superadmin.employee.show', $emp->id) }}" title="View">
                        <i class="fas fa-eye"></i>
                    </a>
                    <button type="button" class="btn-edit" data-id="{{ $emp->id }}" title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('superadmin.employee.destroy', $emp->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this employee?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color:#c0392b;" title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>

            <tr id="edit-form-row-{{ $emp->id }}" style="display:none; background:#f9f9f9;">
                <td colspan="7">
                    <form method="POST" action="{{ route('superadmin.employee.update', $emp->id) }}" class="inline-edit-form">
                        @csrf
                        @method('PUT')

                        <input type="text" name="full_name" value="{{ $emp->full_name }}" placeholder="Full Name" required>
                        <input type="text" name="employee_id" value="{{ $emp->employee_id }}" placeholder="Employee ID" required>
                        <input type="email" name="email" value="{{ $emp->email }}" placeholder="Email" required>
                        <input type="text" name="phone" value="{{ $emp->phone }}" placeholder="Phone" required>
                        <input type="text" name="department" value="{{ $emp->department }}" placeholder="Department" required>
                        <input type="text" name="job_title" value="{{ $emp->job_title }}" placeholder="Job Title" required>

                        <button type="submit" class="btn btn-success btn-sm">Save</button>
                        <button type="button" class="btn btn-secondary btn-sm btn-cancel" data-id="{{ $emp->id }}">Cancel</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="pagination">
    {{ $employees->links() }}
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.btn-edit').click(function() {
            var id = $(this).data('id');
            $('tr[id^="edit-form-row-"]').hide();
            $('#edit-form-row-' + id).show();
            $('html, body').animate({
                scrollTop: $('#edit-form-row-' + id).offset().top - 100
            }, 500);
        });

        $('.btn-cancel').click(function() {
            var id = $(this).data('id');
            $('#edit-form-row-' + id).hide();
        });
    });
</script>

@endsection
