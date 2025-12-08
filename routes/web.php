<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskApiController;

Route::get('/{any}', function () {
    return view('movievue.index'); 
})->where('any', '.*');
Route::get('/', function () {
    return view('welcome');
});

// API resource route
Route::apiResource('film/all', TaskApiController::class);
