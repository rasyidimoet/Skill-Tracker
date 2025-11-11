@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12 text-center">
        <h1 class="display-5 fw-bold text-dark mb-2">{{ $skill->name }}</h1>
        <span class="badge bg-primary fs-6">{{ $skill->category }}</span>
    </div>
</div>

<div class="row justify-content-center mb-4">
    <div class="col-md-8 text-center">
        <div class="btn-group">
            <a href="{{ route('practice-sessions.create', $skill) }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Log Session
            </a>
            <a href="{{ route('skills.edit', $skill) }}" class="btn btn-outline-primary">
                <i class="fas fa-edit me-2"></i>Edit Skill
            </a>
            <form action="{{ route('skills.destroy', $skill) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="btn btn-outline-danger" 
                        onclick="return confirm('Are you sure you want to delete {{ $skill->name }}? This will also delete all {{ $skill->practiceSessions ? $skill->practiceSessions->count() : 0 }} practice sessions.')">
                    <i class="fas fa-trash me-2"></i>Delete Skill
                </button>
            </form>
            <a href="{{ route('skills.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow mb-4">
            <div class="card-body p-4">
                <h4 class="card-title text-center mb-4">
                    <i class="fas fa-chart-line me-2 text-primary"></i>Progress Overview
                </h4>
                
                <div class="row text-center mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="p-3 bg-light rounded">
                            <h3 class="text-primary fw-bold">{{ $skill->total_practice_hours }}h</h3>
                            <small class="text-muted">Total Practice</small>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="p-3 bg-light rounded">
                            <h3 class="text-primary fw-bold">{{ $skill->practiceSessions ? $skill->practiceSessions->count() : 0 }}</h3>
                            <small class="text-muted">Sessions</small>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="p-3 bg-light rounded">
                            <h3 class="text-primary fw-bold">{{ $skill->target_hours }}h</h3>
                            <small class="text-muted">Target</small>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="p-3 bg-light rounded">
                            <h3 class="text-primary fw-bold">{{ $skill->progress_percentage }}%</h3>
                            <small class="text-muted">Progress</small>
                        </div>
                    </div>
                </div>

                @if($skill->description)
                <div class="mb-4">
                    <h5 class="text-dark">About This Skill</h5>
                    <p class="text-muted">{{ $skill->description }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Practice Sessions -->
        <div class="card border-0 shadow">
            <div class="card-header bg-light py-3">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Practice Sessions</h5>
            </div>
            <div class="card-body p-0">
                @if(!$skill->practiceSessions || $skill->practiceSessions->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-clock fa-3x text-muted mb-3"></i>
                    <h5 class="text-dark">No Practice Sessions Yet</h5>
                    <p class="text-muted">Start tracking your progress by logging your first practice session!</p>
                    <a href="{{ route('practice-sessions.create', $skill) }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Log First Session
                    </a>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Duration</th>
                                <th>Activity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($skill->practiceSessions as $session)
                            <tr>
                                <td>{{ $session->session_date->format('M j, Y') }}</td>
                                <td>{{ $session->minutes_practiced }} min</td>
                                <td>{{ Str::limit($session->what_was_practiced, 40) }}</td>
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
                @endif
            </div>
        </div>
    </div>
</div>
@endsection