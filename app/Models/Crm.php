<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crm extends Model
{
    use HasFactory;

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
