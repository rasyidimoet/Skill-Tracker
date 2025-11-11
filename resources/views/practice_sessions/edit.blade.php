@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow">
            <div class="card-header bg-primary text-white text-center py-3">
                <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Practice Session</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('practice-sessions.update', $practiceSession) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="skill_id" class="form-label fw-semibold">Skill *</label>
                        <select class="form-select form-select-lg" id="skill_id" name="skill_id" required>
                            <option value="">Select a skill...</option>
                            @foreach($skills as $s)
                                <option value="{{ $s->id }}" 
                                    {{ $practiceSession->skill_id == $s->id ? 'selected' : '' }}>
                                    {{ $s->name }} ({{ $s->category }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="session_date" class="form-label fw-semibold">Date *</label>
                                <input type="date" class="form-control" id="session_date" name="session_date" 
                                       value="{{ old('session_date', $practiceSession->session_date->format('Y-m-d')) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="minutes_practiced" class="form-label fw-semibold">Minutes *</label>
                                <input type="number" class="form-control" id="minutes_practiced" name="minutes_practiced" 
                                       value="{{ old('minutes_practiced', $practiceSession->minutes_practiced) }}" min="1" max="480" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="what_was_practiced" class="form-label fw-semibold">What did you practice? *</label>
                        <textarea class="form-control" id="what_was_practiced" name="what_was_practiced" 
                                  rows="3" required>{{ old('what_was_practiced', $practiceSession->what_was_practiced) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label fw-semibold">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2">{{ old('notes', $practiceSession->notes) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="confidence_level" class="form-label fw-semibold">Confidence Level</label>
                        <select class="form-select" id="confidence_level" name="confidence_level">
                            <option value="">Select confidence level...</option>
                            <option value="1" {{ $practiceSession->confidence_level == 1 ? 'selected' : '' }}>1 - Very Low</option>
                            <option value="2" {{ $practiceSession->confidence_level == 2 ? 'selected' : '' }}>2 - Low</option>
                            <option value="3" {{ $practiceSession->confidence_level == 3 ? 'selected' : '' }}>3 - Medium</option>
                            <option value="4" {{ $practiceSession->confidence_level == 4 ? 'selected' : '' }}>4 - High</option>
                            <option value="5" {{ $practiceSession->confidence_level == 5 ? 'selected' : '' }}>5 - Very High</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('skills.show', $practiceSession->skill_id) }}" class="btn btn-outline-secondary px-4">
                            <i class="fas fa-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-2"></i>Update Session
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection