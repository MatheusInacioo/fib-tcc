<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Models\User;
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
            return redirect()->route('customers.index')->with('error', 'Ocorreu um erro ao cadastrar o cliente: ' . $ex->getMessage());
        }
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        try {
            $data = $request->getCustomerData();
            dd($data);
            $customer->update($data);

            return redirect()->route('customers.index')->with('create-success', 'Cliente atualizado com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('customers.index')->with('error', 'Ocorreu um erro ao autalizar os dados do cliente: ' . $ex->getMessage());
        }
    }

    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();

            return redirect()->route('customers.index')->with('destroy-success', 'Cliente excluído com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('customers.index')->with('error', 'Ocorreu um erro ao excluir o cliente: ' . $ex->getMessage());
        }
    }
}
