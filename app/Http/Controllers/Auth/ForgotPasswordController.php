<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function show(){
        return view('pages.auth.forgot-password');
    }

    public function send(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ],[
            'email.exists' => 'No account found with that email address.',
        ]);

        $status=Password::sendResetLink(['email' => $request->email]);

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success','Password reset link sent!')
            : back()->withErrors(['email' => __($status)]);
    }
}