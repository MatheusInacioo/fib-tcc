<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules =  [
            'name' => 'required|string',
            'email' => 'required|unique:users|email|max:50|regex:/^[a-z0-9._]+@[a-z0-9.-]+\.[a-z]{2,}$/i',
            'password' => 'required',
            'role_id' => 'required|integer',
        ];

        if($this->method() == 'PUT') {
            $rules['password'] = 'nullable';
            $rules['role_id'] = 'nullable';
            $rules['email'] = 'required|email|max:50|regex:/^[a-z0-9._]+@[a-z0-9.-]+\.[a-z]{2,}$/i';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Campo obrigatório',
            'email.required' => 'Campo obrigatório',
            'email.regex' => 'Formato de email inválido',
            'email.max' => 'O email deve ter no máximo :max caracteres',
            'password.required' => 'Campo obrigatório',
            'role_id.required' => 'Campo obrigatório',
        ];
    }

    public function getUserData(): array
    {
        return [
            'name' => $this->input('name'),
            'email' => $this->input('email'),
            'password' => $this->input('password') ?? null,
            'role_id' => $this->input('role_id') ?? null,
        ];
    }
}
