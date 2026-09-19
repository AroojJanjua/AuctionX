<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function notice(){
        if(Auth::user()->hasVerifiedEmail()){
            return $this->redirectVerified();
        }

        return view('pages.auth.verify-email');
    }

    public function verify(Request $request){
        $request->validate([
            'code' => 'required|digits:4',
        ]);

        $user=$request->user();

        if($user->hasVerifiedEmail()){
            return $this->redirectVerified();
        }

        if(! $user->checkEmailVerificationCode($request->code)){
            return back()->withErrors(['code' => 'That code is invalid or has expired. Please request a new one.']);
        }

        $user->markEmailAsVerified();

        return $this->redirectVerified()->with('success', 'Your email has been verified!');
    }

    public function resend(Request $request){
        if($request->user()->hasVerifiedEmail()){
            return $this->redirectVerified();
        }
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success','A new code has been sent! Please check your inbox.');
    }

    private function redirectVerified(){
        $user=Auth::user();
        if($user->role === 'seller'){
            return redirect()->route('seller.dashboard');
        }
        return redirect()->route('home');
    }
}