<?php

namespace App\Exports;

use App\Models\Customer;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $columns;

    public function __construct()
    {
        $this->columns = array_diff(
            Schema::getColumnListing((new Customer)->getTable()),
            [
                'shop_id',
                'company_id',
                'created_at', 
                'updated_at',
                'active',
            ]
        );
    }

    public function collection()
    {
        return Customer::session()->select($this->columns)->get();
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
