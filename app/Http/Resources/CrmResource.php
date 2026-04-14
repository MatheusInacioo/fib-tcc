<?php

namespace App\Http\Resources;

use App\Enums\CrmLeadStatusEnum;
use App\Enums\CrmPartyTypeEnum;
use Carbon\Carbon;
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
        $PARTY_TYPE = $this->type instanceof CrmPartyTypeEnum
            ? $this->type
            : CrmPartyTypeEnum::tryFrom((int) $this->type) ?? CrmPartyTypeEnum::CUSTOMER;
        $LEAD_STATUS = $this->status instanceof CrmLeadStatusEnum
            ? $this->status
            : CrmLeadStatusEnum::tryFrom((int) $this->status) ?? CrmLeadStatusEnum::CONTACT;

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
            'type' => $PARTY_TYPE->value,
            'type_label' => $PARTY_TYPE->label(),
            'status' => $LEAD_STATUS->value,
            'status_label' => $LEAD_STATUS->label(),
            'last_update' => Carbon::parse($this->updated_at)->format('d/m/Y'),
            'attendances' => $this->getAttendances(),
        ];
    }
}
