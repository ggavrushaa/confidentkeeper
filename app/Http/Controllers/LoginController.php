<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('home.login');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]))  {
            return redirect()->intended('/');
        }

        return back()->with('error', 'Неправильные учетные данные');
    }
}
