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


/*
adicionar mensagem ao deletar;
concluir tarefa ao clicar no checkbox;
	mudar o estilo da tarefa ao concluir ela


ao clicar em concluídas, só exibir as concluídas

melhorar o css, separando ele.

*/