@extends('layouts.marketing')

@section('title', 'Edit Client')

@section('content')
<div class="container mt-4">
    <h2>Edit Client</h2>

    @include('marketing.clients.form', ['client' => $client])
</div>
@endsection
