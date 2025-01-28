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
        $username = $request->input('text_username');
        $password = $request->input('text_password');

        // Autenticar usuários
        // Verificar se usuários existe
        $user = User::where('username', $username)->where('deleted_at', NULL)->first();

        if (!$user) {
            // Esse código mantém o sistema na tela de login quando o usuário não existir.
            return redirect()->back()->withInput()->with('loginError', 'Username ou password incorretas');
        }

        // Verificando password
        if (!password_verify($password, $user->password)) {
            return redirect()->back()->withInput()->with('loginError', 'Username ou password incorretas');
        }

        // update last_login
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        // login user
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username
            ]
        ]);

        // Redirecionar para a página principal
        return redirect()->to('/');
    }

    public function logout()
    {
        // Limpa os dados da sessão user (descarregando o usuário)
        session()->forget('user');

        // Retorna a rota de login
        return redirect()->to('/login');
    }
}
