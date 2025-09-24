<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
});

require __DIR__ . '/auth.php';
