<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    public function index()
    {
        $goals = Goal::where('user_id', auth()->id())->get();
        return view('goals.index', compact('goals'));
    }

    public function create()
    {
        return view('goals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'total_amount' => 'required|numeric|min:1',
            'current_amount' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'deadline' => 'nullable|date|after:today',
        ]);

        if($request->hasFile('image')) {
            $path = $request->file('image')->store('goals', 'public');
            $validated['image']=$path;
        }

        $validated['user_id'] = auth()->id();
        $goal = Goal::create($validated);

        return redirect()->route('goals.index')->with('success', 'Ура, эта цель успешно добавлена');
    }

    public function edit($id)
    {
        $goal = Goal::find($id);
        return view('goals.edit', compact('goal'));
    }

    public function update(Request $request, $id) 
    {
        $goal = Goal::find($id);
        $goal->update($request->all());
        return redirect()->route('goals.index');
    }

    public function delete($id)
    {
        $goal = Goal::find($id);
        $goal->delete();
        return redirect()->route('goals.index');
    }

    public function add($id)
    {
        $goal = Goal::find($id);
        return view('goals.add', compact('goal'));
    }

    public function addBalance($id, Request $request)
    {
        $goal = Goal::find($id);
        $pastAmount = $goal->current_amount;
        $addAmount = $request['amount'];
        $newAmount = $pastAmount + $addAmount;
        
        $goal->update(['current_amount' => $newAmount]);
        return redirect()->route('goals.index');
    }
}
