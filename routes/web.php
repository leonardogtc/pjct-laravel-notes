<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    echo "Olá Mundo!";
});


Route::get('/about', function () {
    echo "About Us!";
});

// Criar uma rota diretamente para um método dentro de uma classe
Route::get('/main', [MainController::class, 'index']);
