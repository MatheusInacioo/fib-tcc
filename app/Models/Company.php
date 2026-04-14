<?php

namespace App\Models;

use App\Enums\ActivationStatusEnum;

class Company extends AbstractModel
{
    protected $table = 'companies';

    protected $casts = [
        'active' => ActivationStatusEnum::class,
    ];

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
