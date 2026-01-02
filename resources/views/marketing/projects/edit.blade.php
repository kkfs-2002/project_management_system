@extends('layouts.marketing')

@section('title', 'Edit Project')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header" style="background-color: #001f3f; color: white; margin-top: 10px;">
                    <br>
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white">
                            <i class="fas fa-edit me-2"></i>Edit Marketing Project
                        </h5>
                        <a href="{{ route('marketing.dashboard') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('marketing.projects.update', $project->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Client Info --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Client Name <span class="text-danger">*</span></label>
                                <input type="text" name="client_name"
                                    class="form-control @error('client_name') is-invalid @enderror"
                                    value="{{ old('client_name', $project->client_name) }}" required>
                                @error('client_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" name="phone_number"
                                    class="form-control @error('phone_number') is-invalid @enderror"
                                    value="{{ old('phone_number', $project->phone_number) }}" required>
                                @error('phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Date & Contact --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Project Date <span class="text-danger">*</span></label>
                                <input type="date" name="date"
                                    class="form-control @error('date') is-invalid @enderror"
                                    value="{{ old('date', $project->date) }}" required>
                                @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
<div class="col-md-6 mb-3">
    <label for="contact_method" class="form-label">
        Contact Method <span class="text-danger">*</span>
    </label>
    <select id="contact_method" name="contact_method"
        class="form-select @error('contact_method') is-invalid @enderror" required>
        <option value="">Select Contact Method</option>
        @php
            $selectedMethod = old('contact_method', $project->contact_method);
        @endphp
        <option value="phone_call" {{ $selectedMethod == 'phone_call' ? 'selected' : '' }}>Phone Call</option>
        <option value="email" {{ $selectedMethod == 'email' ? 'selected' : '' }}>Email</option>
        <option value="whatsapp" {{ $selectedMethod == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
        <option value="in_person" {{ $selectedMethod == 'in_person' ? 'selected' : '' }}>In-Person Meeting</option>
        <option value="video_call" {{ $selectedMethod == 'video_call' ? 'selected' : '' }}>Video Call</option>
        <option value="social_media" {{ $selectedMethod == 'social_media' ? 'selected' : '' }}>Social Media</option>
        <option value="website_inquiry" {{ $selectedMethod == 'website_inquiry' ? 'selected' : '' }}>Website Inquiry</option>
    </select>
    @error('contact_method')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

                        </div>

                        {{-- Project Type & Category --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Project Type <span class="text-danger">*</span></label>
                                <select id="project_type" name="project_type"
                                    class="form-select @error('project_type') is-invalid @enderror" required>
                                    <option value="">Select Project Type</option>
                                    @php
                                        $types = [
                                            'web' => 'Web Development',
                                            'mobile_app' => 'Mobile App',
                                            'graphic_design' => 'Graphic Design',
                                            'social_media' => 'Social Media Management',
                                            'seo' => 'SEO Services',
                                            'branding' => 'Branding',
                                            'video_production' => 'Video Production',
                                            'content_writing' => 'Content Writing'
                                        ];
                                        $selectedType = old('project_type', $project->project_type);
                                    @endphp
                                    @foreach ($types as $key => $label)
                                        <option value="{{ $key }}" {{ $selectedType == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('project_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Project Category <span class="text-danger">*</span></label>
                                <select id="project_category" name="project_category"
                                    class="form-select @error('project_category') is-invalid @enderror" required>
                                    <option value="">First select project type</option>
                                </select>
                                @error('project_category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Price & Call Sequence --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Project Price (Rs.) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="project_price"
                                    class="form-control @error('project_price') is-invalid @enderror"
                                    value="{{ old('project_price', $project->project_price) }}" required>
                                @error('project_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Call Sequence</label>
                                <input type="text" name="call_sequence"
                                    class="form-control @error('call_sequence') is-invalid @enderror"
                                    value="{{ old('call_sequence', $project->call_sequence) }}">
                                @error('call_sequence') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Call Dates --}}
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">1st Call Date</label>
                                <input type="date" name="first_call_date"
                                    class="form-control"
                                    value="{{ old('first_call_date', $project->first_call_date) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">2nd Call Date</label>
                                <input type="date" name="second_call_date"
                                    class="form-control"
                                    value="{{ old('second_call_date', $project->second_call_date) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">3rd Call Date</label>
                                <input type="date" name="third_call_date"
                                    class="form-control"
                                    value="{{ old('third_call_date', $project->third_call_date) }}">
                            </div>
                        </div>

                        {{-- Status & Comments --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="pending" {{ old('status', $project->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="active" {{ old('status', $project->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="hold" {{ old('status', $project->status) == 'hold' ? 'selected' : '' }}>On Hold</option>
                                    <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Comments</label>
                                <textarea name="comments" rows="3" class="form-control">{{ old('comments', $project->comments) }}</textarea>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('marketing.dashboard') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Update Project
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- JS for Dependent Dropdown --}}
<script>
    const categories = {
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
    const projectType = document.getElementById('project_type');
    const projectCategory = document.getElementById('project_category');

    function loadCategories(type, selected = null) {
        projectCategory.innerHTML = '<option value="">Select Project Category</option>';
        if (!categories[type]) return;

        categories[type].forEach(cat => {
            const option = document.createElement('option');
            option.value = cat;
            option.textContent = cat;
            if (cat === selected) option.selected = true;
            projectCategory.appendChild(option);
        });
    }

    projectType.addEventListener('change', function () {
        loadCategories(this.value);
    });

    document.addEventListener('DOMContentLoaded', function () {
        loadCategories(
            "{{ old('project_type', $project->project_type) }}",
            "{{ old('project_category', $project->project_category) }}"
        );
    });
</script>
@endsection
