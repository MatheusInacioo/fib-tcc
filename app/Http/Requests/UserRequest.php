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
            'email' => 'required|email|max:255|regex:/^[a-z]+@[a-z0-9.-]+\.[a-z]{2,}$/i',
            'password' => 'required|string',
        ];

        if($this->method() == 'PUT') {
            $rules['password'] == 'nullable';
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            'name.required' => 'Campo obrigatório',
            'email.required' => 'Campo obrigatório',
            'password.required' => 'Campo obrigatório',
        ];

        if($this->method() == 'PUT') {
            unset($messages['password.required']);
        }

        return $messages;
    }

    public function getUserData(): array
    {
        return [
            'name' => $this->input('name'),
            'email' => $this->input('email'),
            'password' => $this->input('password') ?? null,
        ];
    }
}
