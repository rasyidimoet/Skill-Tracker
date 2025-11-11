@extends('layouts.app')

@section('content')
<div class="text-center mb-5 floating">
    <h1 class="display-4 fw-bold mb-3">Life Skills Training Center</h1>
    <p class="lead text-muted fw-semibold">Develop your abilities and grow in every aspect of life! 🌱</p>
</div>

<!-- Stats Cards -->
<div class="row mb-5 justify-content-center">
    <div class="col-md-2 col-6 mb-3">
        <div class="stat-card text-center p-3 d-flex flex-column justify-content-between" style="min-height: 140px;">
            <div>
                <h3 class="fw-bold mb-1">{{ $skills->count() }}</h3>
                <small>Life Skills</small>
            </div>
            <div class="mt-2">
                <i class="fas fa-seedling"></i>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-6 mb-3">
        <div class="stat-card text-center p-3 d-flex flex-column justify-content-between" style="min-height: 140px;">
            <div>
                <h3 class="fw-bold mb-1">{{ $skills->sum('practice_sessions_count') }}</h3>
                <small>Practice Sessions</small>
            </div>
            <div class="mt-2">
                <i class="fas fa-dumbbell"></i>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-6 mb-3">
        <div class="stat-card text-center p-3 d-flex flex-column justify-content-between" style="min-height: 140px;">
            <div>
                <h3 class="fw-bold mb-1">{{ round($skills->sum('total_minutes') / 60, 1) }}</h3>
                <small>Total Hours</small>
            </div>
            <div class="mt-2">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-6 mb-3">
        <div class="stat-card text-center p-3 d-flex flex-column justify-content-between" style="min-height: 140px;">
            <div>
                <h3 class="fw-bold mb-1">{{ round(auth()->user()->total_practice_time / 60, 1) }}</h3>
                <small>Learning Time</small>
            </div>
            <div class="mt-2">
                <i class="fas fa-brain"></i>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="row mb-4 justify-content-center">
    <div class="col-md-8 text-center">
        <a href="{{ route('skills.create') }}" class="btn btn-primary btn-lg me-3 px-4">
            <i class="fas fa-plus me-2"></i>New Life Skill
        </a>
        <a href="{{ route('practice-sessions.create') }}" class="btn btn-outline-primary btn-lg px-4">
            <i class="fas fa-bolt me-2"></i>Log Practice
        </a>
    </div>
</div>

@if($skills->isEmpty())
<!-- Empty State -->
<div class="text-center py-5 floating">
    <div class="mb-4">
        <i class="fas fa-star fa-4x" style="color: var(--skill-color);"></i>
    </div>
    <h3 class="display-5 fw-bold mb-3">Start Your Growth Journey!</h3>
    <p class="text-muted mb-4 fw-semibold">Every master was once a beginner. Plant your first skill seed and watch it grow!</p>
    <a href="{{ route('skills.create') }}" class="btn btn-primary btn-lg px-5">
        <i class="fas fa-rocket me-2"></i>Begin Growing
    </a>
</div>
@else
<!-- Attribute Columns -->
<div class="row">
    <!-- Speed Column - Technical & Quick Skills -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="attribute-column speed">
            <div class="attribute-header">
                <div class="attribute-logo">⚡</div>
                <h4 class="fw-bold" style="color: var(--speed-color);">Speed & Tech</h4>
                <small class="text-muted">Quick-learning technical abilities</small>
            </div>
            @foreach($skills->whereIn('category', ['Programming', 'Technology', 'Digital Skills']) as $skill)
            <div class="skill-card speed">
                <div class="card-body">
                    <h6 class="card-title fw-bold">{{ $skill->name }}</h6>
                    <div class="progress mb-2">
                        <div class="progress-bar" style="width: {{ $skill->progress_percentage }}%"></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">{{ $skill->progress_percentage }}%</small>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('practice-sessions.create', $skill) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-plus"></i>
                            </a>
                            <a href="{{ route('skills.show', $skill) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @if($skills->whereIn('category', ['Programming', 'Technology', 'Digital Skills'])->isEmpty())
            <div class="text-center py-3">
                <small class="text-muted">No technical skills yet</small>
            </div>
            @endif
        </div>
    </div>

    <!-- Power Column - Physical & Creative Skills -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="attribute-column power">
            <div class="attribute-header">
                <div class="attribute-logo">💪</div>
                <h4 class="fw-bold" style="color: var(--power-color);">Power & Creativity</h4>
                <small class="text-muted">Physical and artistic abilities</small>
            </div>
            @foreach($skills->whereIn('category', ['Sports', 'Arts', 'Music', 'Fitness']) as $skill)
            <div class="skill-card power">
                <div class="card-body">
                    <h6 class="card-title fw-bold">{{ $skill->name }}</h6>
                    <div class="progress mb-2">
                        <div class="progress-bar" style="width: {{ $skill->progress_percentage }}%"></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">{{ $skill->progress_percentage }}%</small>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('practice-sessions.create', $skill) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-plus"></i>
                            </a>
                            <a href="{{ route('skills.show', $skill) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @if($skills->whereIn('category', ['Sports', 'Arts', 'Music', 'Fitness'])->isEmpty())
            <div class="text-center py-3">
                <small class="text-muted">No creative/physical skills yet</small>
            </div>
            @endif
        </div>
    </div>

    <!-- Wit & Stamina Column - Knowledge & Languages -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="attribute-column wit">
            <div class="attribute-header">
                <div class="attribute-logo">🧠</div>
                <h4 class="fw-bold" style="color: var(--wit-color);">Wisdom & Knowledge</h4>
                <small class="text-muted">Mental and language abilities</small>
            </div>
            @foreach($skills->whereIn('category', ['Languages', 'Academic', 'Other']) as $skill)
            <div class="skill-card wit">
                <div class="card-body">
                    <h6 class="card-title fw-bold">{{ $skill->name }}</h6>
                    <div class="progress mb-2">
                        <div class="progress-bar" style="width: {{ $skill->progress_percentage }}%"></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">{{ $skill->progress_percentage }}%</small>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('practice-sessions.create', $skill) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-plus"></i>
                            </a>
                            <a href="{{ route('skills.show', $skill) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @if($skills->whereIn('category', ['Languages', 'Academic', 'Other'])->isEmpty())
            <div class="text-center py-3">
                <small class="text-muted">No knowledge skills yet</small>
            </div>
            @endif
        </div>
    </div>
</div>
@endif
@endsection