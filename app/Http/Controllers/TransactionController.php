<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Exception;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function index() {
        $transactions = Transaction::all();

        return Inertia::render('Transactions/Index', [
            'transactions' => $transactions,
        ]);
    }

    public function create() {
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
        } catch(Exception $ex) {
            return redirect()->route('transactions.index')->with('error', 'Ocorreu um erro ao criar a transação: ' . $ex->getMessage());
        }
    }

    public function destroy($transactionId)
    {
        try {
            Transaction::find($transactionId)->delete();

            return redirect()->route('transactions.index')->with('success', 'Transação excluída com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('transactions.index')->with('error', 'Ocorreu um erro ao excluir a transação: ' . $ex->getMessage());
        }
    }
}
