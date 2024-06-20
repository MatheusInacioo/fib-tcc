<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'type' => 'required',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
            'price' => 'required',
            'total_amount' => 'required',
            'expiry_date' => 'nullable',
            'payment_method' => 'required|string',
            'notes' => 'nullable',
        ];

        if ($this->input('customer_id') && !$this->input('supplier_id')) {
            $rules['customer_id'] = 'required|integer';
            $rules['supplier_id'] = 'nullable';
        } else if ($this->input('supplier_id') && !$this->input('customer_id')) {
            $rules['customer_id'] = 'nullable';
            $rules['supplier_id'] = 'required|integer';
        }

        if ($this->input('type') == 1) {
            if (is_string($rules['quantity'])) {
                $rules['quantity'] = explode('|', $rules['quantity']);
            }

            $rules['quantity'][] = function ($attribute, $value, $fail) {
                $product = Product::find($this->input('product_id'));

                if ($product && $value > $product->total_amount) {
                    $fail('Quantidade indisponível para venda. Disponível: ' . $product->total_amount);
                }
            };
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Campo obrigatório',
            'customer_id.required' => 'Campo obrigatório',
            'supplier_id.required' => 'Campo obrigatório',
            'product_id.required' => 'Campo obrigatório',
            'quantity.required' => 'Campo obrigatório',
            'price.required' => 'Campo obrigatório',
            'total_amount.required' => 'Campo obrigatório',
            'payment_method.required' => 'Campo obrigatório',
        ];
    }

    public function getTransactionData(): array
    {
        return [
            'type' => $this->input('type'),
            'customer_id' => $this->input('customer_id'),
            'supplier_id' => $this->input('supplier_id'),
            'product_id' => $this->input('product_id'),
            'quantity' => $this->input('quantity'),
            'price' => $this->input('price'),
            'total_amount' => $this->input('total_amount'),
            'expiry_date' => $this->input('expiry_date'),
            'payment_method' => $this->input('payment_method'),
            'notes' => $this->input('notes'),
            'user_id' => auth()->user()->id,
        ];
    }
}
