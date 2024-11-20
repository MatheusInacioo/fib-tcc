<?php

namespace App\Exports;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    protected $columns;

    public function __construct()
    {
        $this->columns = array_diff(
            Schema::getColumnListing((new Product)->getTable()),
            [
                'shop_id',
                'company_id',
                'description', 
                'supplier_id', 
                'additional_info', 
                'created_at', 
                'updated_at',
                'active'
            ]
        );
    }

    public function collection()
    {
        $columns = array_map(function ($column) {
            return 'products.' . $column;
        }, $this->columns);

        $columns[] = 'suppliers.name as supplier_name';

        $query = Product::select($columns)->where('products.company_id', session()->get('selected_company_id'));

        if (session()->get('selected_shop_id') != null) {
            $query->where('products.shop_id', session()->get('selected_shop_id'));
        }

        $query->join('suppliers', 'products.supplier_id', '=', 'suppliers.id');
        
        return $query->orderBy('id')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nome',
            'SKU',
            'Marca',
            'Fornecedor',
            'Preço compra',
            'Preço venda',
            'Qtd em estoque',
            'Qtd mínima',
            'Localização',
            'Validade',
        ];
    }

    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            $product->sku,
            $product->brand,
            $product->supplier_name,
            $product->purchase_price,
            $product->sale_price,
            $product->total_amount,
            $product->minimum_amount,
            $product->storage_location,
            Carbon::parse($product->expiry_date)->format('d/m/Y'),
        ];
    }
}
