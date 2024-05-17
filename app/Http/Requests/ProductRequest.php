<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'sku' => 'required|string',
            'brand' => 'required|string',
            'supplier_id' => 'required|int',
            'purchase_price' => 'required|decimal:0,2',
            'sale_price' => 'required|decimal:0,2',
            'total_amount' => 'required|int',
            'minimum_amount' => 'required|int',
            'storage_location' => 'required|string',
            'expiry_date' => 'nullable|date',
            'description' => 'required|string',
            'additional_info' => 'nullable|string',
        ];

        if (!$this->route('product') || $this->isSkuChanged()) {
            $rules['sku'] .= '|unique:products';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Campo obrigatório',
            'sku.required' => 'Campo obrigatório',
            'brand.required' => 'Campo obrigatório',
            'supplier_id.required' => 'Campo obrigatório',
            'purchase_price.required' => 'Campo obrigatório',
            'sale_price.required' => 'Campo obrigatório',
            'total_amount.required' => 'Campo obrigatório',
            'minimum_amount.required' => 'Campo obrigatório',
            'storage_location.required' => 'Campo obrigatório',
            'description.required' => 'Campo obrigatório',

            'purchase_price.decimal' => 'No máximo 2 casas decimais',
            'sale_price.decimal' => 'No máximo 2 casas decimais',
            'sku.unique' => 'SKU já cadastrado',
        ];
    }

    private function isSkuChanged(): bool
    {
        $productId = $this->route('product')->id ?? null;
        $requestedSku = $this->input('sku');
        $currentProduct = $productId ? Product::findOrFail($productId) : null;

        return $currentProduct && $requestedSku !== $currentProduct->sku;
    }

    public function getProductData(): array
    {
        return [
            'name' => $this->input('name'),
            'sku' => $this->input('sku'),
            'brand' => $this->input('brand'),
            'supplier_id' => $this->input('supplier_id'),
            'purchase_price' => $this->input('purchase_price'),
            'sale_price' => $this->input('sale_price'),
            'total_amount' => $this->input('total_amount'),
            'minimum_amount' => $this->input('minimum_amount'),
            'storage_location' => $this->input('storage_location'),
            'expiry_date' => $this->input('expiry_date'),
            'description' => $this->input('description'),
            'additional_info' => $this->input('additional_info'),
        ];
    }
}
