<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show(){
        $user=auth()->user()->load('bids.auction')->loadCount(['bids','auctions']);
        return view('pages.profile.show',compact('user'));
    }

    public function edit(){
        return view('pages.profile.edit',['user' => auth()->user()]);
    }

    // Update profile personal information
    public function update(Request $request){
        $user=auth()->user();
        $validated=$request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'phone'   => 'nullable|string|max:20',
            'city'    => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'bio'     => 'nullable|string|max:500',
            'payout_method'         => 'nullable|in:jazzcash,easypaisa',
            'payout_account_number' => 'nullable|string|max:30|required_with:payout_method',
            'payout_account_name'   => 'nullable|string|max:100|required_with:payout_method',
        ]);
        $user->update($validated);
        return back()->with('success','Profile updated successfully.');
    }

    // Update password
    public function updatePassword(Request $request){
        $user=auth()->user();
        $request->validate([
            'current_password'=> 'required',
            'password' => ['required','confirmed',Password::min(8)],
        ]); 
        if(!Hash::check($request->current_password, $user->password)){
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        return back()->with('success','Password updated successfully.');
    }


}
