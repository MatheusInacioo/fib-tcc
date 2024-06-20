<?php

namespace App\Http\Controllers;

use App\Exports\TransactionExport;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    public function index()
    {
        return Inertia::render('Transactions/Index', [
            'transactions' => TransactionResource::collection(Transaction::all())->toArray(request()),
        ]);
    }

    public function create()
    {
        return Inertia::render('Transactions/CreateEdit');
    }

    public function view($transactionId)
    {
        $transaction = Transaction::find($transactionId);

        return Inertia::render('Transactions/CreateEdit', [
            'transaction' => TransactionResource::make($transaction),
        ]);
    }

    public function store(TransactionRequest $request)
    {
        try {
            $data = $request->getTransactionData();

            Transaction::create($data);

            $this->updateProductData($data);

            return redirect()->route('transactions.index')->with('success', 'Transação criada com sucesso.');
        } catch (Exception $ex) {
            return redirect()->route('transactions.index')->with('error', 'Ocorreu um erro ao criar a transação: ' . $ex->getMessage());
        }
    }

    public function searchSuppliers($search)
    {
        $suppliers = Supplier::where('name', 'like', '%' . $search . '%')
            ->orWhere('id', 'like', '%' . $search . '%')
            ->get();

        return $suppliers;
    }

    public function searchCustomers($search)
    {
        $customers = Customer::where('name', 'like', '%' . $search . '%')
            ->orWhere('id', 'like', '%' . $search . '%')
            ->get();

        return $customers;
    }

    public function searchProducts(Request $request)
    {
        $query = Product::query();

        if ($request['supplier_id']) {
            $query->where('supplier_id', $request['supplier_id'])
                ->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request['search'] . '%')
                        ->orWhere('id', 'like', '%' . $request['search'] . '%');
                });
        } else {
            $query->whereDate('expiry_date', '>=', now())
                ->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request['search'] . '%')
                        ->orWhere('id', 'like', '%' . $request['search'] . '%');
                });
        }

        $products = $query->get();

        return $products;
    }

    public function destroy($transactionId)
    {
        try {
            Transaction::find($transactionId)->delete();

            return redirect()->route('transactions.index')->with('success', 'Transação excluída com sucesso.');
        } catch (Exception $ex) {
            return redirect()->route('transactions.index')->with('error', 'Ocorreu um erro ao excluir a transação: ' . $ex->getMessage());
        }
    }

    private function updateProductData($data)
    {
        $product = Product::find($data['product_id']);

        $data['type'] == 0
            ? $newQuantity = $product->total_amount + $data['quantity']
            : $newQuantity = $product->total_amount - $data['quantity'];

        if ($data['expiry_date']) {
            return $product->update([
                'total_amount' => $newQuantity,
                'expiry_date' => $data['expiry_date'],
            ]);
        }

        return $product->update(['total_amount' => $newQuantity]);
    }

    public function export()
    {
        return Excel::download(new TransactionExport, 'transacoes.xlsx');
    }
}
