<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CrmResource extends JsonResource
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
            'cnpj' => $this->cnpj,
            'email' => $this->email,
            'address' => $this->address,
            'zip_code' => $this->zip_code,
            'phone' => $this->phone,
            'responsible' => $this->responsible,
            'responsible_phone' => $this->responsible_phone,
            'segment' => $this->segment,
            'type' => $this->type,
            'status' => $this->status,
            'attendances' => $this->getAttendances(),
        ];
    }
}
