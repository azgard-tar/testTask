<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('employees');
        }
        else if( is_null($request->email)){
            return view("login/auth");
        }
        else
            return view("login/auth",["error" => "Email or password is incorrect"]);
    }
    public function login(){
        if( Auth::check() )
            return redirect()->route('employees');
        else
            return view('login/auth');
    }
    public function logout(){
        Auth::logout();
        return view("login/auth");
    }
}
