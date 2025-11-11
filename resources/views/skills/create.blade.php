@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow">
            <div class="card-header text-white text-center py-3" style="background: linear-gradient(135deg, var(--speed-color), var(--skill-color));">
                <h4 class="mb-0"><i class="fas fa-plus me-2"></i>Create New Life Skill</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('skills.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Skill Name *</label>
                        <input type="text" class="form-control form-control-lg" id="name" name="name" 
                               value="{{ old('name') }}" placeholder="e.g., JavaScript, Guitar, Spanish" required>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label fw-semibold">Category *</label>
                        <select class="form-select form-select-lg" id="category" name="category" required>
                            <option value="">Choose a life category...</option>
                            <optgroup label="⚡ Speed & Tech">
                                <option value="Programming" {{ old('category') == 'Programming' ? 'selected' : '' }}>Programming</option>
                                <option value="Technology" {{ old('category') == 'Technology' ? 'selected' : '' }}>Technology</option>
                                <option value="Digital Skills" {{ old('category') == 'Digital Skills' ? 'selected' : '' }}>Digital Skills</option>
                            </optgroup>
                            <optgroup label="💪 Power & Creativity">
                                <option value="Sports" {{ old('category') == 'Sports' ? 'selected' : '' }}>Sports</option>
                                <option value="Arts" {{ old('category') == 'Arts' ? 'selected' : '' }}>Arts</option>
                                <option value="Music" {{ old('category') == 'Music' ? 'selected' : '' }}>Music</option>
                                <option value="Fitness" {{ old('category') == 'Fitness' ? 'selected' : '' }}>Fitness</option>
                            </optgroup>
                            <optgroup label="🧠 Wisdom & Knowledge">
                                <option value="Languages" {{ old('category') == 'Languages' ? 'selected' : '' }}>Languages</option>
                                <option value="Academic" {{ old('category') == 'Academic' ? 'selected' : '' }}>Academic</option>
                                <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" 
                                  placeholder="Describe what you want to learn and why...">{{ old('description') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="target_hours" class="form-label fw-semibold">Target Hours</label>
                                <input type="number" class="form-control" id="target_hours" name="target_hours" 
                                       value="{{ old('target_hours', 0) }}" min="0" placeholder="0">
                                <div class="form-text">Set a goal to stay motivated on your journey!</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="color" class="form-label fw-semibold">Skill Color</label>
                                <input type="color" class="form-control form-control-color" id="color" name="color" 
                                       value="{{ old('color', '#3b82f6') }}" title="Choose skill color">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('skills.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-seedling me-2"></i>Plant Skill
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection