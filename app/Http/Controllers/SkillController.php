<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\PracticeSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $skills = Auth::user()->skills()
            ->withCount('practiceSessions')
            ->withSum('practiceSessions as total_minutes', 'minutes_practiced')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('skills.index', compact('skills'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        
        if (!$query) {
            return redirect()->route('skills.index');
        }

        // Search in skills (name, description, category)
        $skills = Auth::user()->skills()
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('category', 'LIKE', "%{$query}%");
            })
            ->withCount('practiceSessions')
            ->withSum('practiceSessions as total_minutes', 'minutes_practiced')
            ->orderBy('created_at', 'desc')
            ->get();

        // Search in practice sessions (what_was_practiced, notes)
        $practiceSessions = Auth::user()->practiceSessions()
            ->where(function($q) use ($query) {
                $q->where('what_was_practiced', 'LIKE', "%{$query}%")
                  ->orWhere('notes', 'LIKE', "%{$query}%");
            })
            ->with('skill')
            ->orderBy('session_date', 'desc')
            ->get();

        return view('skills.search', compact('skills', 'practiceSessions', 'query'));
    }

    public function create()
    {
        $categories = [
            'Programming' => 'Programming',
            'Technology' => 'Technology', 
            'Digital Skills' => 'Digital Skills',
            'Sports' => 'Sports',
            'Arts' => 'Arts',
            'Music' => 'Music',
            'Fitness' => 'Fitness',
            'Languages' => 'Languages',
            'Academic' => 'Academic',
            'Other' => 'Other'
        ];

        return view('skills.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'category' => 'required|string|max:50',
            'target_hours' => 'nullable|integer|min:0',
            'color' => 'nullable|string|size:7'
        ]);

        Auth::user()->skills()->create($request->all());

        return redirect()->route('skills.index')
            ->with('success', 'Life skill created successfully!');
    }

    public function show(Skill $skill)
    {
        if ($skill->user_id !== Auth::id()) {
            abort(403);
        }

        // Eager load the practiceSessions relationship with ordering
        $skill->load(['practiceSessions' => function($query) {
            $query->orderBy('session_date', 'desc');
        }]);

        return view('skills.show', compact('skill'));
    }

    public function edit(Skill $skill)
    {
        if ($skill->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = [
            'Programming' => 'Programming',
            'Technology' => 'Technology', 
            'Digital Skills' => 'Digital Skills',
            'Sports' => 'Sports',
            'Arts' => 'Arts',
            'Music' => 'Music',
            'Fitness' => 'Fitness',
            'Languages' => 'Languages',
            'Academic' => 'Academic',
            'Other' => 'Other'
        ];

        return view('skills.edit', compact('skill', 'categories'));
    }

    public function update(Request $request, Skill $skill)
    {
        if ($skill->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'category' => 'required|string|max:50',
            'target_hours' => 'nullable|integer|min:0',
            'color' => 'nullable|string|size:7'
        ]);

        $skill->update($request->all());

        return redirect()->route('skills.index')
            ->with('success', 'Life skill updated successfully!');
    }

    public function destroy(Skill $skill)
    {
        if ($skill->user_id !== Auth::id()) {
            abort(403);
        }

        // Delete associated practice sessions first (due to foreign key constraints)
        $skill->practiceSessions()->delete();
        
        // Then delete the skill
        $skill->delete();

        return redirect()->route('skills.index')
            ->with('success', 'Life skill deleted successfully!');
    }
}