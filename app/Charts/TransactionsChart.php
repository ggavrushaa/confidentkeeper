<?php

namespace App\Charts;

use App\Models\Transaction;
// use ConsoleTVs\Charts\Classes\Line\Chart;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;


class TransactionsChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handler($filteredDates = null, $filteredTransactions = null)
{
    if (!$filteredTransactions || !$filteredDates) {
        $dates = collect(range(30, 0))->map(function ($daysAgo) {
            return now()->subDays($daysAgo)->format('Y-m-d');
        });

        $transactions = $dates->map(function ($date) {
            return Transaction::whereDate('created_at', $date)->count();
        });

        $this->dataset('Транзакции', 'bar', $transactions)
            ->color('#212529')
            ->backgroundColor('#212529');

        $this->labels($dates);
    } else {

        $transactions = $filteredDates->map(function ($date) use ($filteredTransactions) {
            $count = $filteredTransactions->filter(function ($transaction) use ($date) {
                return isset($transaction->created_at) && $transaction->created_at === $date;
            })->count();
            return $count;
        });
        
        $transactionsCounts = $filteredTransactions->map(function ($dateTransactions) {
            return $dateTransactions->count();
        });

        $this->dataset('Транзакции', 'bar', $transactionsCounts)
            ->color('#212529')
            ->backgroundColor('#212529');

        $this->labels($filteredDates);
    }
}

}

