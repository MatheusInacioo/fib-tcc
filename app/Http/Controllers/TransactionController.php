<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();

        return Inertia::render('Transactions/Index', [
            'transactions' => $transactions,
        ]);
    }

    public function create()
    {
        return Inertia::render('Transactions/CreateEdit');
    }

    public function view(Transaction $transaction)
    {
        return Inertia::render('Transactions/CreateEdit', [
            'transaction' => TransactionResource::make($transaction),
        ]);
    }

    public function store(TransactionRequest $request)
    {
        try {
            $data = $request->getTransactionData();

            Transaction::create($data);

            return redirect()->route('transactions.index')->with('success', 'Transação criada com sucesso.');
        } catch (Exception $ex) {
            return redirect()->route('transactions.index')->with('error', 'Ocorreu um erro ao criar a transação: ' . $ex->getMessage());
        }
    }

    public function searchSuppliers(Request $request)
    {
        $search = $request->input('query');
        $suppliers = Supplier::where('name', 'like', '%' . $search . '%')
            ->orWhere('id', 'like', '%' . $search . '%')
            ->get();

        return response()->json($suppliers);
    }

    public function searchCustomers(Request $request)
    {
        $search = $request->input('query');
        $customers = Customer::where('name', 'like', '%' . $search . '%')
            ->orWhere('id', 'like', '%' . $search . '%')
            ->get();

        return response()->json($customers);
    }

    public function searchProducts(Request $request)
    {
        $search = $request->input('query');
        $products = Product::where('name', 'like', '%' . $search . '%')
            ->orWhere('id', 'like', '%' . $search . '%')
            ->get();

        return response()->json($products);
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
}
