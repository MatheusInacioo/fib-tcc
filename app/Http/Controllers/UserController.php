<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('id', '<>', auth()->user()->id)->get();

        return Inertia::render('Users/Index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        return Inertia::render('Users/CreateEdit');
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/CreateEdit', [
            'user' => UserResource::make($user),
        ]);
    }

    public function store(UserRequest $request)
    {
        try {
            $data = $request->getUserData();

            User::create($data);

            return redirect()->route('users.index')->with('create-success', 'Usuário cadastrado com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('users.index')->with('create-error', 'Ocorreu um erro ao cadastrar o usuário: ' . $ex->getMessage());
        }
    }

    public function update(UserRequest $request, User $user)
    {
        try {
            $data = $request->getUserData();

            $user->update($data);

            return redirect()->route('users.index')->with('create-success', 'Usuário atualizado com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('users.index')->with('update-error', 'Ocorreu um erro ao autalizar os dados do usuário: ' . $ex->getMessage());
        }
    }

    public function destroy($userId)
    {
        try {
            User::find($userId)->delete();

            return redirect()->route('users.index')->with('destroy-success', 'Usuário excluído com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('users.index')->with('destroy-error', 'Ocorreu um erro ao excluir o usuário: ' . $ex->getMessage());
        }
    }
}
