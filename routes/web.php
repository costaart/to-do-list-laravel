<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('tasks');
});

Route::get('/', [TaskController::class, 'index']);
Route::post('/tasks', [TaskController::class, 'store']);
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
