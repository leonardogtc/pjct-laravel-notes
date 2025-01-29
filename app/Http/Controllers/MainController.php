<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Operations;

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

    public function editNote($id)
    {
        $id = Operations::decryptID($id);
        echo "Editando nota de ID = $id";
    }

    public function deleteNote($id)
    {
        $id = Operations::decryptID($id);
        echo "Deletando nota de ID = $id";
    }


}
