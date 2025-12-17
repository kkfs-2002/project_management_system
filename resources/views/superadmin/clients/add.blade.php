@extends('layouts.app')
@section('title', 'Add Marketing Project')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            margin-top: 60px;
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
      
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.1);
        }
      
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }
      
        select.form-control {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            padding-right: 40px;
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
            display: none;
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
        .call-sequence-options {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        .call-option {
            flex: 1;
            min-width: 100px;
        }
        .call-option input[type="radio"] {
            display: none;
        }
        .call-option label {
            display: block;
            padding: 12px 20px;
            border: 2px solid var(--border);
            border-radius: 6px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }
        .call-option input[type="radio"]:checked + label {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        .call-option label:hover {
            border-color: var(--primary);
            background-color: rgba(44, 90, 160, 0.05);
        }
        .call-option input[type="radio"]:checked + label:hover {
            background-color: var(--primary-dark);
        }

        .alert-warning {
            padding: 15px;
            background-color: #fff3cd;
            color: #856404;
            border-radius: 6px;
            margin-bottom: 20px;
            border-left: 4px solid #ffc107;
            display: none;
        }
    </style>
   
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-project-diagram"></i> Add New Marketing Project</h1>
            <p>Fill in the project details below to add it to the marketing system</p>
        </div>
      
        <!-- Success Message -->
        @if(session('success'))
        <div class="alert-success" id="successMessage" style="display: block;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

      
        <form action="{{ route('superadmin.clients.store') }}" method="POST" id="projectForm">
            @csrf

            @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

            <div class="form-container">
                <!-- Left Column -->
                <div class="form-card">
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-user-tie"></i> Client Information
                        </div>
                      
                        <div class="form-group">
                            <label for="client_name" class="required">Client Name</label>
                            <input type="text" id="client_name" name="client_name" class="form-control" required>
                        </div>
                      
                        <div class="form-group">
                            <label for="phone_number" class="required">Phone Number</label>
                            <input type="tel" id="phone_number" name="phone_number" class="form-control" placeholder="+94 XX XXX XXXX" required>
                        </div>
                      
                        <div class="form-group">
                            <label for="date" class="required">Date</label>
                            <input type="date" id="date" name="date" class="form-control" required>
                        </div>
                    </div>
                  
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-tasks"></i> Project Details
                        </div>
                      
                        <div class="form-group">
                            <label for="project_type" class="required">Type of Project</label>
                            <select id="project_type" name="project_type" class="form-control" required>
                                <option value="">Select Project Type</option>
                                <option value="web">Web Development</option>
                                <option value="mobile_app">Mobile App</option>
                                <option value="graphic_design">Graphic Design</option>
                                <option value="social_media">Social Media Management</option>
                                <option value="seo">SEO Services</option>
                                <option value="branding">Branding</option>
                                <option value="video_production">Video Production</option>
                                <option value="content_writing">Content Writing</option>
                            </select>
                        </div>
                      
                        <div class="form-group">
                            <label for="project_category" class="required">Project Category</label>
                            <select id="project_category" name="project_category" class="form-control" required disabled>
                                <option value="">First select project type</option>
                            </select>
                        </div>
                      
                        <div class="form-group">
                            <label for="project_price" class="required">Project Price (LKR)</label>
                            <input type="number" step="0.01" id="project_price" name="project_price" class="form-control" placeholder="0.00" required>
                        </div>
                    </div>
                </div>
              
                <!-- Right Column -->
                <div class="form-card">
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-comments"></i> Communication Details
                        </div>
                      
                        <div class="form-group">
                            <label for="contact_method" class="required">Contact Method</label>
                            <select id="contact_method" name="contact_method" class="form-control" required>
                                <option value="">Select Contact Method</option>
                                <option value="phone_call">Phone Call</option>
                                <option value="email">Email</option>
                                <option value="whatsapp">WhatsApp</option>
                                <option value="in_person">In-Person Meeting</option>
                                <option value="video_call">Video Call</option>
                                <option value="social_media">Social Media</option>
                                <option value="website_inquiry">Website Inquiry</option>
                            </select>
                        </div>
                      
                        <div class="form-group">
                            <label class="required">Call Sequence</label>
                            <div class="call-sequence-options">
                                <div class="call-option">
                                    <input type="radio" id="first_call" name="call_sequence" value="1st" required>
                                    <label for="first_call">1st Call</label>
                                </div>
                                <div class="call-option">
                                    <input type="radio" id="second_call" name="call_sequence" value="2nd">
                                    <label for="second_call">2nd Call</label>
                                </div>
                                <div class="call-option">
                                    <input type="radio" id="third_call" name="call_sequence" value="3rd">
                                    <label for="third_call">3rd Call</label>
                                </div>
                            </div>
                        </div>
                      
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_call_date">1st Call Date</label>
                                <input type="date" id="first_call_date" name="first_call_date" class="form-control">
                            </div>
                          
                            <div class="form-group">
                                <label for="second_call_date">2nd Call Date</label>
                                <input type="date" id="second_call_date" name="second_call_date" class="form-control">
                            </div>
                        </div>
                      
                        <div class="form-group">
                            <label for="third_call_date">3rd Call Date</label>
                            <input type="date" id="third_call_date" name="third_call_date" class="form-control">
                        </div>
                      
                        <div class="form-group">
                            <label for="comments" class="required">Comments / Notes</label>
                            <textarea id="comments" name="comments" class="form-control" placeholder="Add any relevant notes, discussion points, or follow-up requirements..." required></textarea>
                        </div>
                    </div>
                  
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-user-shield"></i> Assignment
                        </div>
                      
                        <div class="form-group">
                            <label for="marketing_manager" class="required">Marketing Manager</label>
                            <select id="marketing_manager" name="marketing_manager_id" class="form-control" required>
                                <option value="">Select Marketing Manager</option>
                                @foreach($managers as $manager)
                                    <option value="{{ $manager->employee_id }}">
                                        {{ $manager->user->name ?? $manager->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
          
            <!-- Submit Button -->
            <div class="form-card" style="flex-basis: 100%; margin-top: 0;">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-plus-circle"></i> Add Marketing Project
                </button>
            </div>
        </form>
    </div>
    <script>
        // Set today's date as default
        document.getElementById('date').valueAsDate = new Date();
        // Category options based on project type
        const categoryOptions = {
            web: [
                'Tourism',
                'Clothing & Fashion',
                'Restaurant & Food',
                'Real Estate',
                'Healthcare',
                'Education',
                'E-commerce',
                'Technology',
                'Finance & Banking',
                'Entertainment'
            ],
            mobile_app: [
                'Tourism',
                'Clothing & Fashion',
                'Food Delivery',
                'Fitness & Health',
                'Finance',
                'Education',
                'E-commerce',
                'Gaming',
                'Productivity',
                'Social Networking'
            ],
            graphic_design: [
                'Tourism',
                'Clothing & Fashion',
                'Restaurant & Food',
                'Corporate',
                'Real Estate',
                'Beauty & Cosmetics',
                'Sports & Fitness',
                'Event Planning',
                'Retail',
                'Non-Profit'
            ],
            social_media: [
                'Tourism',
                'Clothing & Fashion',
                'Restaurant & Food',
                'Beauty & Lifestyle',
                'Technology',
                'Healthcare',
                'Entertainment',
                'Education',
                'E-commerce',
                'Corporate'
            ],
            seo: [
                'Tourism',
                'Clothing & Fashion',
                'E-commerce',
                'Real Estate',
                'Healthcare',
                'Legal Services',
                'Home Services',
                'Automotive',
                'Technology',
                'Finance'
            ],
            branding: [
                'Tourism',
                'Clothing & Fashion',
                'Restaurant & Food',
                'Startup',
                'Corporate',
                'Non-Profit',
                'Healthcare',
                'Beauty & Cosmetics',
                'Technology',
                'Real Estate'
            ],
            video_production: [
                'Tourism',
                'Clothing & Fashion',
                'Restaurant & Food',
                'Real Estate',
                'Corporate',
                'Entertainment',
                'Education',
                'Product Marketing',
                'Event Coverage',
                'Documentary'
            ],
            content_writing: [
                'Tourism',
                'Clothing & Fashion',
                'Technology',
                'Healthcare',
                'Finance',
                'Education',
                'E-commerce',
                'Legal',
                'Real Estate',
                'Corporate'
            ]
        };
        // Handle project type change
        const projectTypeSelect = document.getElementById('project_type');
        const projectCategorySelect = document.getElementById('project_category');
        projectTypeSelect.addEventListener('change', function() {
            const selectedType = this.value;
          
            // Clear existing options
            projectCategorySelect.innerHTML = '<option value="">Select Category</option>';
          
            if (selectedType && categoryOptions[selectedType]) {
                // Enable the category dropdown
                projectCategorySelect.disabled = false;
              
                // Add new options based on selected type
                categoryOptions[selectedType].forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.toLowerCase().replace(/\s+/g, '_');
                    option.textContent = category;
                    projectCategorySelect.appendChild(option);
                });
            } else {
                // Disable if no type selected
                projectCategorySelect.disabled = true;
                projectCategorySelect.innerHTML = '<option value="">First select project type</option>';
            }
        });
        // Auto-hide success message after 5 seconds
        const successMessage = document.getElementById('successMessage');
        if (successMessage && successMessage.style.display === 'block') {
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 5000);
        }

        // Duplicate phone number check with different manager
        const phoneInput = document.getElementById('phone_number');
const managerSelect = document.getElementById('marketing_manager');
const form = document.getElementById('projectForm');
const duplicateAlert = document.getElementById('duplicateAlert');

function checkDuplicatePhone(phone, managerId) {
    if (!phone || !managerId) return;

    fetch(`/superadmin/marketing/projects/check-phone?phone=${encodeURIComponent(phone)}&manager_id=${encodeURIComponent(managerId)}`)
        .then(res => res.json())
        .then(data => {
            if (data.exists) {
                duplicateAlert.style.display = 'block';
            } else {
                duplicateAlert.style.display = 'none';
            }
        });
}

managerSelect.addEventListener('change', () => {
    if (phoneInput.value && managerSelect.value) {
        checkDuplicatePhone(phoneInput.value, managerSelect.value);
    }
});

phoneInput.addEventListener('blur', () => {
    if (phoneInput.value && managerSelect.value) {
        checkDuplicatePhone(phoneInput.value, managerSelect.value);
    }
});

form.addEventListener('submit', function(e) {
    if (duplicateAlert.style.display === 'block') {
        e.preventDefault();
        alert('This phone number was already added under another marketing manager.');
    }
});

    </script>
@endsection