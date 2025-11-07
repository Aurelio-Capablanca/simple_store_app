<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    public function login(Request $req) : RedirectResponse{
        $user = User::where('email',$req->email)->first();
        if (!$user || !Hash::check($req->password, $user->password)){
            return redirect()->back()->with('error', 'Invalid Credentials');
        }
        Auth::login($user);
        $req->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    
}
