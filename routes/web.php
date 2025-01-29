<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\CheckIsNotLogged;
use Illuminate\Support\Facades\Route;

// Rotas de autenticação
Route::middleware([CheckIsNotLogged::class])->group(function () {
    Route::get('/login', [AuthController::class, 'login']);
    Route::post('/loginSubmit', [AuthController::class, 'loginSubmit']);
});

// Rotas quando o usuário está logado
Route::middleware([CheckIsLogged::class])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('home');

    // Criar nova nota
    Route::get('/newNote', [MainController::class, 'newNote'])->name('new');
    Route::post('/newNoteSubmit', [MainController::class, 'newNoteSubmit'])->name('newNoteSubmit');

    // Editar nota
    Route::get('/editNote/{id}', [MainController::class, 'editNote'])->name('edit');

    // Deletar nota
    Route::get('/deleteNote/{id}', [MainController::class, 'deleteNote'])->name('delete');

    // Efetuar logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
