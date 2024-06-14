<?php

namespace App\Exports;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    protected $columns;

    public function __construct()
    {
        $this->columns = array_diff(
            Schema::getColumnListing((new Transaction)->getTable()),
            [
                'customer_id', 
                'product_id', 
                'supplier_id', 
                'user_id', 
                'updated_at',
                'notes'
            ]
        );
    }

    public function collection()
    {
        $columns = array_map(function ($column) {
            return 'transactions.' . $column;
        }, $this->columns);

        $columns[] = 'customers.name as customer_name';
        $columns[] = 'suppliers.name as supplier_name';
        $columns[] = 'products.name as product_name';
        $columns[] = 'users.name as user_name';

        return Transaction::select($columns)
            ->join('customers', 'transactions.customer_id', '=', 'customers.id')
            ->join('suppliers', 'transactions.supplier_id', '=', 'suppliers.id')
            ->join('products', 'transactions.product_id', '=', 'products.id')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tipo',
            'Cliente',
            'Fornecedor',
            'Produto',
            'Quantidade',
            'Preço',
            'Valor total',
            'Pagamento',
            'Usuário',
            'Data',
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->id,
            $transaction->type == 0 ? 'Compra' : 'Venda',
            $transaction->customer_name,
            $transaction->supplier_name,
            $transaction->product_name,
            $transaction->quantity,
            $transaction->price,
            $transaction->total_amount,
            $transaction->user_name,
            Carbon::parse($transaction->created_at)->format('d/m/Y'),
        ];
    }
}
