<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class UserIntroController extends Controller
{

    public function update(Request $request)
    {   
        $user = Auth::user();
        $user->has_seen_intro = true;
        $user->save();

        return response()->json(['success' => 'User has seen intro']);
    }
    public function completeTutorial(Request $request, $id)
    {
    dd($request);
    $user = User::find($id);
    dd($user);
    if (!$user) {
        return response()->json(['error' => 'User not authenticated'], 401); 
    }
    $user->has_seen_intro = $request->has_seen_intro;
    $user->save();

    return response()->json(['message' => 'Tutorial status updated successfully.']);
    }
}
