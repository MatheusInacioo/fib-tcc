<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Session;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'company_id',
        'shop_id',
        'active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function scopeSession(Builder $query): void
    {
        $query->where('company_id', Session::get('selected_company_id'))
                ->where('shop_id', Session::get('selected_shop_id'));
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function getRoleName()
    {
        $roleName = Role::where('id', $this->role_id)->value('name');

        return $roleName;
    }

    public function getCompanyName()
    {
        $companyName = Company::where('id', $this->company_id)->value('name');

        return $companyName;
    }

    public function getShopName()
    {
        $shopName = Shop::where('id', $this->shop_id)->value('name');

        return $shopName;
    }

    public function hasPermission($permission)
    {
        if ($this->role) {
            return $this->role->permissions->contains('name', $permission);
        }

        return false;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token, $this->email));
    }
}
