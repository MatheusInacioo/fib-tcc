<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrmRequest;
use App\Http\Resources\CrmResource;
use App\Models\Crm;
use Exception;
use Inertia\Inertia;

class CrmController extends Controller
{
    public function index()
    {
        // $data = Crm::all();

        return Inertia::render('Crm/Index', [
            'crmData' => '',
        ]);
    }

    public function create()
    {
        return Inertia::render('Crm/CreateEdit');
    }

    public function edit(Crm $Crm)
    {
        return Inertia::render('Crm/CreateEdit', [
            'crmData' => CrmResource::make($Crm),
        ]);
    }

    public function store(CrmRequest $request)
    {
        try {
            $data = $request->getCrmData();

            Crm::create($data);

            return redirect()->route('crm.index')->with('create-success', 'Cadastro realizado com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('crm.index')->with('create-error', 'Ocorreu um erro ao realizar o cadastro: ' . $ex->getMessage());
        }
    }

    public function update(CrmRequest $request, Crm $crm)
    {
        try {
            $data = $request->getCrmData();

            $crm->update($data);

            return redirect()->route('crm.index')->with('create-success', 'Cadastro atualizado com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('crm.index')->with('update-error', 'Ocorreu um erro ao autalizar o cadastro: ' . $ex->getMessage());
        }
    }

    public function destroy($crmId)
    {
        try {
            Crm::find($crmId)->delete();

            return redirect()->route('crm.index')->with('destroy-success', 'Cadastro excluído com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('crm.index')->with('destroy-error', 'Ocorreu um erro ao excluir o cadastro: ' . $ex->getMessage());
        }
    }
}
