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
            return view("auth");
        }
        else
            return view("auth",["error" => "Email or password is incorrect"]);
    }
    public function logout(){
        Auth::logout();
        return view("auth");
    }
}
