<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'corporate_name' => 'required|string',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Campo obrigatório',
            'corporate_name.required' => 'Campo obrigatório',
        ];
    }

    public function getCompanyData(): array
    {
        return [
            'name' => $this->input('name'),
            'corporate_name' => $this->input('corporate_name'),
            'active' => true,
        ];
    }
}
