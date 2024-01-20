<?php

namespace App\Http\Controllers;

use App\Charts\TransactionsChart;
use App\Charts\СategoryChart;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use App\Traits\TransactionFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    use TransactionFilter;
    public function index(Request $request, Category $category)
    {
        $user = Auth::user();
        $filteredTransactions = $user->transactions()->get();    
        $this->filterTransactions($filteredTransactions, $request);
        
       

        $uahCurrency = \App\Models\Currency::where('code', '₴')->first();
        $uahId = $uahCurrency->id;
        $uahCode = $uahCurrency->code;

        $uahBalance = $filteredTransactions->where('currency_id', $uahId)->sum('amount');
        
        $spendAmountQuery = clone $filteredTransactions;
        $earnAmountQuery = clone $filteredTransactions;


        $spendAmount = $spendAmountQuery->where('amount', '<', 0)->sum('amount');
        $earnAmount = $earnAmountQuery->where('amount', '>', 0)->sum('amount');

// -––––––––––––––––––––––––––––––––––––– Category and count ––––––––––––––––––––––––––––––––––––


        $incomeTransactions = $filteredTransactions->filter(function($transaction) {
            return $transaction->category && $transaction->category->type == 'income';
        });

        $expenseTransactions = $filteredTransactions->filter(function($transaction) {
            return $transaction->category && $transaction->category->type == 'expense';
        });

  
   


      $incomeSum = $incomeTransactions->sum('amount');
      $expenseSum = $expenseTransactions->sum('amount');

      $incomeCategoryData = [];
      foreach($incomeTransactions as $transaction) {
        if ($transaction->category) {
        $percent = $incomeSum == 0 ? 0 : ($transaction->amount / $incomeSum ) * 100;

        if(!isset($incomeCategoryData[$transaction->category->name])) {
            $incomeCategoryData[$transaction->category->name] = [
            'percent' => 0,
            'amount' => 0,
            'type' => 'income',
            'category_id' => $transaction->category->id,
            ];
        }
        $incomeCategoryData[$transaction->category->name]['percent'] += $percent; 
        $incomeCategoryData[$transaction->category->name]['amount'] += $transaction->amount; 
      }
    }

 

    $expenseCategoryData = [];
    foreach($expenseTransactions as $transaction) {
        if ($transaction->category) {
            $percent = $expenseSum == 0 ? 0 : ($transaction->amount / $expenseSum ) * 100;
    
            if(!isset($expenseCategoryData[$transaction->category->name])) {
                $expenseCategoryData[$transaction->category->name] = [
                    'percent' => 0,
                    'amount' => 0,
                    'type' => 'expense',
                    'category_id' => $transaction->category->id,
                ];
            }
            $expenseCategoryData[$transaction->category->name]['percent'] += $percent; 
            $expenseCategoryData[$transaction->category->name]['amount'] += $transaction->amount; 
        }
    }
  
    // -––––––––––––––––––––––––––––––––––––– All for charts ––––––––––––––––––––––––––––––––––––
  

    $fromDate = $request->input('from_date') ?? now()->subDays(30)->toDateString();
    $toDate = $request->input('to_date') ?? now()->toDateString();


    $filteredTransactionsQuery = clone $user->transactions();
    $filteredTransactionsQuery->whereBetween('created_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59']);




    $start = new \DateTime($fromDate);
    $end = new \DateTime($toDate);
    $interval = new \DateInterval('P1D');
    $dateRange = new \DatePeriod($start, $interval, $end);

    $filteredDates = collect(range(31,0))->map(function($daysAgo) {
        return now()->subDays($daysAgo)->format('Y-m-d');
    });
    
    $filteredTransactions = $filteredDates->map(function ($date) use ($filteredTransactionsQuery) {
        return (clone $filteredTransactionsQuery)->whereDate('created_at', $date)->get();
    });
   
        $charts = [
            'transactions' => $this->createTransactionsChart($filteredDates, $filteredTransactions),
            'category' => $this->createCategoryBalanceChart($filteredTransactions, $filteredDates),
        ];
        $user = auth()->user();
        $categories = Category::where('user_id', $user->id)->where('type', 'expense')->get();
        foreach ($categories as $category) {
            if ($category->limit) {
                $currentExpense = abs(Transaction::where('category_id', $category->id)
                                              ->where('amount', '<', 0)
                                              ->sum('amount'));
                $category->usagePercent = ($currentExpense / $category->limit) * 100;
            } else {
                $category->usagePercent = 0;
            }
        }
      
        return view('report.index', compact('uahBalance', 'uahCode', 'spendAmount', 'earnAmount', 'expenseCategoryData', 'incomeCategoryData', 'category', 'charts', 'categories'));

    }

    public function createTransactionsChart($filteredDates, $filteredTransactions)
    {
        $chart = new TransactionsChart;
        $chart->handler($filteredDates, $filteredTransactions);

        return $chart;
    }

    public function createCategoryBalanceChart($filteredTransactions, $filteredDates)
    {
        $chart = new СategoryChart;
        $chart->handler($filteredTransactions, $filteredDates);

        return $chart;
    }
}
