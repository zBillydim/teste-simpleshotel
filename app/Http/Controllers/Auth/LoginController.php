<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    /**
     * Handle a login request to the application.
     *
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginRequest $request)
    {           
        $user = $request->authenticate($request->email, $request->password);

        $response = [
            'id' => $user['user']->id,
            'nome' => $user['user']->nome,
            'email' => $user['user']->email,
            'telefone' => $user['user']->telefone,
            'token' => $user['token'],
        ];

        return response()->json(['success' => 'Usuário autenticado com sucesso', 'data' => $response], 200);
    }
}
