<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        // Load user's notes (Pega as notas do usuário)
        $id = session('user.id');
        $notes = User::find($id)->notes()->get()->toArray();

        // Mostrar a view 'home'
        return view('home', ['notes' => $notes]);
    }

    public function newNote()
    {
        echo "Criando nova Nota";
    }
}
