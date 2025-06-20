<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Developer Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <style>
        body {background-color:#f8f9fa;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;}
        .navbar-custom {background-color:rgba(13,110,253,.85);backdrop-filter:blur(8px);box-shadow:0 4px 6px rgba(0,0,0,.2);z-index:1050;}
        .navbar-custom .navbar-brand,.navbar-custom .nav-link,.navbar-custom .dropdown-toggle{color:#fff;font-weight:500;}
        .navbar-custom .nav-link:hover,.navbar-custom .dropdown-toggle:hover{color:#FFD700!important;}
        .dropdown-menu{background-color:#111;border:none;}
        .dropdown-item{color:#f1f1f1;padding:10px 20px;font-size:.95rem;}
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
  <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="{{ route('layouts.developer', $dev->id??1) }}">
          <img src="{{ asset('NetIT logo.png') }}" alt="Dev" style="width:40px;height:40px;border-radius:50%;object-fit:cover;margin-right:10px;">
          <span>Welcome, Developer<!--{{ $dev->full_name??'Developer' }}--></span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#devNavbar">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-center" id="devNavbar">
          <ul class="navbar-nav">

              <li class="nav-item">
                  <a class="nav-link" href="{{ route('developer.tasks.index', $dev->id??1) }}"><i class="fa fa-tasks me-1"></i> My Tasks</a>
              </li>
          </ul>
      </div>
  </div>
</nav>
<div class="container mt-4" style="padding-top:100px;">
    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>