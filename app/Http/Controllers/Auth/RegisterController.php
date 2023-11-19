<?php

namespace App\Http\Controllers\Auth;

use App\Models\Cliente;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Handle a registration request for the application.
     *
     * @param  \App\Http\Requests\RegisterRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $cliente = Cliente::create([
            'nome' => $request->input('nome'),
            'email' => $request->input('email'),
            'telefone' => $request->input('telefone'),
            'password' => $request->input('password'),
        ]);
        
        $token = $cliente->createToken('token_user')->plainTextToken;
        
        return response()->json([
            'cliente' => $cliente,
            'token' => $token,
        ], 201);
    }
}
