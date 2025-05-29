@extends('layouts.admin')

@section('content')
<div class="container">

    <h2 class="mb-4 mt-2 text-center fw-bold">Employee Profile Details</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-lg-8 offset-lg-2">

            <div class="list-group shadow-sm rounded">

                <!-- 1. Basic Details -->
                <div class="list-group-item list-group-item-dark fw-semibold">Basic Details</div>
                <div class="list-group-item"><strong>Full Name:</strong> {{ $profile->full_name }}</div>
                <div class="list-group-item"><strong>Employee ID:</strong> {{ $profile->employee_id }}</div>
                <div class="list-group-item"><strong>NIC / Passport No.:</strong> {{ $profile->nic }}</div>
                <div class="list-group-item"><strong>Date of Birth:</strong> {{ $profile->dob }}</div>
                <div class="list-group-item"><strong>Gender:</strong> {{ $profile->gender }}</div>
                <div class="list-group-item">
                    <strong>Profile Photo:</strong><br>
                    @if($profile->profile_photo)
                        <img src="{{ asset('storage/' . $profile->profile_photo) }}" class="img-thumbnail mt-2" width="150" alt="Profile Photo">
                    @else
                        <span class="text-muted">No photo uploaded.</span>
                    @endif
                </div>

                <!-- 2. Contact Details -->
                <div class="list-group-item list-group-item-dark fw-semibold">Contact Details</div>
                <div class="list-group-item"><strong>Phone Number:</strong> {{ $profile->phone }}</div>
                <div class="list-group-item"><strong>Email:</strong> {{ $profile->email }}</div>
                <div class="list-group-item"><strong>Address:</strong> {{ $profile->address }}</div>
                <div class="list-group-item"><strong>Emergency Contact Name:</strong> {{ $profile->emergency_contact_name }}</div>
                <div class="list-group-item"><strong>Emergency Contact Phone:</strong> {{ $profile->emergency_contact_phone }}</div>

                <!-- 3. Job & Employment Details -->
                <div class="list-group-item list-group-item-dark fw-semibold">Job & Employment Details</div>
                <div class="list-group-item"><strong>Department:</strong> {{ $profile->department }}</div>
                <div class="list-group-item"><strong>Job Title:</strong> {{ $profile->job_title }}</div>
                <div class="list-group-item"><strong>Employment Type:</strong> {{ $profile->employment_type }}</div>
                <div class="list-group-item"><strong>Date of Joining:</strong> {{ $profile->date_of_joining }}</div>
                <div class="list-group-item"><strong>Employee Status:</strong> {{ $profile->employee_status }}</div>
                <div class="list-group-item"><strong>Supervisor:</strong> {{ $profile->supervisor }}</div>
                <div class="list-group-item"><strong>Work Location:</strong> {{ $profile->work_location }}</div>

                <!-- 4. Login / System Access -->
                <div class="list-group-item list-group-item-dark fw-semibold">Login / System Access</div>
                <div class="list-group-item"><strong>Username:</strong> {{ $profile->username }}</div>
                <div class="list-group-item"><strong>Role:</strong> {{ $profile->role }}</div>

                <!-- 5. Salary & Payroll Info -->
                <div class="list-group-item list-group-item-dark fw-semibold">Salary & Payroll Info</div>
                <div class="list-group-item"><strong>Basic Salary:</strong> Rs. {{ number_format($profile->basic_salary, 2) }}</div>
                <div class="list-group-item"><strong>Bank Account Number:</strong> {{ $profile->bank_account_number }}</div>
                <div class="list-group-item"><strong>Bank Name:</strong> {{ $profile->bank_name }}</div>
                <div class="list-group-item"><strong>EPF/ETF Number:</strong> {{ $profile->epf_etf_number }}</div>
                <div class="list-group-item"><strong>Tax Code / TIN:</strong> {{ $profile->tax_code }}</div>

                <!-- 6. Documents -->
                <div class="list-group-item list-group-item-dark fw-semibold">Documents</div>

                <div class="list-group-item">
                    <strong>Resume / CV:</strong><br>
                    @if($profile->resume)
                        <a href="{{ asset('storage/' . $profile->resume) }}" target="_blank">View Resume</a>
                    @else
                        <span class="text-muted">Not uploaded</span>
                    @endif
                </div>
                <div class="list-group-item">
                    <strong>Offer Letter:</strong><br>
                    @if($profile->offer_letter)
                        <a href="{{ asset('storage/' . $profile->offer_letter) }}" target="_blank">View Offer Letter</a>
                    @else
                        <span class="text-muted">Not uploaded</span>
                    @endif
                </div>
                <div class="list-group-item">
                    <strong>ID Copy:</strong><br>
                    @if($profile->id_copy)
                        <a href="{{ asset('storage/' . $profile->id_copy) }}" target="_blank">View ID</a>
                    @else
                        <span class="text-muted">Not uploaded</span>
                    @endif
                </div>
                <div class="list-group-item">
                    <strong>Signed Contract:</strong><br>
                    @if($profile->signed_contract)
                        <a href="{{ asset('storage/' . $profile->signed_contract) }}" target="_blank">View Contract</a>
                    @else
                        <span class="text-muted">Not uploaded</span>
                    @endif
                </div>
                <div class="list-group-item">
                    <strong>Certificates:</strong><br>
                    @if($profile->certificates)
                        <a href="{{ asset('storage/' . $profile->certificates) }}" target="_blank">View Certificates</a>
                    @else
                        <span class="text-muted">Not uploaded</span>
                    @endif
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
