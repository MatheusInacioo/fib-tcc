<?php

namespace App\Exports;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Number;
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
            ->leftJoin('customers', 'transactions.customer_id', '=', 'customers.id')
            ->leftJoin('suppliers', 'transactions.supplier_id', '=', 'suppliers.id')
            ->leftJoin('products', 'transactions.product_id', '=', 'products.id')
            ->leftJoin('users', 'transactions.user_id', '=', 'users.id')
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
            Number::currency($transaction->price, 'BRL'),
            Number::currency($transaction->total_amount, 'BRL'),
            $transaction->payment_method,
            $transaction->user_name,
            Carbon::parse($transaction->created_at)->format('d/m/Y'),
        ];
    }
}
