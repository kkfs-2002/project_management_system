@extends('layouts.app')

@section('content')

<!-- HERO SECTION -->
<section class="hero-section">
    <!-- Background Image -->
    <div class="hero-bg"></div>

    <!-- Dark Gradient Overlay -->
    <div class="hero-overlay"></div>

    <!-- Content -->
    <div class="container position-relative text-white hero-content">
        <!-- Large Outline Text -->
        <div class="outline-text">NETIT TECHNOLOGY</div>

        <!-- Tagline -->
        <p class="small-text">Welcome to NetIT Technology</p>

        <!-- Main Heading -->
        <h1 class="hero-title">
            We Specialize in<br>
            Cutting-Edge Software<br>
            Solutions.
        </h1>

        <!-- Sub Text -->
        <p class="hero-subtext">
            We specialize in delivering cutting-edge software and digital solutions that
            drive results. From enterprise web apps to mobile platforms, we empower
            businesses to scale and succeed.
        </p>
        
       
    </div>

    <!-- Round Image on Right -->
    <div class="circle-image">
        <img src="{{ asset('images/company2.jpg') }}" alt="Circle Image">
    </div>


</section>
<section class="stats-section py-5 light-blue-section">
    <div class="container">
        <div class="row align-items-center">

            <!-- RIGHT SIDE — IMAGE -->
            <div class="col-lg-5 text-center">
                <img src="/images/line.png" alt="stats image" class="stats-side-img">
            </div>

            <!-- LEFT SIDE — TEXT + STATS -->
            <div class="col-lg-7 text-center text-lg-start mb-4 mb-lg-0">

                <h2 class="fw-bold mb-3">Empowering Businesses With Smart Digital Solutions</h2>

                <p class="text-muted mb-4">
                    We build scalable, secure, and innovative technology solutions that help brands grow and transform.
                </p>

                <div class="row justify-content-center justify-content-lg-start g-4">

                    <!-- Round Stat 1 -->
                    <div class="col-6 col-md-4">
                        <div class="circle-card">

                            <!-- Hidden background image -->
                            <div class="circle-bg-image" style="background-image: url('/images/projects.jpg');"></div>

                            <!-- Blue overlay -->
                            <div class="circle-overlay"></div>

                            <!-- Content -->
                            <div class="circle-content">
                                <i class="fas fa-users fa-2x"></i>
                                <h2 id="employeeCount">0</h2>
                                <p>Our Team Members</p>
                            </div>

                        </div>
                    </div>

                    <!-- Round Stat 2 -->
                    <div class="col-6 col-md-4">
                        <div class="circle-card">

                            <!-- Hidden background image -->
                            <div class="circle-bg-image" style="background-image: url('/images/team.jpg');"></div>

                            <!-- Blue overlay -->
                            <div class="circle-overlay"></div>

                            <!-- Content -->
                            <div class="circle-content">
                                <i class="fas fa-project-diagram fa-2x"></i>
                                <h2 id="projectCount">0</h2>
                                <p>Completed Projects</p>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- Project Timeline Section -->
<section id="projects" class="projects-section py-5">
    <div class="container">
        <!-- Header with Icons -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-dark">
                <i class="fas fa-stream me-2 text-primary"></i> Project Timeline Overview
            </h4>

            <div class="d-flex align-items-center">
                <!-- View toggle buttons -->
                <button class="btn btn-outline-primary me-2" id="timelineViewBtn"><i class="fas fa-stream"></i></button>
                <button class="btn btn-outline-primary me-2" id="gridViewBtn"><i class="fas fa-th"></i></button>
                
                <!-- Sort Dropdown -->
                <div class="dropdown me-2">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-sort me-1"></i> Sort
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('superadmin.dashboard', array_merge(request()->query(), ['sort' => 'asc'])) }}">Deadline: Soonest</a></li>
                        <li><a class="dropdown-item" href="{{ route('superadmin.dashboard', array_merge(request()->query(), ['sort' => 'desc'])) }}">Deadline: Latest</a></li>
                    </ul>
                </div>

                <!-- Filter by type -->
                <div class="dropdown me-2">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                        <li><a class="dropdown-item" href="{{ route('superadmin.dashboard') }}">All</a></li>
                        @foreach($projectTypes as $type)
                            <li><a class="dropdown-item" href="{{ route('superadmin.dashboard', ['type' => $type]) }}">{{ $type }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Timeline View -->
        <div id="timelineView">
            @if($timelineProjects->isEmpty())
                <div class="alert alert-warning">No projects found.</div>
            @else
                <div class="timeline-wrapper">
                    @foreach($timelineProjects as $index => $project)
                        <div class="timeline-item mb-5 d-flex">
                            <div class="timeline-line"></div>
                            <div class="timeline-dot {{ $project['color'] }}">{{ $index + 1 }}</div>

                            <div class="timeline-content card shadow-sm p-3" style="width:70%; max-width:800px;">
                                <h6 class="fw-bold">{{ $project['name'] }}</h6>
                                <div class="text-muted small mb-2">
                                    <i class="fas fa-calendar-alt me-1"></i> {{ $project['start_date'] }}
                                    &nbsp; → &nbsp;
                                    <i class="fas fa-flag-checkered me-1"></i> {{ $project['deadline'] }}
                                </div>

                                <div class="text-left py-1 mt-1 rounded alert-success" style="background-color: {{$project['color'] === 'success' ? 'rgba(25,135,84,0.15)' : ($project['color'] === 'warning' ? 'rgba(255,193,7,0.15)' : 'rgba(220,53,69,0.15)')}};box-shadow: 0 0 6px rgba(0, 0, 0, 0.05); font-size:14px;">
                                    <strong>{{ 100 - $project['completion'] }}%</strong> Work Remaining
                                </div>

                                <div class="progress mb-2 mt-2" style="height: 8px;">
                                    <div class="progress-bar bg-{{ $project['color'] }}" style="width: {{ $project['completion'] }}%;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Grid View -->
        <div id="gridView" class="row" style="display: none;">
            @foreach($timelineProjects as $project)
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $project['name'] }}</h5>
                            <p class="text-muted small mb-1">
                                <i class="fas fa-calendar-alt me-1"></i> {{ $project['start_date'] }} → {{ $project['deadline'] }}
                            </p>

                            <div class="progress mb-2" style="height: 6px;">
                                <div class="progress-bar bg-{{ $project['color'] }}" style="width: {{ $project['completion'] }}%;"></div>
                            </div>

                            <div class="text-left py-1 mt-1 rounded alert-success" style="background-color: {{$project['color'] === 'success' ? 'rgba(25,135,84,0.15)' : ($project['color'] === 'warning' ? 'rgba(255,193,7,0.15)' : 'rgba(220,53,69,0.15)')}};box-shadow: 0 0 6px rgba(0, 0, 0, 0.05); font-size:14px;">
                                <strong>{{ 100 - $project['completion'] }}%</strong> Work Remaining
                            </div>
                            
                            <div class="mt-auto pt-3">
                                <button class="btn btn-sm btn-outline-primary">View Details</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    /* Enhanced Hero Section Styles */
    .hero-section {
        height: 620px;
        width: 100%;
        position: relative;
        overflow: hidden;
        margin: 0;
        padding: 0;
        left: 0;
    }

    /* Background Image */
    .hero-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('{{ asset("images/company.jpg") }}') center/cover no-repeat;
        z-index: 2;
        animation: zoomEffect 20s infinite alternate;
    }

    @keyframes zoomEffect {
        0% {
            transform: scale(1);
        }
        100% {
            transform: scale(1.05);
        }
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, rgba(5, 15, 40, 0.9), rgba(5, 15, 40, 0.4));
        z-index: 2;
    }

    .hero-content {
        position: relative;
        z-index: 4;
        padding-top: 120px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* Hero Content Animations */
    .small-text {
        font-size: 13px;
        letter-spacing: 3px;
        margin-bottom: 20px;
        color: rgba(255, 255, 255, 0.8);
        text-transform: uppercase;
        opacity: 0;
        animation: fadeInUp 0.8s ease 0.2s forwards;
    }

    .hero-title {
        font-size: 60px;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.8s ease 0.4s forwards;
    }

    .hero-subtext {
        font-size: 18px;
        opacity: 0;
        max-width: 600px;
        line-height: 1.6;
        transform: translateY(30px);
        animation: fadeInUp 0.8s ease 0.6s forwards;
    }

    .hero-buttons {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.8s ease 0.8s forwards;
    }

    /* Large Outline Text */
    .outline-text {
        position: absolute;
        top: 50px;
        left: 0;
        font-size: 180px;
        color: transparent;
        -webkit-text-stroke: 1px rgba(255, 255, 255, 0.1);
        font-weight: 800;
        z-index: 3;
        user-select: none;
        pointer-events: none;
        line-height: 150px;
        width: 100%;
        overflow: hidden;
        opacity: 0;
        animation: fadeIn 1s ease 0.5s forwards;
    }

    /* Circle Image */
    .circle-image {
        position: absolute;
        right: 80px;
        top: 70%;
        transform: translateY(-50%) scale(0);
        width: 220px;
        height: 220px;
        border-radius: 50%;
        overflow: hidden;
        z-index: 5;
        border: 4px solid rgba(255, 255, 255, 0.9);
        box-shadow: 0 0 30px rgba(0,0,0,0.5);
        transition: all 0.3s ease;
        animation: scaleIn 0.8s ease 1s forwards;
    }

    .circle-image:hover {
        transform: translateY(-50%) scale(1.05);
        box-shadow: 0 0 40px rgba(0,0,0,0.7);
    }

    .circle-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Hero Buttons */
    .hero-buttons .btn {
        padding: 12px 30px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .hero-buttons .btn-primary {
        background: linear-gradient(45deg, #0d6efd, #0a58ca);
        border: none;
    }

    .hero-buttons .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    /* Scroll Indicator */
    .scroll-indicator {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 5;
        color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: 14px;
        opacity: 0;
        animation: fadeIn 1s ease 1.5s forwards;
    }

    .scroll-line {
        width: 1px;
        height: 40px;
        background: rgba(255,255,255,0.5);
        margin-bottom: 10px;
        animation: scrollLine 2s infinite;
    }

    @keyframes scrollLine {
        0% {
            height: 0;
            opacity: 1;
        }
        100% {
            height: 40px;
            opacity: 0;
        }
    }

    /* Animation Keyframes */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes scaleIn {
        from {
            transform: translateY(-50%) scale(0);
            opacity: 0;
        }
        to {
            transform: translateY(-50%) scale(1);
            opacity: 1;
        }
    }

.stats-section {
    margin-top: 0;
}

.light-blue-section {
    background: #e9f3ff;
    border-radius: 15px;
    padding: 60px 20px;
}

.stats-side-img {
    max-width: 350px;
    width: 100%;
    border-radius: 20px;
}

/* CIRCLE CARD */
.circle-card {
    width: 230px;
    height: 230px;
    border-radius: 50%;
    background: #ffffff;       /* Default white */
    position: relative;
    overflow: hidden;
    margin: 0 auto;
    transition: 0.4s ease;
}

/* Hidden image */
.circle-bg-image {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    opacity: 0;                /* Hidden by default */
    transition: 0.4s ease;
}

/* Blue overlay */
.circle-overlay {
    position: absolute;
    inset: 0;
    background: rgba(30, 60, 190, 0); /* Invisible default */
    transition: 0.4s ease;
}

/* Content */
.circle-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    z-index: 3;
}

.circle-content i {
    color: #1E3CBE;   /* Blue icon */
}

.circle-content h2 {
    font-size: 30px;
    font-weight: 700;
    margin-top: 10px;
    color: #000;      /* Black text */
}

.circle-content p {
    margin-top: 5px;
    font-size: 13px;
    color: #000;      /* Black text */
}

/* HOVER EFFECT → show image + overlay */
.circle-card:hover .circle-bg-image {
    opacity: 1;
}

.circle-card:hover .circle-overlay {
    background: rgba(30, 60, 190, 0.55);
}

.circle-card:hover {
    transform: scale(1.05);
}/* Background Image + Dark Overlay */
/* Background Image + Dark Overlay */
#projects {
    /* Slightly darker overlay */
    background: 
        linear-gradient(rgba(15,18,59,0.7), rgba(15,18,59,0.7)),
        url("/images/company1.jpg") center/cover no-repeat fixed;
    color: #fff;
    padding: 60px 0;
}


/* Hover + Click effect for cards */
.timeline-content {
    background: rgba(27,31,74,0.85);
    border-radius: 22px;
    padding: 24px;
    margin-left: 40px;
    width: 70%;
    max-width: 800px;
    color: #ffffff;
    border: 1px solid #7c7c7cff;
    box-shadow: 0 10px 28px rgba(0,0,0,0.35);
    transition: transform 0.3s ease, background 0.3s ease, color 0.3s ease;
    cursor: pointer;
}

.timeline-content:hover,
.timeline-content.active {
    background: #fff !important;
    color: #171b4bff !important;
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 18px 45px rgba(0,0,0,0.50);
}

/* Number UI - Modern like properties section */
.timeline-dot {
    background: rgba(255,255,255,0.12);
    color: #fff;
    border: 2px solid rgba(255,255,255,0.4);
    width: 70px;
    height: 70px;
    font-size: 22px;
    border-radius: 14px;
    font-weight: 700;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: transform 0.3s ease, background 0.3s ease, color 0.3s ease;
}

.timeline-content:hover .timeline-dot,
.timeline-content.active .timeline-dot {
    background: #fff !important;
    color: #6c3be8 !important;
    border-color: #6c3be8 !important;
    transform: scale(1.2);
}
.progress-bar {
    transition: width 1.2s ease-in-out;
}

.timeline-item {
    opacity: 0;
    transform: translateX(-50px);
    transition: all 0.7s ease-out;
}

.timeline-item.slide-in {
    opacity: 1;
    transform: translateX(0);
}

#timelineViewBtn.active, #gridViewBtn.active {
    background: #6c3be8;
    color: #fff;
    border-color: #6c3be8;
}
/* Grid View Card Styling */
#gridView .card {
    background: rgba(27,31,74,0.85); /* Dark card background */
    color: #fff; /* Default text color white */
    border-radius: 20px;
    border: none;
    transition: transform 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}

#gridView .card:hover {
    background: #fff !important; /* White on hover */
    color: #171b4b !important;   /* Dark text on hover */
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 18px 45px rgba(0,0,0,0.5);
}

/* Small text inside card */
#gridView .card .text-muted {
    color: rgba(255, 255, 255, 0.7);
    transition: color 0.3s ease;
}

#gridView .card:hover .text-muted {
    color: rgba(23,27,75,0.8); /* Slightly darker on hover */
}

/* Progress bar smooth animation */
#gridView .progress-bar {
    transition: width 1.2s ease-in-out;
}

/* Work Remaining box styling */
#gridView .card .alert-success {
    font-size: 14px;
    transition: all 0.3s ease;
}

/* Button styling */
#gridView .card button.btn {
    transition: all 0.3s ease;
}

#gridView .card:hover button.btn {
    background: #6c3be8;
    color: #fff;
    border-color: #6c3be8;
}

/* Header Title Animation */
#projects h4 {
    font-size: 48px;
    font-weight: 800;
 
    color: #ffffff !important; /* Makes the header white */

}

@keyframes slideUpFade {
    0% {opacity: 0; transform: translateY(25px);}
    100% {opacity: 1; transform: translateY(0);}
}

    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .outline-text {
            font-size: 150px;
        }
        
        .hero-title {
            font-size: 50px;
        }
    }

    @media (max-width: 992px) {
        .outline-text {
            font-size: 120px;
            top: 80px;
        }
        
        .hero-title {
            font-size: 42px;
        }
        
        .circle-image {
            right: 40px;
            width: 180px;
            height: 180px;
        }
    }

    @media (max-width: 768px) {
        .hero-section {
            height: 600px;
        }
        
        .outline-text {
            font-size: 80px;
            top: 100px;
        }
        
        .hero-title {
            font-size: 36px;
        }
        
        .circle-image {
            display: none;
        }
        
        .hero-content {
            padding-top: 100px;
        }
        
        .hero-buttons {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .hero-buttons .btn {
            width: 100%;
            margin-bottom: 10px;
        }
    }
</style>

<script>
    // View Switcher
    document.getElementById('timelineViewBtn').addEventListener('click', () => {
        document.getElementById('timelineView').style.display = 'block';
        document.getElementById('gridView').style.display = 'none';
        document.getElementById('timelineViewBtn').classList.add('active');
        document.getElementById('gridViewBtn').classList.remove('active');
    });

    document.getElementById('gridViewBtn').addEventListener('click', () => {
        document.getElementById('timelineView').style.display = 'none';
        document.getElementById('gridView').style.display = 'flex';
        document.getElementById('gridViewBtn').classList.add('active');
        document.getElementById('timelineViewBtn').classList.remove('active');
    });

    // Initialize with timeline view active
    document.getElementById('timelineViewBtn').classList.add('active');

    // Counter Animation
    function animateCounter(id, endValue, duration = 1200) {
        const element = document.getElementById(id);
        const startTime = performance.now();

        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const value = Math.floor(progress * endValue);
            element.innerText = value.toLocaleString();

            if (progress < 1) {
                requestAnimationFrame(update);
            }
        }

        requestAnimationFrame(update);
    }

    // Initialize counters when page loads
    document.addEventListener('DOMContentLoaded', () => {
        animateCounter("employeeCount", {{ $employeeCount }});
        animateCounter("projectCount", {{ $projectCount }});
        animateCounter("clientCount", 150); // Example value for clients
    });

    // Additional animation for hero section elements on scroll
    document.addEventListener('DOMContentLoaded', function() {
        // Add intersection observer for hero section
        const heroSection = document.querySelector('.hero-section');
        
        if (heroSection) {
            // Trigger animations immediately since hero section is in viewport
            setTimeout(() => {
                const animatedElements = document.querySelectorAll('.small-text, .hero-title, .hero-subtext, .hero-buttons, .outline-text, .circle-image, .scroll-indicator');
                animatedElements.forEach(element => {
                    element.style.animationPlayState = 'running';
                });
            }, 100);
        }
    });
    document.querySelectorAll('.timeline-content').forEach(card => {
    card.addEventListener('click', () => {
        document.querySelectorAll('.timeline-content').forEach(c => c.classList.remove('active'));
        card.classList.add('active');
    });
});

// Animate progress bars dynamically
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.progress-bar').forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.width = width;
        }, 100);
    });
});

// Intersection Observer for timeline items
const timelineItems = document.querySelectorAll('.timeline-item');
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if(entry.isIntersecting) entry.target.classList.add('slide-in');
    });
}, { threshold: 0.1 });
timelineItems.forEach(item => observer.observe(item));

// Animate grid view progress bars on page load
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('#gridView .progress-bar').forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.width = width;
        }, 100);
    });
});

</script>

@endsection