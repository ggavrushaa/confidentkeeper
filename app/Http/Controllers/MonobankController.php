<?php

namespace App\Http\Controllers;
use App\Services\MonobankService;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;


class MonobankController extends Controller
{
    public function showClientInfo(MonobankService $monobank)
    {
        try {
        $clientInfo = $monobank->getClientInfo();
        $transactions = $monobank->getPaginatedAllTransactions();
    
        return view('bank.monobank', compact('clientInfo', 'transactions')); 
        } catch (ClientException $e) {
            if($e->getResponse()->getStatusCode() == 429) {
                return redirect('/')->with('error', 'Да, мы не можем обновлять конкретно эту страницу чаще, чем раз в минуту. Увы такие правила Monobank та и я не всемогущий');
            }
                return redirect('/')->with('error', 'Произошла ошибка при попытке получить данные от банка. Пробуйте позже или перепроверьте ваш API токен. Можно еще мне написать (крайний случай)');
        }
    }
}
