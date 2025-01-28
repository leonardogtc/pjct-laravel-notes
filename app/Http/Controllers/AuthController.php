<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        // form validation
        $request->validate(
            [
                'text_username' => 'required|email',
                'text_password' => 'required|min:6|max:16'
            ],
            // Mensagens de erro
            [
                'text_username.required' => 'O username é obrigatório',
                'text_username.email' => 'O username deve ser um e-mail válido',
                'text_password.required' => 'A password é obrigatória',
                'text_password.min' => 'A senha deve ter no mínimo :min caracteres',
                'text_password.max' => 'A senha deve ter no máximo :max caracteres'
            ]
        );

        // get user input
        $usernema = $request->input('text_username');
        $password = $request->input('text_password');

        // Pegar usuários da database
        // $users = User::all()->toArray();

        // Pode ser obtido o mesmo resultado instanciando o model
        $userModel = new User();
        $users = $userModel->all()->toArray();
        echo "<pre>";
        print_r($users);
        echo "<pre>";
    }

    public function logout()
    {
        echo "logout";
    }
}
