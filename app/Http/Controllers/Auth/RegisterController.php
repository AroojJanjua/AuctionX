<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegistrationForm(){
        return view('pages.register');
    }
    // Handle registration form submission
    public function register(Request $request){
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email:rfc,dns|unique:users,email',            
            'phone'    => 'nullable|string|max:20',
            'role'     => 'required|in:bidder,seller',
            'password' => ['required', 'confirmed', Password::min(8)],
            'bio'      => 'nullable|string|max:500',
            'city'     => 'nullable|string|max:100',
            'country'  => 'nullable|string|max:100',
            'terms'    => 'accepted',
        ], [
            // Custom Error Messages
            'terms.accepted'     => 'You must accept the Terms of Service to register.',
            'email.unique'       => 'An account with this email already exists.',
            'email.dns'          => 'This email domain does not appear to accept mail. Please check for typos.',
            'password.confirmed' => 'The passwords you entered do not match.',
        ]);

        $user=User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
            'bio'      => $request->bio,
            'city'     => $request->city,
            'country'  => $request->country,
        ]);

        event(new Registered($user));
        Auth::login($user);
        return redirect()->route('verification.notice')
        ->with('success', 'Welcome to AuctionX! Please check your email to verify your account.');
}

}