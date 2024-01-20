<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Traits\TransactionFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    use TransactionFilter;
    public function index(Category $category)
    {
        $categories = auth()->user()->categories;
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        if (!$request->user()) {
            return redirect()->route('login.index');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense'
        ]);

        $category = $request->user()->categories()->create($validated);
        return redirect()->route('category.index')->with('success', 'Категория успешно создана!');
    }

    public function show(Category $category, Request $request)
    {
        $query = $category->transactions()->latest();

        $this->filterTransactions($query, $request);

        $transactions = $query->paginate(20);
        $totalAmount = $transactions->sum('amount');
        $transactionCount = $transactions->count();
        return view('category.show', compact('transactions', 'category', 'totalAmount', 'transactionCount'));
    }

    public function edit(Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            return redirect()->route('category.index')->with('error', 'Вы не можете редактировать эту категорию.');
        }
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
      $validated = $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|in:income,expense',
      ]);

      DB::transaction(function () use ($category, $validated) {
        $originalType = $category->getOriginal('type');

        $category->fill($validated);
        $typeChanged = $category->isDirty('type');
        
        if ($typeChanged) {
            $newType = $category->type;

            $transactions = Transaction::where('category_id', $category->id)->get();
            foreach ($transactions as $transaction) {
                if(($originalType == 'income' && $newType == 'expense') && $transaction->amount > 0) {
                    $transaction->amount *= -1;
                } elseif (($originalType == 'expense' && $newType == 'income') && $transaction->amount < 0) {
                    $transaction->amount *= -1;
                }
                $difference = $transaction->amount - $transaction->getOriginal('amount');
                $transaction->user->increment('balance', $difference);
                $transaction->save();
            }
        }
        $category->save();
    });


       return redirect()->route('category.index')->with('success', 'Категория успешно обновлена');
    }

    public function delete(Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            return redirect()->route('category.index')->with('error', 'Вы не можете удалить эту категорию.');
        }
        if(!$category) {
            return redirect()->route('category.index')->with('error', 'Не найдена данная категория');
        }
        $category->transactions()->delete();
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Категория успешно удалена');
    }

    public function limits()
    {
        $user = auth()->user();
        $categories = Category::where('user_id', $user->id)->where('type', 'expense')->get();
        return view('limits.index', compact('categories'));
    }

    public function UpdateLimits(Request $request, Category $category)
    {
        $request->validate([
            'limit' => 'required|numeric|min:0 ',
        ]);

        $category->update(['limit'=>$request->limit]);

        return redirect()->back()->with('success', 'Лимит успешно обновлен!');
    }
}
