<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function login(Request $request){
        $credentials = $request->only('nickname', 'password');

        if (Auth::attempt($credentials)) {

            if(Auth::user()->status == 'activo'){
                return Redirect()->intended('home');
            }

            Auth::logout();
            return redirect()->intended('/')->withErrors(['credentials' => [trans('auth.permisions')]])->withInput();

        }

        return redirect()->intended('/')->withErrors(['credentials' => [trans('auth.failed')]])->withInput();
    }

    function logout(){
        Auth::logout();
		return redirect('/');
    }
}
