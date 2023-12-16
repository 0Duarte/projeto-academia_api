<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    // rotas privadas
});

// rota pública
Route::post('users', [UserController::class, 'store']);
