<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrmAttendance extends Model
{
    use HasFactory;

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
