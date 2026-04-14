<?php

namespace App\Models;

use App\Enums\ActivationStatusEnum;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $casts = [
        'active' => ActivationStatusEnum::class,
    ];

    protected $fillable = ['name', 'active'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }
}
