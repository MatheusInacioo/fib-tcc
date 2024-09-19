<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Exception;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::where('active', true)->get();

        return Inertia::render('Companies/Index', [
            'companies' => $companies,
        ]);
    }

    public function create()
    {
        return Inertia::render('Companies/CreateEdit');
    }

    public function edit(Company $company)
    {
        return Inertia::render('Companies/CreateEdit', [
            'company' => CompanyResource::make($company),
        ]);
    }

    public function store(CompanyRequest $request)
    {
        try {
            $data = $request->getCompanyData();

            Company::create($data);

            return redirect()->route('companies.index')->with('success', 'Empresa cadastrado com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('companies.index')->with('error', 'Ocorreu um erro ao cadastrar a empresa: ' . $ex->getMessage());
        }
    }

    public function update(CompanyRequest $request, Company $company)
    {
        try {
            $data = $request->getCompanyData();

            $company->update($data);

            return redirect()->route('companies.index')->with('success', 'Empresa atualizada com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('companies.index')->with('error', 'Ocorreu um erro ao autalizar os dados da empresa: ' . $ex->getMessage());
        }
    }

    public function destroy($companyId)
    {
        try {
            Company::find($companyId)->update(['active' => false]);

            return redirect()->route('companies.index')->with('success', 'Empresa excluída com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('companies.index')->with('error', 'Ocorreu um erro ao excluir a empresa: ' . $ex->getMessage());
        }
    }
}
