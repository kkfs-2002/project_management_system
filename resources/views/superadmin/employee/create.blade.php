@extends('layouts.app')

@section('title', 'Add Employee')

@section('content')
 <style>
        :root {
            --primary: #2c5aa0;
            --primary-dark: #1e3d72;
            --secondary: #6c757d;
            --success: #28a745;
            --light: #f8f9fa;
            --dark: #343a40;
            --border: #dee2e6;
            --shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: var(--shadow);
            margin-top: 90px;
        }
        
        .header h1 {
            color: var(--primary);
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .header p {
            color: var(--secondary);
            font-size: 16px;
        }
        
        .form-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .form-card {
            background: white;
            border-radius: 10px;
            box-shadow: var(--shadow);
            padding: 25px;
            flex: 1;
            min-width: 300px;
        }
        
        .form-section {
            margin-bottom: 30px;
        }
        
        .section-title {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
            color: var(--primary);
            font-weight: 600;
        }
        
        .section-title i {
            margin-right: 10px;
            font-size: 18px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.1);
        }
        
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }
        
        .file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        
        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 15px;
            background-color: #f8f9fa;
            border: 1px dashed var(--border);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .file-upload-label:hover {
            background-color: #e9ecef;
        }
        
        .file-upload-label i {
            margin-right: 8px;
            color: var(--secondary);
        }
        
        .file-upload input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .btn-submit {
            display: block;
            width: 100%;
            padding: 14px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 20px;
        }
        
        .btn-submit:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        
        .alert-success {
            padding: 15px;
            background-color: #d4edda;
            color: #155724;
            border-radius: 6px;
            margin-bottom: 20px;
            border-left: 4px solid var(--success);
        }
        
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .form-row .form-group {
            flex: 1;
            min-width: 200px;
        }
        
        @media (max-width: 768px) {
            .form-card {
                min-width: 100%;
            }
            
            .form-row .form-group {
                min-width: 100%;
            }
        }
        
        .required::after {
            content: " *";
            color: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-user-plus"></i> Add New Employee</h1>
            <p>Fill in the employee details below to add them to the system</p>
        </div>
        
        <!-- Success Message -->
        <div class="alert-success" style="display: none;">
            <i class="fas fa-check-circle"></i> Employee added successfully!
        </div>
        
        <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data" id="employeeForm">
            @csrf
            
            <div class="form-container">
                <!-- Left Column -->
                <div class="form-card">
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-id-card"></i> Basic Information
                        </div>
                        
                        <div class="form-group">
                            <label for="full_name" class="required">Full Name</label>
                            <input type="text" id="full_name" name="full_name" class="form-control" required>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="employee_id" class="required">Employee ID</label>
                                <input type="text" id="employee_id" name="employee_id" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="nic" class="required">NIC / Passport No.</label>
                                <input type="text" id="nic" name="nic" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="dob" class="required">Date of Birth</label>
                                <input type="date" id="dob" name="dob" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="gender" class="required">Gender</label>
                                <select id="gender" name="gender" class="form-control" required>
                                    <option value="">Select Gender</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="profile_photo">Profile Photo</label>
                            <div class="file-upload">
                                <label class="file-upload-label">
                                    <i class="fas fa-cloud-upload-alt"></i> Choose File
                                </label>
                                <input type="file" id="profile_photo" name="profile_photo" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-phone"></i> Contact Information
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone" class="required">Phone Number</label>
                                <input type="text" id="phone" name="phone" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email" class="required">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="address" class="required">Residential Address</label>
                            <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="emergency_contact_name" class="required">Emergency Contact Name</label>
                                <input type="text" id="emergency_contact_name" name="emergency_contact_name" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="emergency_contact_phone" class="required">Emergency Contact Number</label>
                                <input type="text" id="emergency_contact_phone" name="emergency_contact_phone" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="form-card">
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-briefcase"></i> Job & Employment Details
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="department" class="required">Department</label>
                                <input type="text" id="department" name="department" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="job_title" class="required">Job Title</label>
                                <input type="text" id="job_title" name="job_title" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="employment_type" class="required">Employment Type</label>
                                <input type="text" id="employment_type" name="employment_type" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="date_of_joining" class="required">Date of Joining</label>
                                <input type="date" id="date_of_joining" name="date_of_joining" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="employee_status" class="required">Employee Status</label>
                                <input type="text" id="employee_status" name="employee_status" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="supervisor" class="required">Supervisor / Reporting Manager</label>
                                <input type="text" id="supervisor" name="supervisor" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="work_location" class="required">Work Location</label>
                            <input type="text" id="work_location" name="work_location" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-lock"></i> Login / System Access
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="username" class="required">Username</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="role" class="required">System Role</label>
                                <input type="text" id="role" name="role" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="password" class="required">Initial Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-file-alt"></i> Documents
                        </div>
                        
                        <div class="form-group">
                            <label for="resume">Resume / CV</label>
                            <div class="file-upload">
                                <label class="file-upload-label">
                                    <i class="fas fa-file-pdf"></i> Upload Resume
                                </label>
                                <input type="file" id="resume" name="resume" class="form-control">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="offer_letter">Offer Letter</label>
                            <div class="file-upload">
                                <label class="file-upload-label">
                                    <i class="fas fa-file-contract"></i> Upload Offer Letter
                                </label>
                                <input type="file" id="offer_letter" name="offer_letter" class="form-control">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="id_copy">ID / Passport Copy</label>
                            <div class="file-upload">
                                <label class="file-upload-label">
                                    <i class="fas fa-id-card"></i> Upload ID Copy
                                </label>
                                <input type="file" id="id_copy" name="id_copy" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Bottom Section -->
                <div class="form-card" style="flex-basis: 100%;">
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-money-bill-wave"></i> Salary & Payroll Info
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="basic_salary" class="required">Basic Salary</label>
                                <input type="number" step="0.01" id="basic_salary" name="basic_salary" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="bank_account_number" class="required">Bank Account Number</label>
                                <input type="text" id="bank_account_number" name="bank_account_number" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="bank_name" class="required">Bank Name</label>
                                <input type="text" id="bank_name" name="bank_name" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="epf_etf_number">EPF/ETF Number</label>
                                <input type="text" id="epf_etf_number" name="epf_etf_number" class="form-control">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="tax_code">Tax Code / TIN</label>
                            <input type="text" id="tax_code" name="tax_code" class="form-control">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-user-plus"></i> Add Employee
                    </button>
                </div>
            </div>
        </form>
@endsection
