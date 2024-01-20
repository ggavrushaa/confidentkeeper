<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class СategoryChart extends Chart
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

    public function handler($filteredTransactions, $filteredDates)
    {
        $categoryBalances = [];
        $categoryColors = [];
    
        foreach ($filteredTransactions as $date => $transactions) {
            foreach ($transactions as $transaction) {
                if ($transaction->category) {
                    $categoryName = $transaction->category->name;
                    if (!isset($categoryBalances[$categoryName])) {
                        $categoryBalances[$categoryName] = 0;

                        $categoryColors[$categoryName] = $transaction->category->type == 'expense' ? '#ff0000' : '#00ff00';
                    }
                    $categoryBalances[$categoryName] += $transaction->amount;
                }
            }
        }
    
        $this->labels(array_keys($categoryBalances));
        $this->dataset('Баланс по категориям', 'bar', array_values($categoryBalances))
            ->color(array_values($categoryColors))
            ->backgroundColor(array_values($categoryColors));
    }
}
