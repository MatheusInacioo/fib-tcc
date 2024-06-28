<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;
use App\Models\User;
use Inertia\Inertia;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return Inertia::render('Auth/Recover');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|exists:users,email',
            ], [
                'email.required' => 'Campo obrigatório',
                'email.exists' => 'E-mail não cadastrado',
            ]);

        $user = User::where('email', $request->email)->first();

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            $token = Password::createToken($user());

            Mail::to($request->email)->send(new PasswordResetMail($token, $request->email));

            return back()->with(['status' => __($status)]);
        } else {
            return back()->withErrors(['email' => __($status)]);
        }
    }
}
