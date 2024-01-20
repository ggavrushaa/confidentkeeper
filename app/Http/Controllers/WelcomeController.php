<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index(User $user)
    {
        $user = Auth::user();
        if(!$user) {
            return redirect()->route('login.index');
        }
        
        return view('home.success', compact('user'));
    }
}
