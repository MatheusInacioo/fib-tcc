<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $columns;

    public function __construct(array $columns)
    {
        $this->columns = $columns;
    }

    public function collection()
    {
        $columnNames = array_column($this->columns, 'name');
        
        return Customer::select($columnNames)->get();
    }

    public function headings(): array
    {
        return array_column($this->columns, 'label');
    }
}
