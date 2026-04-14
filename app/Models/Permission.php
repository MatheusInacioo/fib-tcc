<?php

namespace App\Models;

use App\Enums\ActivationStatusEnum;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $casts = [
        'active' => ActivationStatusEnum::class,
    ];

    protected $fillable = ['name', 'active'];
}
