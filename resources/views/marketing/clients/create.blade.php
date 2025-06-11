@extends('layouts.marketing')

@section('title', 'Create Client')

@section('content')
<div class="container mt-4">
    <h2>Create New Client</h2>

    @include('marketing.clients.form')
</div>
@endsection
