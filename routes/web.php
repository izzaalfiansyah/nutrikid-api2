<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
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
Route::resource('/user', UserController::class, ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
Route::resource('/school', SchoolController::class, ['only' => ['index', 'store', 'update', 'destroy']]);
Route::resource('/student', StudentController::class, ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
