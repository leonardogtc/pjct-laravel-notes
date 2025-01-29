<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

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
        $id = $this->decryptId($id);
        echo "Editando nota de ID = $id";
    }

    public function deleteNote($id)
    {
        $id = $this->decryptId($id);
        echo "Deletando nota de ID = $id";
    }

    private function decryptId($id)
    {
        // Verifica se ID está encriptado
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->route('home');
        }

        return $id;
    }
}
