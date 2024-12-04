<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AdminAuthController::class, 'login']);

Route::post('/logout', [AdminAuthController::class, 'logout'])->middleware('auth:sanctum');
