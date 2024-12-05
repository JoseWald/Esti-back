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


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/events', [EventController::class, 'store']); 
    Route::delete('/events/{id}', [EventController::class, 'destroy']);
});
Route::get('/events', [EventController::class, 'index']); 
Route::get('/events/{id}', [EventController::class, 'show']); 