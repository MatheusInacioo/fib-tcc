<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use Exception;
use Inertia\Inertia;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();

        return Inertia::render('Suppliers/Index', [
            'suppliers' => $suppliers,
        ]);
    }

    public function create()
    {
        return Inertia::render('Suppliers/CreateEdit');
    }

    public function edit(Supplier $supplier)
    {
        return Inertia::render('Suppliers/CreateEdit', [
            'supplier' => SupplierResource::make($supplier),
        ]);
    }

    public function store(SupplierRequest $request)
    {
        try {
            $data = $request->getSupplierData();

            Supplier::create($data);

            return redirect()->route('suppliers.index')->with('create-success', 'Fornecedor cadastrado com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('suppliers.index')->with('create-error', 'Ocorreu um erro ao cadastrar o fornecedor: ' . $ex->getMessage());
        }
    }

    public function update(SupplierRequest $request, Supplier $supplier)
    {
        try {
            $data = $request->getSupplierData();

            $supplier->update($data);

            return redirect()->route('suppliers.index')->with('create-success', 'Fornecedor atualizado com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('suppliers.index')->with('update-error', 'Ocorreu um erro ao autalizar os dados do fornecedor: ' . $ex->getMessage());
        }
    }

    public function destroy($supplierId)
    {
        try {
            Supplier::find($supplierId)->delete();

            return redirect()->route('suppliers.index')->with('destroy-success', 'Fornecedor excluído com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('suppliers.index')->with('destroy-error', 'Ocorreu um erro ao excluir o fornecedor: ' . $ex->getMessage());
        }
    }
}
