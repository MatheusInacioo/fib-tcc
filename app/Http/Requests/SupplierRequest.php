<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'cnpj' => 'required|string',
            'email' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'responsible' => 'required|string',
            'responsible_phone' => 'required|string',
            'segment' => 'required|string',
        ];
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
        ];
    }

    public function getSupplierData(): array
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
