<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrmRequest extends FormRequest
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
            'cnpj' => 'required|string',
            'email' => 'required|email|max:50|regex:/^[a-z0-9._]+@[a-z0-9.-]+\.[a-z]{2,}$/i',
            'address' => 'nullable',
            'phone' => 'nullable',
            'responsible' => 'nullable',
            'responsible_phone' => 'nullable',
            'segment' => 'nullable',
            'type' => 'required|string',
            'status' => 'required|string',
            'description' => 'nullable',
        ];

        if ($this->routeIs('crm.close')) {
            $rules['address'] = 'required|string';
            $rules['phone'] = 'required|string';
            $rules['responsible'] = 'required|string';
            $rules['responsible_phone'] = 'required|string';
            $rules['segment'] = 'required|string';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Campo obrigatório.',
            'email.email' => 'Formato de email inválido.',
            'email.max' => 'O email deve ter no máximo :max caracteres.',
            'email.regex' => 'Formato de email inválido',

            'name.required' => 'Campo obrigatório',
            'cnpj.required' => 'Campo obrigatório',
            'segment.required' => 'Campo obrigatório',
            'type.required' => 'Campo obrigatório',
            'status.required' => 'Campo obrigatório',
            'address.required' => 'Campo obrigatório',
            'phone.required' => 'Campo obrigatório',
            'responsible.required' => 'Campo obrigatório',
            'responsible_phone.required' => 'Campo obrigatório',
            'segment.required' => 'Campo obrigatório',
        ];
    }

    public function getCrmData(): array
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
            'type' => $this->input('type'),
            'status' => $this->input('status'),
        ];
    }

    public function getAttendanceData(): array
    {
        return [
            'crm_id' => $this->route('crm')->id ?? null,
            'description' => $this->input('description') ?? auth()->user()->name . " fez uma alteração no cadastro. Nenhuma descrição registrada.",
            'user' => auth()->user()->name,
        ];
    }
}
