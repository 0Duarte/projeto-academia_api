<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ExportWorkoutController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkoutController;
use App\Http\Middleware\ValidateLimitStudentsToUser;
use App\Models\Student;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    // rotas privadas
    Route::get('students/export', [ExportWorkoutController::class, 'ExportWorkoutPdf']);

    Route::post('students', [StudentController::class, 'store'])->middleware(ValidateLimitStudentsToUser::class);
    Route::get('students', [StudentController::class, 'index']);
    Route::delete('students/{id}', [StudentController::class, 'destroy']);
    Route::put('students/{id}', [StudentController::class, 'update']);
    Route::get('students/{id}', [StudentController::class, 'show']);

    Route::get('students/{id}/workouts', [WorkoutController::class, 'show']);
    Route::post('workouts', [WorkoutController::class, 'store']);

    Route::get('dashboard', [DashboardController::class, 'index']);

    Route::post('exercises', [ExerciseController::class, 'store']);
    Route::get('exercises', [ExerciseController::class, 'index']);
    Route::delete('exercises/{id}', [ExerciseController::class, 'destroy']);

});

// rota pública
Route::post('users', [UserController::class, 'store']);
Route::post('login', [AuthController::class, 'store']);
