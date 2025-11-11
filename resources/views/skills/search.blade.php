@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="display-5 fw-bold text-dark mb-2">Search Results</h1>
        <p class="lead text-muted">Searching for: "<strong>{{ $query }}</strong>"</p>
        
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="badge bg-primary me-2">{{ $skills->count() }} Skills</span>
                <span class="badge bg-secondary">{{ $practiceSessions->count() }} Activities</span>
            </div>
            <a href="{{ route('skills.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to All Skills
            </a>
        </div>
    </div>
</div>

@if($skills->isEmpty() && $practiceSessions->isEmpty())
<!-- No Results -->
<div class="text-center py-5">
    <i class="fas fa-search fa-4x text-muted mb-3"></i>
    <h3 class="text-dark mb-3">No Results Found</h3>
    <p class="text-muted mb-4">We couldn't find any skills or activities matching "{{ $query }}"</p>
    <div class="d-flex justify-content-center gap-3">
        <a href="{{ route('skills.index') }}" class="btn btn-primary">
            <i class="fas fa-graduation-cap me-2"></i>View All Skills
        </a>
        <a href="{{ route('skills.create') }}" class="btn btn-outline-primary">
            <i class="fas fa-plus me-2"></i>Add New Skill
        </a>
    </div>
</div>
@else
<!-- Skills Results -->
@if(!$skills->isEmpty())
<div class="row mb-5">
    <div class="col-12">
        <h3 class="text-dark mb-4">
            <i class="fas fa-graduation-cap me-2 text-primary"></i>
            Skills ({{ $skills->count() }})
        </h3>
        <div class="row">
            @foreach($skills as $skill)
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card skill-card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title fw-bold text-dark">{{ $skill->name }}</h5>
                            <span class="badge bg-primary">{{ $skill->category }}</span>
                        </div>
                        
                        <p class="card-text text-muted small mb-3">
                            {{ $skill->description ? Str::limit($skill->description, 80) : 'No description provided' }}
                        </p>
                        
                        <!-- Progress Section -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">Progress</small>
                                <small class="fw-bold text-primary">{{ $skill->progress_percentage }}%</small>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-primary" 
                                     style="width: {{ $skill->progress_percentage }}%"
                                     role="progressbar">
                                </div>
                            </div>
                            <div class="text-center mt-1">
                                <small class="text-muted">
                                    {{ $skill->total_practice_hours }}h of {{ $skill->target_hours }}h target
                                </small>
                            </div>
                        </div>

                        <!-- Session Info & Actions -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>{{ $skill->practice_sessions_count }} sessions
                                </small>
                            </div>
                            <div class="btn-group">
                                <a href="{{ route('practice-sessions.create', $skill) }}" 
                                   class="btn btn-sm btn-primary" 
                                   title="Log Practice Session">
                                    <i class="fas fa-plus"></i>
                                </a>
                                <a href="{{ route('skills.show', $skill) }}" 
                                   class="btn btn-sm btn-outline-primary" 
                                   title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('skills.destroy', $skill) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger" 
                                            title="Delete Skill"
                                            onclick="return confirm('Are you sure you want to delete {{ $skill->name }}? This will also delete all {{ $skill->practice_sessions_count }} practice sessions.')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Practice Sessions Results -->
@if(!$practiceSessions->isEmpty())
<div class="row">
    <div class="col-12">
        <h3 class="text-dark mb-4">
            <i class="fas fa-history me-2 text-primary"></i>
            Practice Activities ({{ $practiceSessions->count() }})
        </h3>
        <div class="card border-0 shadow">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Skill</th>
                                <th>Date</th>
                                <th>Duration</th>
                                <th>Activity</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($practiceSessions as $session)
                            <tr>
                                <td>
                                    <a href="{{ route('skills.show', $session->skill) }}" class="text-decoration-none">
                                        <i class="fas fa-graduation-cap me-1 text-primary"></i>
                                        {{ $session->skill->name }}
                                    </a>
                                </td>
                                <td>{{ $session->session_date->format('M j, Y') }}</td>
                                <td>{{ $session->minutes_practiced }} min</td>
                                <td>{{ $session->what_was_practiced }}</td>
                                <td>{{ $session->notes ? Str::limit($session->notes, 50) : '-' }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('practice-sessions.edit', $session) }}" 
                                           class="btn btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('practice-sessions.destroy', $session) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger"
                                                    onclick="return confirm('Delete this session?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endif
@endsection