@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #2c5aa0;
        --primary-light: #e8eff7;
        --secondary: #6c757d;
        --success: #28a745;
        --light: #f8f9fa;
        --dark: #343a40;
        --border: #dee2e6;
        --shadow: 0 4px 12px rgba(0,0,0,0.08);
        --radius: 12px;
    }
    
    .employee-profile {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .profile-header {
        background: linear-gradient(135deg, var(--primary) 0%, #1e3d72 100%);
        border-radius: var(--radius) var(--radius) 0 0;
        padding: 40px;
        color: white;
        position: relative;
        overflow: hidden;
        margin-top: 50px;
    }
    
    .profile-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        transform: translate(60px, -60px);
    }
    
    .profile-header::after {
        content: '';
        position: absolute;
        bottom: -30px;
        left: -30px;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    
    .employee-basic {
        display: flex;
        align-items: center;
        gap: 25px;
        position: relative;
        z-index: 2;
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        border: 4px solid rgba(255,255,255,0.3);
        backdrop-filter: blur(10px);
    }
    
    .employee-info h2 {
        margin: 0 0 8px 0;
        font-weight: 700;
        font-size: 32px;
    }
    
    .employee-info p {
        margin: 0;
        opacity: 0.9;
        font-size: 18px;
    }
    
    .employee-meta {
        display: flex;
        gap: 20px;
        margin-top: 15px;
        flex-wrap: wrap;
    }
    
    .meta-item {
        background: rgba(255,255,255,0.2);
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 6px;
        backdrop-filter: blur(10px);
    }
    
    .profile-content {
        background: white;
        border-radius: 0 0 var(--radius) var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }
    
    .info-sections {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 0;
    }
    
    .info-card {
        padding: 30px;
        border-bottom: 1px solid var(--border);
        border-right: 1px solid var(--border);
        transition: all 0.3s ease;
    }
    
    .info-card:hover {
        background: var(--primary-light);
    }
    
    .info-card:nth-child(odd):last-child {
        grid-column: 1 / -1;
    }
    
    .info-card:last-child {
        border-right: none;
    }
    
    .card-header {
        display: flex;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--primary-light);
    }
    
    .card-header i {
        background: var(--primary-light);
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        color: var(--primary);
        font-size: 18px;
    }
    
    .card-header h5 {
        margin: 0;
        color: var(--primary);
        font-weight: 700;
        font-size: 18px;
    }
    
    .info-grid {
        display: grid;
        gap: 18px;
    }
    
    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px dashed #f0f0f0;
        transition: all 0.3s ease;
    }
    
    .info-item:hover {
        border-bottom-color: var(--primary);
        transform: translateX(5px);
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-label {
        font-weight: 600;
        color: var(--dark);
        flex: 1;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .info-label i {
        color: var(--primary);
        width: 20px;
        text-align: center;
    }
    
    .info-value {
        flex: 1;
        text-align: right;
        color: var(--secondary);
        font-weight: 500;
    }
    
    .badge-status {
        background: var(--success);
        color: white;
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .action-buttons {
        display: flex;
        gap: 15px;
        padding: 30px;
        background: #f8f9fa;
        border-top: 1px solid var(--border);
        flex-wrap: wrap;
    }
    
    .btn-custom {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s;
        text-decoration: none;
        font-size: 15px;
        border: none;
        cursor: pointer;
    }
    
    .btn-primary-custom {
        background: var(--primary);
        color: white;
    }
    
    .btn-primary-custom:hover {
        background: #1e3d72;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        color: white;
    }
    
    .btn-outline-custom {
        background: white;
        color: var(--primary);
        border: 2px solid var(--primary);
    }
    
    .btn-outline-custom:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
        color: var(--primary);
    }
    
    .btn-success-custom {
        background: var(--success);
        color: white;
    }
    
    .btn-success-custom:hover {
        background: #218838;
        transform: translateY(-2px);
        color: white;
    }
    
    .contact-info {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 5px;
    }
    
    .contact-info i {
        color: var(--primary);
    }
    
    @media (max-width: 768px) {
        .employee-basic {
            flex-direction: column;
            text-align: center;
        }
        
        .employee-meta {
            justify-content: center;
        }
        
        .info-sections {
            grid-template-columns: 1fr;
        }
        
        .info-card {
            border-right: none;
            padding: 20px;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-custom {
            justify-content: center;
        }
        
        .profile-header {
            padding: 30px 20px;
        }
    }
    
    .section-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--border), transparent);
        margin: 10px 0;
    }
</style>

<div class="employee-profile">
    <div class="profile-header">
        <div class="employee-basic">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="employee-info">
                <h2>{{ $employee->full_name }}</h2>
                <p>{{ $employee->job_title }}</p>
                <div class="employee-meta">
                    <div class="meta-item">
                        <i class="fas fa-id-badge"></i>
                        <span>Employee ID: {{ $employee->employee_id ?? 'N/A' }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-building"></i>
                        <span>{{ $employee->department ?? 'N/A' }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-circle"></i>
                        <span class="badge-status">Active</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="profile-content">
        <div class="info-sections">
            <!-- Personal Information -->
            <div class="info-card">
                <div class="card-header">
                    <i class="fas fa-user-circle"></i>
                    <h5>Personal Information</h5>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-user"></i>
                            Full Name
                        </span>
                        <span class="info-value">{{ $employee->full_name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-calendar"></i>
                            Date of Birth
                        </span>
                        <span class="info-value">
                            @if($employee->dob)
                                {{ \Carbon\Carbon::parse($employee->dob)->format('F d, Y') }}
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-venus-mars"></i>
                            Gender
                        </span>
                        <span class="info-value">{{ $employee->gender ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-id-card"></i>
                            NIC/Passport
                        </span>
                        <span class="info-value">{{ $employee->nic }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="info-card">
                <div class="card-header">
                    <i class="fas fa-address-book"></i>
                    <h5>Contact Information</h5>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-envelope"></i>
                            Email Address
                        </span>
                        <span class="info-value">
                            <div>
                                {{ $employee->email }}
                                <div class="contact-info">
                                    <i class="fas fa-check-circle"></i>
                                    <small>Verified</small>
                                </div>
                            </div>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-phone"></i>
                            Phone Number
                        </span>
                        <span class="info-value">{{ $employee->phone }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-home"></i>
                            Address
                        </span>
                        <span class="info-value">{{ $employee->address ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-exclamation-triangle"></i>
                            Emergency Contact
                        </span>
                        <span class="info-value">
                            @if($employee->emergency_contact_name && $employee->emergency_contact_phone)
                                {{ $employee->emergency_contact_name }} 
                                <div class="contact-info">
                                    <i class="fas fa-phone"></i>
                                    {{ $employee->emergency_contact_phone }}
                                </div>
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Employment Details -->
            <div class="info-card">
                <div class="card-header">
                    <i class="fas fa-briefcase"></i>
                    <h5>Employment Details</h5>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-user-tie"></i>
                            Job Title
                        </span>
                        <span class="info-value">{{ $employee->job_title }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-building"></i>
                            Department
                        </span>
                        <span class="info-value">{{ $employee->department ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-file-contract"></i>
                            Employment Type
                        </span>
                        <span class="info-value">{{ $employee->employment_type ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-calendar-check"></i>
                            Date of Joining
                        </span>
                        <span class="info-value">
                            @if($employee->date_of_joining)
                                {{ \Carbon\Carbon::parse($employee->date_of_joining)->format('F d, Y') }}
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-chart-line"></i>
                            Employee Status
                        </span>
                        <span class="info-value">
                            <span class="badge-status">{{ $employee->employee_status ?? 'Active' }}</span>
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Additional Information -->
            <div class="info-card">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i>
                    <h5>Work Information</h5>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Work Location
                        </span>
                        <span class="info-value">{{ $employee->work_location ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-user-shield"></i>
                            Supervisor
                        </span>
                        <span class="info-value">{{ $employee->supervisor ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-user-circle"></i>
                            Username
                        </span>
                        <span class="info-value">{{ $employee->username ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-shield-alt"></i>
                            System Role
                        </span>
                        <span class="info-value">{{ $employee->role ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="action-buttons">
          
           
            <!-- Using the correct route name based on your list view -->
            @if(Route::has('superadmin.employee.index'))
                <a href="{{ route('superadmin.employee.index') }}" class="btn-custom btn-outline-custom">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            @else
                <a href="javascript:history.back()" class="btn-custom btn-outline-custom">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            @endif
            
            <button class="btn-custom btn-success-custom" onclick="exportEmployeeData()">
                <i class="fas fa-download"></i> Export Details
            </button>
            
            <button class="btn-custom btn-outline-custom" onclick="window.print()">
                <i class="fas fa-print"></i> Print Profile
            </button>
        </div>
    </div>
</div>

<!-- Font Awesome for icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

<script>
    function exportEmployeeData() {
        alert('Export functionality would be implemented here');
        // In a real application, this would generate a PDF or Excel file
    }
</script>

@endsection