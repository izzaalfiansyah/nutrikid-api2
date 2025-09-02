<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return [
        'success' => true,
        'message' => "It's worked",
    ];
});

Route::post('/login', [AuthController::class, 'login']);
