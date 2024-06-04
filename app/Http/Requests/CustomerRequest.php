<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string',
            'cnpj' => 'required|unique:customers|string',
            'email' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'responsible' => 'required|string',
            'responsible_phone' => 'required|string',
            'segment' => 'required|string',
        ];

        if($this->method() == 'PUT') {
            $rules['cnpj'] = 'required|string';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Campo obrigatório',
            'cnpj.required' => 'Campo obrigatório',
            'email.required' => 'Campo obrigatório',
            'address.required' => 'Campo obrigatório',
            'phone.required' => 'Campo obrigatório',
            'responsible.required' => 'Campo obrigatório',
            'responsible_phone.required' => 'Campo obrigatório',
            'segment.required' => 'Campo obrigatório',

            'cnpj.unique' => 'CNPJ já cadastrado como cliente',
        ];
    }

    public function getCustomerData(): array
    {
        return [
            'name' => $this->input('name'),
            'cnpj' => $this->input('cnpj'),
            'email' => $this->input('email'),
            'address' => $this->input('address'),
            'phone' => $this->input('phone'),
            'responsible' => $this->input('responsible'),
            'responsible_phone' => $this->input('responsible_phone'),
            'segment' => $this->input('segment'),
        ];
    }
}
