<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('moods', MoodController::class);
    
    Route::get('/moods/trashed', [MoodController::class, 'trashed'])->name('moods.trashed');
    Route::post('/moods/{mood}/restore', [MoodController::class, 'restore'])->name('moods.restore');
    
    Route::get('/moods/stats/month', [MoodController::class, 'moodOfTheMonth'])->name('moods.month');
    Route::get('/moods/summary/weekly', [MoodController::class, 'weeklyMoodSummary'])->name('moods.weekly');
});

require __DIR__ . '/auth.php';
