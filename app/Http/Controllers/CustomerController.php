<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Exception;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::session()->where('active', true)->get();

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

            return redirect()->route('customers.index')->with('success', 'Cliente cadastrado com sucesso.');
        } catch (Exception $ex) {
            return redirect()->route('customers.index')->with('error', 'Ocorreu um erro ao cadastrar o cliente: ' . $ex->getMessage());
        }
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        try {
            $data = $request->getCustomerData();

            $customer->update($data);

            return redirect()->route('customers.index')->with('success', 'Cliente atualizado com sucesso.');
        } catch (Exception $ex) {
            return redirect()->route('customers.index')->with('error', 'Ocorreu um erro ao autalizar os dados do cliente: ' . $ex->getMessage());
        }
    }

    public function destroy($customerId)
    {
        try {
            Customer::find($customerId)->update(['active' => false]);

            return redirect()->route('customers.index')->with('success', 'Cliente excluído com sucesso.');
        } catch (Exception $ex) {
            return redirect()->route('customers.index')->with('error', 'Ocorreu um erro ao excluir o cliente: ' . $ex->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new CustomersExport, 'clientes.xlsx');
    }

    public function fetch()
    {
        $url = 'https://tcc-abcwcefdhghvcjdq.brazilsouth-01.azurewebsites.net/api/Category/GetAll';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Erro na requisição: ' . curl_error($ch);
        } else {
            $formattedData = [];
            $apiResponse = json_decode($response, true);

            foreach ($apiResponse as $key => $data) {
                $formattedData[] = [
                    'id' => $key + 1,
                    'uuid' => $data['id'],
                    'desc' => $data['description'],
                    'act' => $data['active']
                ];
            }
            curl_close($ch);

            return $formattedData;
        }
    }
}
