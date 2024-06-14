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
            ['description', 'supplier_id', 'additional_info', 'created_at', 'updated_at']
        );
    }

    public function collection()
    {
        $columns = array_map(function ($column) {
            return 'products.' . $column;
        }, $this->columns);

        $columns[] = 'suppliers.name as supplier_name';

        return Product::select($columns)
            ->join('suppliers', 'products.supplier_id', '=', 'suppliers.id')
            ->get();
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
