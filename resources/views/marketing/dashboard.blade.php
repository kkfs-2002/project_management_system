@extends('layouts.marketing')

@section('title', 'Marketing Dashboard')

@section('content')

<style>
    
/* ========= Overall Section Styling ========= */

.stats-section {
    width: 100%;
    margin-top: 20px;
    
}

/* Left Panel */
.left-panel {
    background-color: #000015ff;
    min-height: 250px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
}

/* Right Grid Cards */
.stat-img-card {
    height: 280px;
    position: relative;
    background-size: cover;
    background-position: center;
    overflow: hidden;
    transition: transform 0.35s ease;
}

.stat-img-card:hover {
    transform: scale(1.03);
}

/* Overlay */
.stat-img-card .overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(rgba(0,0,0,0.35), rgba(0,0,0,0.7));
}

/* Text inside cards */
.stat-img-card .text-block {
    position: absolute;
    bottom: 30px;
    left: 30px;
    color: #fff;
    z-index: 5;
}

.stat-img-card h2 {
    font-size: 2.4rem;
    font-weight: bold;
    margin: 0;
}

.stat-img-card p {
    font-size: 1.1rem;
    opacity: 0.9;
}

/* Banner */
.banner-wrapper {
    height: 450px;
    overflow: hidden;
}

.banner-text {
    max-width: 700px;
    width: 90%;
}

/* H3 animation */
.banner-title {
    opacity: 0;
    animation: fadeDown 1.2s ease-out forwards;
}

/* P animation (delay) */
.banner-desc {
    opacity: 0;
    animation: fadeUp 1.2s ease-out forwards;
    animation-delay: 0.4s;
}
.banner-wrapper {
    width: 100%;
    height: 300px; /* adjust as needed */
}

.bg-banner {
    background-color: #0f172a; /* dark professional */
}
.stat-img-card {
    position: relative;
    min-height: 220px;
    border-radius: 16px;
    padding: 25px;
    color: #fff;
    overflow: hidden;
}

/* Clients card */
.bg-clients {
    background: linear-gradient(#0f172a);
}

/* Reminders card */
.bg-reminders {
    background: linear-gradient( #0f172a);
}

/* Soft overlay for depth */
.stat-img-card .overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.25);
}

/* Content on top */
.stat-img-card .text-block {
    position: relative;
    z-index: 2;
    text-align: center;
}


/* Keyframes */
@keyframes zoomIn {
    from { transform: scale(1); }
    to   { transform: scale(1.1); }
}

@keyframes fadeDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

</style>


<!-- ===================== BANNER ===================== -->

<div class="position-relative banner-wrapper overflow-hidden bg-banner">

    <div class="position-absolute top-50 start-50 translate-middle bg-opacity-75 p-4 rounded text-center">
        <h3 class="fw-bold text-white banner-title">
            Marketing Manager Dashboard
        </h3>
        <p class="text-white mb-0 banner-desc">
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
      <div class="row" style="margin-top: 0px;">


            <!-- LEFT SIDE -->
            <div class="col-md-4 left-panel text-white p-5">
                <h1 class="fw-bold mb-4">Dashboard Overview</h1>
             
            </div>

            <!-- RIGHT SIDE (ONLY 2 CARDS) -->
            <div class="col-md-8 p-0">
                <div class="row g-0">

                   <!-- Clients -->
<div class="col-md-6 stat-img-card bg-clients">
    <div class="overlay"></div>
    <div class="text-block">
        <i class="fas fa-users fa-3x mb-3"></i>
        <h2>{{ $totalClients ?? 0 }}</h2>
        <p>Total Clients</p>
        <a href="{{ route('marketing.clients.index') }}"
           class="btn btn-light mt-3 w-100">
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
           class="btn btn-light mt-3 w-100">
            View Reminders
        </a>
    </div>
</div>


                </div>
            </div>

        </div>
    
</section>
</form>
@endsection
