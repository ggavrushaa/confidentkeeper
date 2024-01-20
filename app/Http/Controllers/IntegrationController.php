<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IntegrationController extends Controller
{
    public function index()
    {
        return view('integrations.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'bank_api_key' => 'required|string|max:255'
        ]);

        auth()->user()->update([
            'bank_api_key' => encrypt($request->bank_api_key), 
        ]);

        return redirect()->route('integrations.index')->with('success', 'Я получил API твоего банка, теперь ты можешь отслеживать выписки из банка во вкладке "Банк"');
    }
}
