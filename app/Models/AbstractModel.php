<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Session;

class AbstractModel extends Model
{
    public function scopeSession(Builder $query): void
    {
        Session::get('selected_shop_id') == null
            ? $query->where('company_id', Session::get('selected_company_id'))
            : $query->where('company_id', Session::get('selected_company_id'))
                    ->where('shop_id', Session::get('selected_shop_id'));
    }
}
