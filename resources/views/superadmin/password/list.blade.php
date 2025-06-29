@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="mb-3"><i class="fas fa-key me-2"></i>Reset Employee Password</h4>

    @foreach ($employees as $emp)
        <div class="d-flex justify-content-between align-items-center border p-2 rounded mb-2">
            <span>{{ $emp->full_name }}
                  <small class="text-muted">({{ $emp->role }})</small></span>

            <a href="{{ route('superadmin.password.editOther', $emp->id) }}"
               class="btn btn-sm btn-warning">
               <i class="fas fa-key"></i> Reset
            </a>
        </div>
    @endforeach
</div>
@endsection
