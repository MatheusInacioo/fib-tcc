<?php

namespace App\Models;

use App\Enums\CrmLeadStatusEnum;
use App\Enums\CrmPartyTypeEnum;

class Crm extends AbstractModel
{
    protected $table = 'crm_data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $casts = [
        'type' => CrmPartyTypeEnum::class,
        'status' => CrmLeadStatusEnum::class,
    ];

    protected $fillable = [
        'company_id',
        'shop_id',
        'name',
        'cnpj',
        'email',
        'address',
        'zip_code',
        'phone',
        'responsible',
        'responsible_phone',
        'segment',
        'type',
        'status',
    ];

    public function attendances()
    {
        return $this->hasMany(CrmAttendance::class);
    }

    public function getAttendances()
    {
        $attendances = CrmAttendance::where('crm_id', $this->id)->get();

        return $attendances;
    }
}
