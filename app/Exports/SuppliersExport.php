<?php

namespace App\Exports;

use App\Models\Supplier;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SuppliersExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $columns;

    public function __construct()
    {
        $this->columns = array_diff(
            Schema::getColumnListing((new Supplier)->getTable()),
            ['created_at', 'updated_at']
        );
    }

    public function collection()
    {
        return Supplier::select($this->columns)->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nome',
            'CNPJ',
            'Email',
            'Telefone',
            'Endereço',
            'CEP',
            'Responsável',
            'Telefone responsável',
            'Segmento',
        ];
    }
}
