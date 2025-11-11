<?php

namespace App\Http\Controllers;

use App\Models\PracticeSession;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PracticeSessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Skill $skill = null)
    {
        $skills = Auth::user()->skills()->where('is_active', true)->get();
        
        return view('practice_sessions.create', compact('skills', 'skill'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'skill_id' => 'required|exists:skills,id',
            'session_date' => 'required|date',
            'minutes_practiced' => 'required|integer|min:1|max:480',
            'what_was_practiced' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
            'confidence_level' => 'nullable|integer|min:1|max:5'
        ]);

        // Verify the skill belongs to the user
        $skill = Auth::user()->skills()->findOrFail($request->skill_id);

        Auth::user()->practiceSessions()->create($request->all());

        return redirect()->route('skills.show', $request->skill_id)
            ->with('success', 'Practice session logged successfully!');
    }

    public function edit(PracticeSession $practiceSession)
    {
        if ($practiceSession->user_id !== Auth::id()) {
            abort(403);
        }

        $skills = Auth::user()->skills()->where('is_active', true)->get();

        return view('practice_sessions.edit', compact('practiceSession', 'skills'));
    }

    public function update(Request $request, PracticeSession $practiceSession)
    {
        if ($practiceSession->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'skill_id' => 'required|exists:skills,id',
            'session_date' => 'required|date',
            'minutes_practiced' => 'required|integer|min:1|max:480',
            'what_was_practiced' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
            'confidence_level' => 'nullable|integer|min:1|max:5'
        ]);

        $practiceSession->update($request->all());

        return redirect()->route('skills.show', $practiceSession->skill_id)
            ->with('success', 'Practice session updated successfully!');
    }

    public function destroy(PracticeSession $practiceSession)
    {
        if ($practiceSession->user_id !== Auth::id()) {
            abort(403);
        }

        $skillId = $practiceSession->skill_id;
        $practiceSession->delete();

        return redirect()->route('skills.show', $skillId)
            ->with('success', 'Practice session deleted successfully!');
    }
}