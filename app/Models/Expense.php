<?php

namespace App\Models;

class Expense extends AbstractModel
{
    protected $table = 'expenses';
    
    protected $fillable = [
        'company_id',
        'shop_id',
        'description',
        'amount',
        'payment_method',
        'recurrence',
        'department',
        'attachment',
        'pending',
        'notes',
        'created_by',
    ];
}
