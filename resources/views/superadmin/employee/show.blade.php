@extends('layouts.app')

@section('content')


<div class="container my-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-secondary text-white">
            <h4 class="mb-0">Employee Details</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped mb-0">
                <tr>
                    <th style="width: 30%;">Name</th>
                    <td>{{ $employee->full_name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $employee->email }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $employee->phone }}</td>
                </tr>
                <tr>
                    <th>NIC</th>
                    <td>{{ $employee->nic }}</td>
                </tr>
                <tr>
                    <th>Date of Birth</th>
                    <td>{{ $employee->dob }}</td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td>{{ $employee->gender }}</td>
                </tr>
                <tr>
                    <th>Job Position</th>
                    <td>{{ $employee->job_title }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
