<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type_id' => $this->type,
            'type' => $this->type == 0 ? 'Compra' : 'Venda',
            'customer_id' => $this->customer_id,
            'supplier_id' => $this->supplier_id,
            'product_id' => $this->product_id,
            'customer_name' => $this->getCustomerName(),
            'supplier_name' => $this->getSupplierName(),
            'product_name' => $this->getProductName(),
            'quantity' => $this->quantity,
            'price' => $this->price,
            'total_amount' => $this->total_amount,
            'formatted_amount' => 'R$' . $this->total_amount,
            'payment_method' => $this->payment_method,
            'notes' => $this->notes,
            'user_id' => $this->user_id,
            'user_name' => $this->getUserName(),
            'date' => Carbon::parse($this->created_at)->format('d/m/Y'),
        ];
    }
}
