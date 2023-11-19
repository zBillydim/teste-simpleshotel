<?php

namespace App\Http\Requests;

use App\Models\Cliente;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
    /**
     * Summary of failedValidation
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return never
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation error',
            'data' => $validator->errors()
        ], 403));
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'O campo email é obrigatório.',
            'password.required' => 'O campo password é obrigatório.',
        ];
    }
    public function authenticate(string $email, string $password)
    {
        $validateMail = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!$validateMail) {
            abort(403, "Digite um email válido");
        }

        $user = Cliente::where('email', $email)->first();

        if (!$user) {
            abort(403, 'Seu cadastro não foi localizado.');
        }

        if (!Hash::check($password, $user->password)) {
            abort(403, 'Senha incorreta.');
        }

        $token = $user->createToken('token_user')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }
}
