<?php

namespace App\Models;

use App\Enums\ActivationStatusEnum;

class Supplier extends AbstractModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $casts = [
        'active' => ActivationStatusEnum::class,
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
        'active',
    ];
}
