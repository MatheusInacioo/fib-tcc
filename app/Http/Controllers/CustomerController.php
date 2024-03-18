<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Exception;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        return Inertia::render('Customers/Index', [
            'customers' => $customers,
        ]);
    }

    public function create()
    {
        return Inertia::render('Customers/CreateEdit');
    }

    public function edit(Customer $customer)
    {
        return Inertia::render('Customers/CreateEdit', [
            'customer' => CustomerResource::make($customer),
        ]);
    }

    public function store(CustomerRequest $request)
    {
        try {
            $data = $request->getCustomerData();

            Customer::create($data);

            return redirect()->route('customers.index')->with('create-success', 'Cliente cadastrado com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('customers.index')->with('create-error', 'Ocorreu um erro ao cadastrar o cliente: ' . $ex->getMessage());
        }
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        try {
            $data = $request->getCustomerData();

            $customer->update($data);

            return redirect()->route('customers.index')->with('create-success', 'Cliente atualizado com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('customers.index')->with('update-error', 'Ocorreu um erro ao autalizar os dados do cliente: ' . $ex->getMessage());
        }
    }

    public function destroy($customerId)
    {
        try {
            Customer::find($customerId)->delete();

            return redirect()->route('customers.index')->with('destroy-success', 'Cliente excluído com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('customers.index')->with('destroy-error', 'Ocorreu um erro ao excluir o cliente: ' . $ex->getMessage());
        }
    }
}
