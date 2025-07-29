@extends('layouts.projectmanager')

@section('content')
<style>
    .projects-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 16px;
    }

    .project-card {
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 12px;
        background-color: #fff;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
        transition: box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 200px;
    }

    .project-card:hover {
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
    }

    .project-title {
        font-size: 1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }

    .project-description {
        flex-grow: 1;
        color: #555;
        font-size: 0.85rem;
        margin-bottom: 12px;
        line-height: 1.4;
    }

    .btn-view-tasks {
        background-color: #17a2b8;
        border: none;
        border-radius: 4px;
        padding: 6px 12px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #fff;
        text-align: center;
        transition: background-color 0.3s ease;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-view-tasks:hover {
        background-color: #138496;
    }

    @media (max-width: 768px) {
        .projects-grid {
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        }
    }
</style>

<div class="container">
    <h5 class="mb-3">Available Projects</h5>

    <div class="projects-grid">
        @forelse($projects as $project)
            <div class="project-card">
                <h6 class="project-title">{{ $project->name }}</h6>

                <p class="project-description">
                    <strong>Start:</strong>
                    {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('Y-m-d') : 'N/A' }}<br>
                    <strong>Deadline:</strong>
                    {{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('Y-m-d') : 'N/A' }}
                </p>

                <a href="{{ route('projectmanager.projects.tasks', $project->id) }}" class="btn-view-tasks mt-auto">View Tasks</a>
            </div>
        @empty
            <p>No projects available.</p>
        @endforelse
    </div>
</div>
@endsection
