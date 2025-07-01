<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return "el backend funciona correctamente";
});

// Rutas de autenticación
Route::post("/register", [AuthController::class, "register"])->name("register");
Route::post("/login", [AuthController::class,"login"])->name( "login");

Route::middleware("jwt.auth")->group(function(){
    Route::get('who', [AuthController::class, 'who']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});