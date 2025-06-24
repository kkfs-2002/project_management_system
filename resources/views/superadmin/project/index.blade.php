@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Project Finance</h2>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filter by Month --}}
    <form method="GET" class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <label>Select Month:</label>
            <input type="month" name="month" value="{{ $month }}" required>
            <button class="btn btn-primary">Filter</button>
        </div>
        <a href="{{ route('superadmin.project.create') }}" class="btn btn-success">➕ Add Project</a>
    </form>

    @forelse($projects as $project)
        <div class="card mb-3 shadow-sm" style="border-left: 5px solid #4e73df;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">{{ $project->name }}</h5>
                        <small class="text-muted">{{ $project->type }}</small>
                    </div>

                    @if (!$project->account)
                        <button class="btn btn-outline-info" onclick="toggleForm('{{ $project->id }}')" id="btn-{{ $project->id }}">
                            ➕ Add Financials
                        </button>
                    @else
                        <span class="badge bg-success p-2">✅ Financials Added</span>
                    @endif
                </div>

                @if ($project->account)
                    
                @else
                    {{-- Financials Form --}}
                    <form id="form-{{ $project->id }}" action="{{ route('superadmin.project.financials.store') }}" method="POST" class="mt-3" style="display:none;">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $project->id }}">

                        <div class="row mb-2">
                            <div class="col">
                                <label>Total Payment</label>
                                <input type="number" name="total_payment" class="form-control" required>
                            </div>
                            <div class="col">
                                <label>Advance</label>
                                <input type="number" name="advance" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col">
                                <label>Hosting Fee</label>
                                <input type="number" name="hosting_fee" class="form-control" required>
                            </div>
                            <div class="col">
                                <label>Developer Fee</label>
                                <input type="number" name="developer_fee" class="form-control" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-info">💾 Save Financials</button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <p>No projects found for this month.</p>
    @endforelse
</div>

{{-- Toggle Form Script --}}
<script>
    function toggleForm(projectId) {
        const form = document.getElementById(`form-${projectId}`);
        const btn = document.getElementById(`btn-${projectId}`);

        if (form && btn) {
            form.style.display = 'block';
            btn.style.display = 'none';
        }
    }
</script>
@endsection