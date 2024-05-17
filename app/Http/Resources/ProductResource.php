<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'sku' => $this->sku,
            'brand' => $this->brand,
            'supplier_id' => $this->supplier_id,
            'supplier_name' => $this->getSupplierName(),
            'purchase_price' => $this->purchase_price,
            'sale_price' => $this->sale_price,
            'total_amount' => $this->total_amount,
            'minimum_amount' => $this->minimum_amount,
            'storage_location' => $this->storage_location,
            'expiry_date' => $this->expiry_date,
            'description' => $this->description,
            'additional_info' => $this->additional_info,
        ];
    }
}
