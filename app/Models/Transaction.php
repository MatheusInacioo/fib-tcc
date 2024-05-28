<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'type',
        'customer_id',
        'supplier_id',
        'product_id',
        'price',
        'total_amount',
        'status',
        'payment_method',
        'notes',
        'user_id',
    ];
}
