<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules()
    {
      return [
        'email' => 'required|email',
        'password' => 'required',
        'remember' => 'nullable'
      ];
    }

    public function messages(): array
    {
      return [
        'email.required' => 'Campo obrigatório',
        'email.email' => 'Email inválido',
        'password.required' => 'Campo obrigatório',
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
