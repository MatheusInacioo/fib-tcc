<?php

namespace App\Models;

class CrmAttendance extends AbstractModel
{
    protected $table = 'crm_attendances';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'crm_id',
        'description',
        'user',
    ];

    public function crm()
    {
        return $this->belongsTo(Crm::class);
    }
}
