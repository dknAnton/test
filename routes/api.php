<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('tasks', [TaskController::class, 'store']);
Route::get('tasks', [TaskController::class, 'index']);
Route::get('tasks/{task}', [TaskController::class, 'show']);
Route::put('tasks/{task}', [TaskController::class, 'update']);
Route::patch('/tasks/{task}/toggle-completion', [TaskController::class, 'toggleCompletion']);
Route::delete('tasks/{task}', [TaskController::class, 'destroy']);
