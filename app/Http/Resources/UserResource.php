<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role_id,
            'role_name' => $this->getRoleName() ?? 'Sem Cargo',
            'company_id' => $this->company_id,
            'company_name' => $this->getCompanyName() ?? 'Não alocado',
            'shop_id' => $this->shop_id,
            'shop_name' => $this->getShopName() ?? 'Não alocado',
        ];
    }
}
