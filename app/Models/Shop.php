<?php

namespace App\Models;

use App\Models\Scopes\SessionScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = 'shops';

    protected $fillable = [
        'name',
        'company_id',
        'location',
        'active',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getCompanyName()
    {
        $companyName = Company::where('id', $this->company_id)->value('name');

        return $companyName;
    }
}
