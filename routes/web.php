<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\SeanceController;
use App\Http\Controllers\SiegeController;
use App\Http\Controllers\ReservationSiegeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IsAuthController;
use App\Http\Controllers\IsAdminController;
use App\Http\Controllers\ReservationController;


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/api/isAuth', [IsAuthController::class, 'index']);

Route::get('/api/isAdmin', [IsAdminController::class, 'index']);


Route::middleware('auth')->post('/film/add', [FilmController::class, 'store']);
Route::middleware('auth')->put('/film/update/{id}', [FilmController::class, 'update']);
Route::middleware('auth')->delete('/film/delete/{id}', [FilmController::class, 'destroy']);

Route::get('film/all', [FilmController::class, 'index']);
Route::apiResource('film', FilmController::class);

Route::get('/seance/{id}/occupied', function ($id) {
    return \App\Models\ReservationSiege::whereHas('reservation', function ($q) use ($id) {
        $q->where('seance_id', $id);
    })->pluck('siege_nom');
});

Route::get('seance/all', [SeanceController::class, 'index']);
Route::apiResource('seance', SeanceController::class);
Route::middleware('auth')->post('/seance/add', [SeanceController::class, 'store']);
Route::middleware('auth')->put('/seance/update/{id}', [SeanceController::class, 'update']);



Route::get('siege/all', [SiegeController::class, 'index']);
Route::apiResource('siege', SiegeController::class);

// routes/web.php or api.php
Route::middleware('auth')->post('/reservations', [ReservationController::class, 'store']);
Route::middleware('auth')->get('/reservations', [ReservationController::class, 'index']);

Route::middleware('auth')->get('/reservations/{id}', [ReservationController::class, 'show']);
Route::middleware('auth')->delete('/reservations/{id}', [ReservationController::class, 'destroy']);



Route::get('reservationSiege/all', [ReservationSiegeController::class, 'index']);
Route::apiResource('reservationSiege', ReservationSiegeController::class);

Route::get('/vue/{any?}', function () {
    return view('movievue.index');
})->where('any', '.*');

require __DIR__.'/auth.php';