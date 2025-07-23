@extends('layouts.projectmanager')

@section('content')
<div class="container">
    <h3>Available Projects</h3>

    <div class="list-group">
        @forelse($projects as $project)
            <a href="{{ route('projectmanager.projects.tasks', $project->id) }}" class="list-group-item list-group-item-action">
                {{ $project->name }}
            </a>
        @empty
            <p>No projects available.</p>
        @endforelse
    </div>
</div>
@endsection
