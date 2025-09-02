<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\MeasurementSuggestionController;
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

Route::post('/calculate', [MeasurementController::class, 'calculate']);
Route::post('/default-zscore', [MeasurementController::class, 'getDefaultZScore']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, "logout"]);

Route::middleware(AuthMiddleware::class)->get('/profile', [AuthController::class, 'profile']);
Route::middleware(AuthMiddleware::class)->post('/profile', [AuthController::class, 'updateProfile']);
Route::middleware(AuthMiddleware::class)->post('/change-password', [AuthController::class, 'changePassword']);
Route::middleware(AuthMiddleware::class)->post('/refresh-token', [AuthController::class, 'refreshToken']);

Route::post('/user/{id}/change-password', [UserController::class, 'changePassword']);
Route::resource('/user', UserController::class, ['only' => ['index', 'show', 'store', 'update', 'destroy']]);

Route::resource('/school', SchoolController::class, ['only' => ['index', 'store', 'update', 'destroy']]);

Route::resource('/student', StudentController::class, ['only' => ['index', 'show', 'store', 'update', 'destroy']]);

Route::resource('/measurement/{measurementId}/suggestion', MeasurementSuggestionController::class, ['only' => ['index', 'store', 'update', 'destroy']]);
Route::resource('/measurement', MeasurementController::class, ['only' => ['index', 'show', 'store', 'update', 'destroy']]);

Route::resource('/measurement-suggestion', MeasurementSuggestionController::class, ['only' => ['index', 'store', 'update', 'destroy']]);
