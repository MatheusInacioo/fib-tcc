<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function index () {
        if(Auth::check()) {
            return redirect()->route('dashboard.index');
        }

        return Inertia::render('Auth/Login');
    }

    public function store (LoginRequest $request) {
        $data = $request->getLoginData();

        $authenticated = Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ], $data['remember']);

        if(! $authenticated) {
            return redirect()->route('login')->withErrors(['error' => 'Email ou senha inválidos']);
        }

        return redirect()->route('dashboard.index');
    }

    public function destroy () {
        Auth::logout();

        return redirect()->route('login');
    }
}
