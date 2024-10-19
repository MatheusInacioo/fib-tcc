<?php

namespace App\Models;

class Crm extends AbstractModel
{
    protected $table = 'crm_data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
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
