@extends('layouts.developer')
@section('title', 'Test Layout')
@section('content')
    <div class="container">
        <div class="alert alert-success">
            <h1>✅ Layout Test Successful!</h1>
            <p>If you can see this, the layout is working correctly.</p>
        </div>
        <a href="{{ url('/developer/daily-tasks/create') }}" class="btn btn-primary">
            Go to Create Task Page
        </a>
    </div>
@endsection