<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController as AdminAuthenticatedSessionController;
use App\Http\Controllers\Admin\TournamentController;
use App\Http\Controllers\Admin\RuleController;
use App\Http\Controllers\Admin\TournamentPointController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/universities', [UniversityController::class, 'index'])->name('universities.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/universities', [UniversityController::class, 'index'])->name('universities.index');
    Route::get('/universities/edit', [UniversityController::class, 'edit'])->name('universities.edit');
    Route::put('/universities', [UniversityController::class, 'update'])->name('universities.update');
    Route::get('/users', [UserController::class, 'adminIndex'])->name('users.index');
    Route::get('/tournaments', [TournamentController::class, 'index'])->name('tournaments.index');
    Route::get('/tournaments/create', [TournamentController::class, 'create'])->name('tournaments.create');
    Route::post('/tournaments', [TournamentController::class, 'store'])->name('tournaments.store');
    Route::get('/rules', [RuleController::class, 'index'])->name('rules.index');
    Route::get('/tournament-points/create', [TournamentPointController::class, 'create'])->name('tournament-points.create');
    Route::post('/tournament-points', [TournamentPointController::class, 'store'])->name('tournament-points.store');
    Route::get('/tournament-points/{grade}', [TournamentPointController::class, 'show'])->name('tournament-points.show');
    Route::put('/tournament-points/{grade}', [TournamentPointController::class, 'update'])->name('tournament-points.update');
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [AdminProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/logout', [AdminAuthenticatedSessionController::class, 'destroy'])->name('logout');
});

require __DIR__.'/auth.php';
