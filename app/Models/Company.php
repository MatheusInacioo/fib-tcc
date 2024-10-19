<?php

namespace App\Models;

class Company extends AbstractModel
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
