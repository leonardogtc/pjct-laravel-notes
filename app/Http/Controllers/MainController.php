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
        $user = User::find($id)->toArray();
        $notes = User::find($id)->notes()->get()->toArray();

        echo "<pre>";
        print_r($user);
        print_r($notes);

        die();

        // Mostrar a view 'home'
        return view('home');
    }

    public function newNote()
    {
        echo "Criando nova Nota";
    }
}
