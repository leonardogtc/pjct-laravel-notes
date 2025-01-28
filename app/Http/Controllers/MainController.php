<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        echo "Estou no APP";
    }

    public function newNote()
    {
        echo "Criando nova Nota";
    }
}
