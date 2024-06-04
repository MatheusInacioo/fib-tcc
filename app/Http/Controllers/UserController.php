<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Exception;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('id', '<>', auth()->user()->id)->get();

        return Inertia::render('Users/Index', [
            'users' => UserResource::collection($users)->toArray(request()),
        ]);
    }

    public function create()
    {
        $roles = Role::select('id', 'name')->get();

        return Inertia::render('Users/CreateEdit', [
            'roles' => $roles,
        ]);
    }

    public function edit(User $user)
    {
        $roles = Role::select('id', 'name')->get();

        return Inertia::render('Users/CreateEdit', [
            'user' => UserResource::make($user),
            'roles' => $roles,
        ]);
    }

    public function store(UserRequest $request)
    {
        try {
            $data = $request->getUserData();

            User::create($data);

            return redirect()->route('users.index')->with('success', 'Usuário cadastrado com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('users.index')->with('error', 'Ocorreu um erro ao cadastrar o usuário: ' . $ex->getMessage());
        }
    }

    public function update(UserRequest $request, User $user)
    {
        try {
            $data = $request->getUserData();
            $data['password'] ?? $data['password'] = $user->password;

            $user->update($data);

            return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('users.index')->with('error', 'Ocorreu um erro ao autalizar os dados do usuário: ' . $ex->getMessage());
        }
    }

    public function destroy($userId)
    {
        try {
            User::find($userId)->delete();

            return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('users.index')->with('error', 'Ocorreu um erro ao excluir o usuário: ' . $ex->getMessage());
        }
    }
}
