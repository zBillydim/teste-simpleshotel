<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class QuartoRequest extends FormRequest
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
            'numero' => 'required|string',
            'capacidade' => 'required|int',
            'preco_diaria' => 'required|numeric',
            'disponivel' => 'required|boolean',
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
            'numero.required' => 'O campo numero é obrigatório',
            'capacidade.required' => 'O campo capacidade é obrigatório',
            'preco_diaria.required' => 'O campo preco_diaria é obrigatório',
            'disponivel.required' => 'O campo disponivel é obrigatório',
            'disponivel.rule' => 'O campo disponivel deve ser true ou false',
        ];
    }
}
