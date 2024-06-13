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
                'role_name' => 'required|string|unique:roles'
            ], [
                'role_name.required' => 'Campo obrigatório',
                'role_name.unique' => 'Já existe um cargo com esse nome',
            ]);

            Role::create(['name' => $request->input('role_name')]);

            return redirect()->route('permissions.index')->with('success', 'Cargo criado com sucesso.');
        } catch (Exception $ex) {
            return redirect()->route('settings.index')->with('error', 'Ocorreu um erro ao criar o cargo: ' . $ex->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'role_id' => 'required|int',
                'role_name' => 'required|string'
            ], [
                'role_name.required' => 'Campo obrigatório',
            ]);

            Role::where('id', $request->input('role_id'))
                ->update([
                    'name' => $request->input('role_name'),
                ]);

            return redirect()->route('permissions.index')->with('success', 'Cargo editado com sucesso.');
        } catch (Exception $ex) {
            return redirect()->route('settings.index')->with('error', 'Ocorreu um erro ao editar o cargo: ' . $ex->getMessage());
        }
    }

    public function destroy($roleId)
    {
        try {
            User::where('role_id', $roleId)->update(['role_id' => null]);

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
