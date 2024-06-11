<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $columns;

    public function __construct()
    {
        $this->columns = array_diff(
            Schema::getColumnListing((new Product)->getTable()),
            ['description', 'additional_info', 'created_at', 'updated_at']
        );
    }

    public function collection()
    {
        return Product::select($this->columns)->get();
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
}
