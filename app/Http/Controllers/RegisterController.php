<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index()
    {
        return view('home.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|string',
            'email' => 'required|email|unique:users|string|max:50',
            'password' => 'required|confirmed|min:8|string|max:50',
        ]);

        $user = User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        Auth::login($user);

        return view('home.success', compact('user'));
    }
}
