<?php

namespace App\Http\Controllers;

use App\Enums\ActivationStatusEnum;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Models\Shop;
use Exception;
use Inertia\Inertia;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::where('active', ActivationStatusEnum::ACTIVE)->get();

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
        $shops = Shop::where('company_id', $company->id)
            ->where('active', ActivationStatusEnum::ACTIVE)
            ->get();

        return Inertia::render('Companies/CreateEdit', [
            'company' => CompanyResource::make($company),
            'shops' => $shops,
        ]);
    }

    public function store(CompanyRequest $request)
    {
        try {
            $data = $request->getCompanyData();

            Company::create($data);

            return redirect()->route('companies.index')->with('success', 'Empresa cadastrada com sucesso.');
        } catch (Exception $ex) {
            return redirect()->route('companies.index')->with('error', 'Ocorreu um erro ao cadastrar a empresa: '.$ex->getMessage());
        }
    }

    public function update(CompanyRequest $request, Company $company)
    {
        try {
            $data = $request->getCompanyData();

            $company->update($data);

            return redirect()->route('companies.index')->with('success', 'Empresa atualizada com sucesso.');
        } catch (Exception $ex) {
            return redirect()->route('companies.index')->with('error', 'Ocorreu um erro ao autalizar os dados da empresa: '.$ex->getMessage());
        }
    }

    public function destroy($companyId)
    {
        try {
            Shop::where('company_id', $companyId)->update(['active' => ActivationStatusEnum::INACTIVE]);
            Company::find($companyId)->update(['active' => ActivationStatusEnum::INACTIVE]);

            return redirect()->route('companies.index')->with('success', 'Empresa excluída com sucesso.');
        } catch (Exception $ex) {
            return redirect()->route('companies.index')->with('error', 'Ocorreu um erro ao excluir a empresa: '.$ex->getMessage());
        }
    }

    public function list()
    {
        try {
            $companies = Company::where('active', ActivationStatusEnum::ACTIVE)
                ->with([
                    'shops' => function ($query) {
                        $query->where('active', ActivationStatusEnum::ACTIVE);
                    },
                ])
                ->get();

            $data = $companies->map(function ($company) {
                return [
                    'id' => $company->id,
                    'name' => $company->name,
                    'corporate_name' => $company->corporate_name,
                    'shops' => $company->shops->map(function ($shop) {
                        return [
                            'id' => $shop->id,
                            'name' => $shop->name,
                        ];
                    })->toArray(),
                ];
            })->toArray();

            return $data;
        } catch (Exception $ex) {
            throw new InternalErrorException('Erro ao listar empresas: '.$ex->getMessage());
        }
    }
}
