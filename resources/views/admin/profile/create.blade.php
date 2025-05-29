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

<div class="container">
  <h2 class="my-4">Add New Employee Profile</h2>

  @if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- 1. Basic Details -->
    <h4>1. Basic Details</h4>
    <div class="form-group">
      <label>Full Name</label>
      <input type="text" name="full_name" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Employee ID</label>
      <input type="text" name="employee_id" class="form-control" required>
    </div>

    <div class="form-group">
      <label>NIC / Passport No.</label>
      <input type="text" name="nic" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Date of Birth</label>
      <input type="date" name="dob" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Gender</label>
      <select name="gender" class="form-control" required>
        <option value="">Select Gender</option>
        <option>Male</option>
        <option>Female</option>
        <option>Other</option>
      </select>
    </div>

    <div class="form-group">
      <label>Profile Photo</label>
      <input type="file" name="profile_photo" class="form-control-file">
    </div>

    <!-- 2. Contact Details -->
    <h4>2. Contact Details</h4>
    <div class="form-group">
      <label>Phone Number</label>
      <input type="text" name="phone" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Email Address</label>
      <input type="email" name="email" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Residential Address</label>
      <textarea name="address" class="form-control" rows="3" required></textarea>
    </div>

    <div class="form-group">
      <label>Emergency Contact Name</label>
      <input type="text" name="emergency_contact_name" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Emergency Contact Number</label>
      <input type="text" name="emergency_contact_phone" class="form-control" required>
    </div>

    <!-- 3. Job & Employment Details -->
    <h4>3. Job & Employment Details</h4>
    <div class="form-group">
      <label>Department</label>
      <input type="text" name="department" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Job Title</label>
      <select name="job_title" class="form-control" required>
        <option value="">Select Job Title</option>
        <option>Senior Developer</option>
        <option>Junior Developer</option>
        <option>Intern/Trainee</option>
        <option>Web Designer</option>
        <option>Project Manager</option>
        <option>Quality Analyst</option>
        <option>Business Analyst</option>
        <option>UI/UX Designer</option>
        <option>Marketing Manager</option>
      </select>
    </div>

    <div class="form-group">
      <label>Employment Type</label>
      <input type="text" name="employment_type" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Date of Joining</label>
      <input type="date" name="date_of_joining" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Employee Status</label>
      <input type="text" name="employee_status" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Supervisor / Reporting Manager</label>
      <input type="text" name="supervisor" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Work Location</label>
      <input type="text" name="work_location" class="form-control" required>
    </div>

    <!-- 4. Login / System Access -->
    <h4>4. Login / System Access</h4>
    <div class="form-group">
      <label>Username</label>
      <input type="text" name="username" class="form-control" required>
    </div>

    <div class="form-group">
      <label>System Role</label>
      <select name="role" class="form-control" required>
        <option value="">Select Role</option>
        <option>Super Admin</option>
        <option>Admin</option>
        <option>Developer</option>
        <option>Graphic Designer</option>
        <option>Project Manager</option>
        <option>Quality Analyst</option>
        <option>Business Analyst</option>
        <option>Marketing Manager</option>
      </select>
    </div>

    <div class="form-group">
      <label>Initial Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <!-- 5. Salary & Payroll Info -->
    <h4>5. Salary & Payroll Info</h4>
    <div class="form-group">
      <label>Basic Salary</label>
      <input type="number" step="0.01" name="basic_salary" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Bank Account Number</label>
      <input type="text" name="bank_account_number" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Bank Name</label>
      <input type="text" name="bank_name" class="form-control" required>
    </div>

    <div class="form-group">
      <label>EPF/ETF Number</label>
      <input type="text" name="epf_etf_number" class="form-control">
    </div>

    <div class="form-group">
      <label>Tax Code / TIN</label>
      <input type="text" name="tax_code" class="form-control">
    </div>

    <!-- 6. Documents -->
    <h4>6. Documents</h4>
    <div class="form-group">
      <label for="resume">Resume / CV</label>
      <input type="file" name="resume" id="resume" class="form-control-file">
    </div>
    <br>

    <div class="form-group">
      <label for="offer_letter">Offer Letter</label>
      <input type="file" name="offer_letter" id="offer_letter" class="form-control-file">
    </div>
    <br>

    <div class="form-group">
      <label for="id_copy">ID / Passport Copy</label>
      <input type="file" name="id_copy" id="id_copy" class="form-control-file">
    </div>
    <br>

    <div class="form-group">
      <label for="signed_contract">Signed Contract</label>
      <input type="file" name="signed_contract" id="signed_contract" class="form-control-file">
    </div>
    <br>

    <div class="form-group">
      <label for="certificates">Certificates (Optional)</label>
      <input type="file" name="certificates" id="certificates" class="form-control-file">
    </div>

    <button type="submit" class="btn btn-secondary mt-4">Add Profile</button>
  </form>
</div>
@endsection