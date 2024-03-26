<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CrmAttendanceResource extends JsonResource
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
            'crm_id' => $this->crm_id,
            'description' => $this->description,
            'user' => $this->user,
            'created_at' => Carbon::parse($this->created_at)->timezone('America/Sao_Paulo'),
            'updated_at' => Carbon::parse($this->updated_at)->timezone('America/Sao_Paulo'),
        ];
    }
}
