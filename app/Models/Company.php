<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';

    protected $fillable = [
        'name',
        'corporate_name',
        'active',
    ];

    public function shops()
    {
        return $this->hasMany(Shop::class);
    }
}
