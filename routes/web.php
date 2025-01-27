<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('principal');
});



Route::get('/about', function () {
    echo "About Us!";
});

// Criar uma rota diretamente para um método dentro de uma classe
// Adicionando um parâmetro a rota: /main para /main{value}
Route::get('/main/{value}', [MainController::class, 'index']);
Route::get('/page2/{value}', [MainController::class, 'page2']);
Route::get('/page3/{value}', [MainController::class, 'page3']);
