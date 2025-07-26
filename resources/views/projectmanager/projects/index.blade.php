@extends('layouts.projectmanager')

@section('content')
<style>
    .project-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 16px;
        background-color: #fff;
        box-shadow: 0 1px 3px rgb(0 0 0 / 0.1);
        transition: box-shadow 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .project-card:hover {
        box-shadow: 0 4px 12px rgb(0 0 0 / 0.15);
    }
    .project-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: rgba(0, 0, 0, 0.85);
        margin-bottom: 12px;
    }
    .project-description {
        flex-grow: 1;
        color: rgba(0, 0, 0, 0.65);
        font-size: 0.95rem;
        margin-bottom: 16px;
    }
    .btn-view-tasks {
        background-color: #17a2b8; /* info teal */
        border: none;
        border-radius: 4px;
        padding: 10px 16px;
        font-weight: 600;
        color: #fff;
        text-align: center;
        transition: background-color 0.3s ease;
        text-decoration: none;
        display: inline-block;
        cursor: pointer;
    }
    .btn-view-tasks:hover {
        background-color: #138496; /* darker teal */
        color: #fff;
    }
</style>

<div class="container">
    <h3>Available Projects</h3>

    <div class="row">
        @forelse($projects as $project)
            <div class="col-md-4 mb-4 d-flex">
                <div class="project-card">
                    <h5 class="project-title">{{ $project->name }}</h5>

                    @if(!empty($project->description))
                        <p class="project-description">{{ Str::limit($project->description, 100) }}</p>
                    @else
                        <p class="project-description text-muted">No description available.</p>
                    @endif

                    <a href="{{ route('projectmanager.projects.tasks', $project->id) }}" class="btn-view-tasks mt-auto">View Tasks</a>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p>No projects available.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
