<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Session;

class AbstractModel extends Model
{
    public function scopeSession(Builder $query): void
    {
        $query->where('company_id', Session::get('selected_company_id'))
                ->where('shop_id', Session::get('selected_shop_id'));
    }
}
