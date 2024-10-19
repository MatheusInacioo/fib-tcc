<?php

namespace App\Models;

class Customer extends AbstractModel
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
