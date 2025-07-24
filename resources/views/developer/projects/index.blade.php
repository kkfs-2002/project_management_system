@extends('layouts.developer')

@section('content')
<div class="container">
    <h3> Projects</h3>

    <div class="list-group">
        @forelse($projects as $project)
            <a href="{{ route('developer.projects.tasks', $project->id) }}" class="list-group-item list-group-item-action">
                {{ $project->name }}
            </a>
        @empty
            <p>No projects assigned.</p>
        @endforelse
    </div>
</div>
@endsection
