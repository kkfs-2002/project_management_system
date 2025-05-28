@extends('layouts.app')

@section('title', 'Add Employee')

@section('content')
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f2f9ff;
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
        color: #007acc;
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
        background-color: #007acc;
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

<h2>Add New Employee</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <h4>1. Basic Information</h4>
    <label>Full Name</label>
    <input type="text" name="full_name" required>

    <label>Employee ID</label>
    <input type="text" name="employee_id" required>

    <label>NIC / Passport No.</label>
    <input type="text" name="nic" required>

    <label>Date of Birth</label>
    <input type="date" name="dob" required>

    <label>Gender</label>
    <select name="gender" required>
        <option value="">Select Gender</option>
        <option>Male</option>
        <option>Female</option>
        <option>Other</option>
    </select>

    <label>Profile Photo</label>
    <input type="file" name="profile_photo">

    <h4>2. Contact Information</h4>
    <label>Phone Number</label>
    <input type="text" name="phone" required>

    <label>Email Address</label>
    <input type="email" name="email" required>

    <label>Residential Address</label>
    <textarea name="address" rows="3" required></textarea>

    <label>Emergency Contact Name</label>
    <input type="text" name="emergency_contact_name" required>

    <label>Emergency Contact Number</label>
    <input type="text" name="emergency_contact_phone" required>

    <h4>3. Job & Employment Details</h4>
    <label>Department</label>
    <input type="text" name="department" required>

    <label>Job Title</label>
    <input type="text" name="job_title" required>

    <label>Employment Type</label>
    <input type="text" name="employment_type" required>

    <label>Date of Joining</label>
    <input type="date" name="date_of_joining" required>

    <label>Employee Status</label>
    <input type="text" name="employee_status" required>

    <label>Supervisor / Reporting Manager</label>
    <input type="text" name="supervisor" required>

    <label>Work Location</label>
    <input type="text" name="work_location" required>

    <h4>4. Login / System Access</h4>
    <label>Username</label>
    <input type="text" name="username" required>

    <label>System Role</label>
    <input type="text" name="role" required>

    <label>Initial Password</label>
    <input type="password" name="password" required>

    <h4>5. Salary & Payroll Info</h4>
    <label>Basic Salary</label>
    <input type="number" step="0.01" name="basic_salary" required>

    <label>Bank Account Number</label>
    <input type="text" name="bank_account_number" required>

    <label>Bank Name</label>
    <input type="text" name="bank_name" required>

    <label>EPF/ETF Number</label>
    <input type="text" name="epf_etf_number">

    <label>Tax Code / TIN</label>
    <input type="text" name="tax_code">

    <h4>6. Documents</h4>
    <label>Resume / CV</label>
    <input type="file" name="resume">

    <label>Offer Letter</label>
    <input type="file" name="offer_letter">

    <label>ID / Passport Copy</label>
    <input type="file" name="id_copy">

    <label>Signed Contract</label>
    <input type="file" name="signed_contract">

    <label>Certificates (Optional)</label>
    <input type="file" name="certificates">

    <button type="submit">Add Employee</button>
</form>
@endsection
