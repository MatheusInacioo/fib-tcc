<?php

namespace App\Http\Requests;

use App\Enums\TransactionTypeEnum;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class TransactionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $RULES = [
            'type' => ['required', new Enum(TransactionTypeEnum::class)],
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
            'price' => 'required',
            'total_amount' => 'required',
            'expiry_date' => 'nullable',
            'payment_method' => 'required|string',
            'notes' => 'nullable',
        ];

        if ($this->input('customer_id') && ! $this->input('supplier_id')) {
            $RULES['customer_id'] = 'required|integer';
            $RULES['supplier_id'] = 'nullable';
        } elseif ($this->input('supplier_id') && ! $this->input('customer_id')) {
            $RULES['customer_id'] = 'nullable';
            $RULES['supplier_id'] = 'required|integer';
        }

        if (TransactionTypeEnum::tryFrom((int) $this->input('type')) === TransactionTypeEnum::SALE) {
            if (is_string($RULES['quantity'])) {
                $RULES['quantity'] = explode('|', $RULES['quantity']);
            }

            $RULES['quantity'][] = function ($ATTRIBUTE, $VALUE, $FAIL) {
                $PRODUCT = Product::find($this->input('product_id'));

                if ($PRODUCT && $VALUE > $PRODUCT->total_amount) {
                    $FAIL('Quantidade indisponível para venda. Disponível: '.$PRODUCT->total_amount);
                }
            };
        }

        return $RULES;
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
            'company_id' => session()->get('selected_company_id'),
            'shop_id' => session()->get('selected_shop_id'),
            'type' => TransactionTypeEnum::from((int) $this->input('type')),
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
