<?php

use App\Http\Controllers\SkillController;
use App\Http\Controllers\PracticeSessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('skills.index');
});

// Simple Authentication Routes (no password reset)
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    // Search Route - MUST COME BEFORE resource route
    Route::get('/skills/search', [SkillController::class, 'search'])->name('skills.search');
    
    // Skills Routes
    Route::resource('skills', SkillController::class);
    
    // Practice Sessions Routes
    Route::get('/practice-sessions/create/{skill?}', [PracticeSessionController::class, 'create'])
        ->name('practice-sessions.create');
    Route::post('/practice-sessions', [PracticeSessionController::class, 'store'])
        ->name('practice-sessions.store');
    Route::get('/practice-sessions/{practiceSession}/edit', [PracticeSessionController::class, 'edit'])
        ->name('practice-sessions.edit');
    Route::put('/practice-sessions/{practiceSession}', [PracticeSessionController::class, 'update'])
        ->name('practice-sessions.update');
    Route::delete('/practice-sessions/{practiceSession}', [PracticeSessionController::class, 'destroy'])
        ->name('practice-sessions.destroy');
});