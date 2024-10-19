<?php

namespace App\Models;

class Transaction extends AbstractModel
{
    protected $table = 'transactions';

    protected $fillable = [
        'company_id',
        'shop_id',
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
