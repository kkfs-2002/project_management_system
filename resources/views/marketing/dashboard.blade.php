@extends('layouts.marketing')

@section('title', 'Marketing Dashboard')

@section('content')
<style>
/* ================= GENERAL ================= */
.stats-section {
    width: 100%;
    min-height: 350px;
    margin-top: 20px;
}

/* ================= LEFT PANEL ================= */
.left-panel {
    background: linear-gradient(135deg, #1d2671, #c33764);
    min-height: 350px;
    display: flex;
    align-items: center;
}

.left-panel h1 {
    font-size: 2.5rem;
}

/* ================= DASHBOARD CARDS ================= */
.stat-img-card {
    position: relative;
    min-height: 175px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    overflow: hidden;
    transition: transform 0.35s ease;
}

.stat-img-card:hover {
    transform: scale(1.04);
}

/* Background images */
.bg-clients {
    background: url('/images/clients.jpg') center/cover no-repeat;
}

.bg-reminders {
    background: url('/images/reminders.jpg') center/cover no-repeat;
}

/* Overlay */
.stat-img-card .overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
}

/* Text */
.stat-img-card .text-block {
    position: relative;
    z-index: 2;
    text-align: center;
    padding: 25px;
}

.stat-img-card h2 {
    font-size: 2.3rem;
    font-weight: bold;
}

.stat-img-card p {
    font-size: 1.1rem;
    opacity: 0.9;
}
/* Welcome Section Background */
.welcome-section {
    min-height: 650px;
    background: linear-gradient(135deg, #000000 0%, #888888 100%); /* black → gray gradient */
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
}

/* Glass Card Overlay */
.welcome-card {
    background: rgba(255, 255, 255, 0.05); /* subtle glass effect */
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-radius: 20px;
    padding: 40px 50px;
    max-width: 700px;
    color: #ffffff;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
    animation: fadeUp 0.8s ease-in-out;
}

/* Title */
.welcome-card h2 {
    font-size: 2.5rem;
    letter-spacing: 0.5px;
}

/* Description */
.welcome-text {
    font-size: 1.05rem;
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.6;
}

/* Animation */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Responsive */
@media (max-width: 768px) {
    .welcome-card { padding: 30px 25px; }
    .welcome-card h2 { font-size: 2rem; }
    .welcome-text { font-size: 0.95rem; }
}

@media (max-width: 576px) {
    .welcome-card { padding: 20px 15px; }
    .welcome-card h2 { font-size: 1.5rem; }
    .welcome-text { font-size: 0.9rem; }
}


</style>



<!-- ===================== BANNER ===================== -->
<!-- Banner Section -->
<div class="welcome-section d-flex align-items-center justify-content-center mb-5">
    <div class="welcome-card text-center">

        <!-- MAIN TITLE -->
        <h2 id="typingText" class="fw-bold mb-3">
            Marketing Manager Dashboard
        </h2>

        <!-- DESCRIPTION TEXT -->
        <p class="welcome-text mb-0">
            Manage campaigns, track performance, and discover actionable insights.
        </p>

    </div>
</div>


<!-- ===================== MAIN DASHBOARD SECTION ===================== -->
     <form action="{{ route('marketing.clients.store') }}" method="POST" 
      class="p-4 mt-0" style="background-color: #e2e1e1ff;">
    @csrf


                    
<section class="stats-section">
    <div class="container-fluid">
        <div class="row g-0">

            <!-- LEFT SIDE -->
            <div class="col-md-4 left-panel d-flex align-items-center">
                <div class="left-content text-white p-5">
                    <h1 class="fw-bold">Dashboard Overview</h1>
                    <p class="mt-3 opacity-75">
                        Quick summary of your marketing performance
                    </p>
                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="col-md-8">
                <div class="row g-0 h-100">

                    <!-- Clients -->
                    <div class="col-md-6 stat-img-card bg-clients">
                        <div class="overlay"></div>
                        <div class="text-block">
                            <i class="fas fa-users fa-3x mb-3"></i>
                            <h2>{{ $totalClients ?? 0 }}</h2>
                            <p>Total Clients</p>
                            <a href="{{ route('marketing.clients.index') }}"
                               class="btn btn-outline-light mt-3 w-100">
                                View Clients
                            </a>
                        </div>
                    </div>

                    <!-- Reminders -->
                    <div class="col-md-6 stat-img-card bg-reminders">
                        <div class="overlay"></div>
                        <div class="text-block">
                            <i class="fas fa-bell fa-3x mb-3"></i>
                            <h2>{{ $totalReminders ?? 0 }}</h2>
                            <p>Total Reminders</p>
                            <a href="{{ route('marketing.clients.reminders') }}"
                               class="btn btn-outline-light mt-3 w-100">
                                View Reminders
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

</form>
@endsection
