<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AdminInfo;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\RegistrationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AdminAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout']);
    Route::post('/admin/update-email', [AdminInfo::class, 'updateEmail']);
    Route::post('/admin/update-password', [AdminInfo::class, 'updatePassword']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/events', [EventController::class, 'store']); 
    Route::delete('/events/{id}', [EventController::class, 'destroy']);
});
Route::get('/events', [EventController::class, 'index']); 
Route::get('/events/{id}', [EventController::class, 'show']); 


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/registrations', [RegistrationController::class, 'index']); 
    Route::get('/registrations/{id}', [RegistrationController::class, 'show']); 
    Route::delete('/registrations/{id}', [RegistrationController::class, 'destroy']);
    Route::put('registrations/{id}', [RegistrationController::class, 'approve']); 
});

Route::post('/PostRegistration',[RegistrationController::class,'store']);