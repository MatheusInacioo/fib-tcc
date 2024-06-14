<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:roles'
            ], [
                'name.required' => 'Campo obrigatório',
                'name.unique' => 'Já existe um cargo com esse nome',
            ]);

            Role::create(['name' => $request->input('name')]);

            return redirect()->route('permissions.index')->with('success', 'Cargo criado com sucesso.');
        } catch (Exception $ex) {
            return redirect()->route('settings.index')->with('error', 'Ocorreu um erro ao criar o cargo: ' . $ex->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|int',
                'name' => 'required|string'
            ], [
                'name.required' => 'Campo obrigatório',
            ]);

            Role::where('id', $request->input('id'))
                ->update([
                    'name' => $request->input('name'),
                ]);

            return redirect()->route('permissions.index')->with('success', 'Cargo editado com sucesso.');
        } catch (Exception $ex) {
            return redirect()->route('settings.index')->with('error', 'Ocorreu um erro ao editar o cargo: ' . $ex->getMessage());
        }
    }

    public function destroy($roleId)
    {
        try {
            User::where('role_id', $roleId)->update(['id' => null]);

            DB::table('role_permission')
                ->where('role_id', $roleId)
                ->delete();

            Role::find($roleId)->delete();

            return redirect()->route('permissions.index')->with('success', 'Cargo excluído com sucesso.');
        } catch (Exception $ex) {
            return redirect()->route('settings.index')->with('error', 'Ocorreu um erro ao excluir o cargo: ' . $ex->getMessage());
        }
    }
}
