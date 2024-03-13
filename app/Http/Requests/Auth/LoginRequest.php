<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email|max:255|regex:/^[a-z]+@[a-z0-9.-]+\.[a-z]{2,}$/i',
            'password' => 'required|min:6|max:14|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).+$/',
            'remember' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Campo obrigatório.',
            'email.email' => 'Formato de email inválido.',
            'email.max' => 'O email deve ter no máximo :max caracteres.',
            'email.regex' => 'Formato de email inválido',

            'password.required' => 'Campo obrigatório.',
            'password.min' => 'A senha deve ter no mínimo :min caracteres.',
            'password.max' => 'A senha deve ter no máximo :max caracteres.',
            'password.regex' => 'A senha deve conter pelo menos um caractere especial, um número, letras maíusculas e minúsculas',
        ];
    }

    public function getLoginData()
    {
        return [
            'email' => $this->input('email'),
            'password' => $this->input('password'),
            'remember' => $this->input('remember') ? true : false,
        ];
    }
}
