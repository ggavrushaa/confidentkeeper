<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Currency;
use App\Models\Transaction;
use App\Traits\TransactionFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Notifications\LimitWarning;

class TransactionController extends Controller
{
    use TransactionFilter;
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = $user->transactions()->latest();

       $query=$this->filterTransactions($query, $request);
  
        $transactions = $query->paginate(20);
        $transactionCount = $transactions->total();
      
        return view('transaction.index', compact('transactions', 'transactionCount'));
    }

    public function create(Category $category)
    {
        $categories = auth()->user()->categories;
        $currencies = Currency::all();
        return view('transaction.create', compact('categories', 'currencies'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|between:0,9999999999.99',
            'date' => 'nullable|date_format:Y-m-d|before_or_equal:today',
            'category_id' => 'required|integer|exists:categories,id',
            'comment' => 'nullable|string',
            'receipt_image' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp,heic|max:2048',
            'currency_id' => 'required|integer|exists:currencies,id',
        ]);

        $categoryType = Category::find($data['category_id'])->type;
        if($categoryType == 'expense') {
            $data['amount'] = -$data['amount'];
        }
    
        if(empty($data['date'])) {
            $data['date'] = now();
        }

        if($request->hasFile('receipt_image')) {
            $imageName = time() . '.' . $request->receipt_image->extension();
            $request->receipt_image->move(public_path('receipts'), $imageName);
            $data['receipt_image'] = 'receipts/' . $imageName;
        }

        $transaction = auth()->user()->transactions()->create($data);
        
        $user = auth()->user();
        $user->balance += $transaction->amount;
        $user->save();

        $this->checkCategoryLimits();

        return redirect()->route('transaction.index')->with('success', 'Транзакция успешно добавлена');
    }

    public function show(Transaction $transaction)
    {
        
    }

    public function edit(Transaction $transaction, Category $categories)
    {
        $categories = auth()->user()->categories;
        return view('transaction.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'amount' => 'nullable|numeric|between:0,9999999999.99',
            'date' => 'nullable|date_format:Y-m-d\TH:i:s',
            'category' => 'required|integer|exists:categories,id',
            'comment' => 'nullable|string', 
            'receipt_image' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp,heic|max:2048'
          ]);


          $oldCategoryType = $transaction->category->type;
          $newCategoryType = Category::find($validated['category'])->type;
          $oldAmount = $transaction->amount;
    
          $transaction->name = $validated['name'] ?? $transaction->name;
         
          if(isset($validated['amount'])) {
            $amount = $validated['amount'];
            if($transaction->category->type == 'expense') {
                $amount = -$amount;
            }
            $transaction->amount = $amount;
          }

          $transaction->created_at = $validated['date'] ?? $transaction->created_at;
          $transaction->category_id = $validated['category'];
          $transaction->comment = $validated['comment'] ?? $transaction->comment;

          if ($oldCategoryType != $newCategoryType) {
            if ($newCategoryType == 'expense') {
                $transaction->amount = -$validated['amount'];
            } else {
                $transaction->amount = abs($validated['amount']);
            }
        }

        if($request->hasFile('receipt_image')) {
            if($transaction->receipt_image && file_exists(public_path($transaction->receipt_image))) {
                unlink(public_path($transaction->receipt_image));
            }

            $imageName = time() . '.' . $request->receipt_image->extension();
            $request->receipt_image->move(public_path('receipts'), $imageName);
            $transaction->receipt_image = 'receipts/' . $imageName;
        }

        $transaction->save();

        $difference = $transaction->amount - $oldAmount;
        $transaction->user->balance += $difference;
        $transaction->user->save();

        $this->checkCategoryLimits();
          
        return redirect()->route('transaction.index')->with('success', 'Транзакция успешно обновлена');
    }

    public function delete(Transaction $transaction)
    {
        if($transaction->user_id !== auth()->id()) {
            return redirect()->route('transaction.index')->with('error', 'Нет прав на удаление этой транзакции');
        }

        $user = auth()->user();
        if($transaction->receipt_image) {
            @unlink(public_path($transaction->receipt_image));
        }
        $user->balance -= $transaction->amount;
        $user->save();
        
        $transaction->delete();
        
        return redirect()->back()->with('success', 'Транзакция успешно удалена');
    }

    public function checkCategoryLimits()
    {
        $user = auth()->user();
        $categories = Category::where('user_id', $user->id)->where('type', 'expense')->get();

        $firstDayOfMonth = Carbon::now()->startOfMonth();

        foreach($categories as $category) {
            if($category->limit) {
            $currentLimit = $category->limit;
            $currentExpense = Transaction::where('category_id', $category->id)
                                            ->where('amount', '<', 0)
                                            ->where('created_at', '>=', $firstDayOfMonth)
                                            ->sum('amount');

            $remaining = $currentLimit + $currentExpense;
            $remainingPercent = ($remaining/$currentLimit) * 100;

            if($remainingPercent <= 10 && $remainingPercent >= 0) {
                $user->notify(new LimitWarning($category));
                session()->flash('warning', "Осторожно! Cледите за лимитом, он уже зашел за 90%!");
            }
        }
     }
  }

}
