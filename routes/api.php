<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// routes/api.php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ArticleController; // <-- Import

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Endpoint yang hanya bisa diakses saat login
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) { // Contoh endpoint user
        return $request->user();
    });

    // Rute untuk Artikel (CRUD)
    Route::apiResource('articles', ArticleController::class);
});
