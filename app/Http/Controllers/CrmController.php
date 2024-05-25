<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrmRequest;
use App\Http\Resources\CrmResource;
use App\Models\Crm;
use App\Models\CrmAttendance;
use App\Models\Customer;
use App\Models\Supplier;
use Exception;
use Inertia\Inertia;

class CrmController extends Controller
{
    public function index()
    {
        $records = Crm::all();

        return Inertia::render('Crm/Index', [
            'crm' => $records,
        ]);
    }

    public function create()
    {
        return Inertia::render('Crm/CreateEdit', [
            'item' => CrmResource::make(new Crm),
        ]);
    }

    public function edit(Crm $crm)
    {
        return Inertia::render('Crm/CreateEdit', [
            'item' => CrmResource::make($crm),
        ]);
    }

    public function store(CrmRequest $request)
    {
        try {
            $crmData = $request->getCrmData();
            $attendanceData = $request->getAttendanceData();

            $crm = Crm::create($crmData);

            $attendanceData['crm_id'] = $crm->id;
            CrmAttendance::create($attendanceData);

            return redirect()->route('crm.index')->with('success', 'Cadastro realizado com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('crm.index')->with('error', 'Ocorreu um erro ao realizar o cadastro: ' . $ex->getMessage());
        }
    }

    public function update(CrmRequest $request, Crm $crm)
    {
        try {
            $crmData = $request->getCrmData();
            $attendanceData = $request->getAttendanceData();

            $crm->update($crmData);
            CrmAttendance::create($attendanceData);

            return redirect()->route('crm.index')->with('success', 'Cadastro atualizado com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('crm.index')->with('error', 'Ocorreu um erro ao autalizar o cadastro: ' . $ex->getMessage());
        }
    }

    public function destroy($crmId)
    {
        try {
            CrmAttendance::where('crm_id', $crmId)->delete();

            Crm::find($crmId)->delete();

            return redirect()->route('crm.index')->with('success', 'Cadastro excluído com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('crm.index')->with('error', 'Ocorreu um erro ao excluir o cadastro: ' . $ex->getMessage());
        }
    }

    public function closeContract(CrmRequest $request, Crm $crm)
    {
        try {
            $contract = $request->getCrmData();

            $contract['type'] == 'Cliente'
                ? Customer::create($contract)
                : Supplier::create($contract);

            CrmAttendance::where('crm_id', $crm->id)->delete();
            $crm->find($crm->id)->delete();

            return redirect()->route('crm.index')->with('success', 'Contrato fechado com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('crm.index')->with('error', 'Ocorreu um erro ao fechar o contrato: ' . $ex->getMessage());
        }
    }
}
