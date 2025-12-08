<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskApiController;

Route::get('/', function () {
    return view('welcome');
});

// API resource route
Route::apiResource('film/all', TaskApiController::class);
