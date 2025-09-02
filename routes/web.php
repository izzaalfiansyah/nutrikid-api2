<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return [
        'success' => true,
        'message' => "It's worked",
    ];
});

Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, "logout"]);
Route::middleware(AuthMiddleware::class)->get('/profile', [AuthController::class, 'profile']);
