<?php

namespace App\Models;

use App\Enums\ExpensePendingStatusEnum;

class Expense extends AbstractModel
{
    protected $table = 'expenses';

    protected $casts = [
        'pending' => ExpensePendingStatusEnum::class,
    ];

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
