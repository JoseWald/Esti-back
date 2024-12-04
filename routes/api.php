<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminAuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AdminAuthController::class, 'login']);
Route::post('/logout', [AdminAuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/events', [EventController::class, 'store']); 
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/events', [EventController::class, 'index']); 
    Route::get('/events/{id}', [EventController::class, 'show']); 
    
    Route::put('/events/{id}', [EventController::class, 'update']); 
    Route::delete('/events/{id}', [EventController::class, 'destroy']);
});
