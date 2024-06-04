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
        'quantity',
        'price',
        'total_amount',
        'payment_method',
        'notes',
        'user_id',
    ];

    public function getSupplierName()
    {
        $supplierName = Supplier::where('id', $this->supplier_id)->value('name');

        return $supplierName;
    }

    public function getCustomerName()
    {
        $customerName = Customer::where('id', $this->customer_id)->value('name');

        return $customerName;
    }

    public function getProductName()
    {
        $productName = Product::where('id', $this->product_id)->value('name');

        return $productName;
    }

    public function getUserName()
    {
        $userName = User::where('id', $this->user_id)->value('name');

        return $userName;
    }
}
