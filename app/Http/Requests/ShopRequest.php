<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
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
            'company_id' => 'required|int',
            'location' => 'required|string',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Campo obrigatório',
            'company_id.required' => 'Campo obrigatório',
            'location.required' => 'Campo obrigatório',
        ];
    }

    public function getShopData(): array
    {
        return [
            'name' => $this->input('name'),
            'company_id' => $this->input('company_id'),
            'location' => $this->input('location'),
            'active' => true,
        ];
    }
}
