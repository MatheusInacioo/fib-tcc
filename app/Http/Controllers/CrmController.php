<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrmRequest;
use App\Models\Crm;
use App\Models\CrmAttendance;
use Exception;
use Inertia\Inertia;

class CrmController extends Controller
{
    public function index()
    {
        $records = Crm::all();

        foreach($records as $record) {
            $attendances = CrmAttendance::where('crm_id', $record->id)->get();

            $record['attendances'] = $attendances;
        }

        return Inertia::render('Crm/Index', [
            'crm' => $records,
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

            return redirect()->route('crm.index')->with('create-success', 'Cadastro realizado com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('crm.index')->with('create-error', 'Ocorreu um erro ao realizar o cadastro: ' . $ex->getMessage());
        }
    }

    public function update(CrmRequest $request, Crm $crm)
    {
        try {
            $crmData = $request->getCrmData();
            $attendanceData = $request->getAttendanceData();

            $crm->update($crmData);
            CrmAttendance::create($attendanceData);

            return redirect()->route('crm.index')->with('create-success', 'Cadastro atualizado com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('crm.index')->with('update-error', 'Ocorreu um erro ao autalizar o cadastro: ' . $ex->getMessage());
        }
    }

    public function destroy($crmId)
    {
        try {
            CrmAttendance::where('crm_id', $crmId)->delete();

            Crm::find($crmId)->delete();

            return redirect()->route('crm.index')->with('destroy-success', 'Cadastro excluído com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('crm.index')->with('destroy-error', 'Ocorreu um erro ao excluir o cadastro: ' . $ex->getMessage());
        }
    }
}
