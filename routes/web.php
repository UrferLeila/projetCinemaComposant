<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\SeanceController;
use App\Http\Controllers\SiegeController;
use App\Http\Controllers\ReservationSiegeController;
use App\Http\Controllers\Api\AuthController;

// API routes
Route::get('film/all', [FilmController::class, 'index']);
Route::apiResource('film', FilmController::class);

Route::get('/seance/{id}/occupied', function ($id) {
    return \App\Models\ReservationSiege::whereHas('reservation', function ($q) use ($id) {
        $q->where('seance_id', $id);
    })->pluck('siege_nom');
});

Route::get('seance/all', [SeanceController::class, 'index']);
Route::apiResource('seance', SeanceController::class);

Route::get('siege/all', [SiegeController::class, 'index']);
Route::apiResource('siege', SiegeController::class);

Route::get('reservationSiege/all', [ReservationSiegeController::class, 'index']);
Route::apiResource('reservationSiege', ReservationSiegeController::class);


Route::get('/{any}', function () {
    return view('movievue.index');
})->where('any', '.*');

Route::post('/login', [AuthController::class, 'login']);