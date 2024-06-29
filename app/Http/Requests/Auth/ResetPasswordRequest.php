<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Campo obrigatório',
            'password.required' => 'Campo obrigatório',
            'password_confirmation.required' => 'Campo obrigatório',
            'password.confirmed' => 'As senhas não correspondem',
        ];
    }
}
