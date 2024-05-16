<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'sku',
        'brand',
        'supplier_id',
        'purchase_price',
        'sale_price',
        'total_amount',
        'minimum_amount',
        'storage_location',
        'expiry_date',
        'description',
        'additional_info',
    ];

    public function supplier() 
    {
        return $this->belongsTo(Supplier::class);
    }
}
