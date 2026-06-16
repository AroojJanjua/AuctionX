<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(){
        return view('pages.login');
    }
     public function login(Request $request){
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

         // Check if user is banned
        $user = User::where('email', $request->email)->first();

        if ($user && $user->is_banned){
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Your account has been suspended. Please contact support.']);
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
 
            // Redirect based on role
            return redirect()->route('home')->with('success', 'You have been logged in.');
        }

        return back()->withInput($request->only('email'))
            ->withErrors(['email' => 'The email or password you entered is incorrect.']);
    }

    // Logout
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
 
        return redirect()->route('home')->with('success', 'You have been signed out.');
    }

    // Redirect to the correct dashboard based on user role
    public function redirectBasedOnRole()
    {
        $role = auth()->user()->role;
 
        return match ($role) {
            'admin'  => redirect()->route('admin.dashboard'),
            'seller' => redirect()->route('seller.dashboard'),
            default  => redirect()->route('home'),
        };
    }
}
