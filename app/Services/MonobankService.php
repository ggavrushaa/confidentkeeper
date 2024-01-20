<?php 

namespace App\Services;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class MonobankService
{
    protected $client;

    public function __construct()
    {
        $this->user = Auth::user();

        if(!$this->user || !trim($this->user->bank_api_key)) {
            throw new \Exception('API ключ Monobank не установлен для данного пользователя.');
        }

        $this->client = new Client([
            'base_uri' => 'https://api.monobank.ua/',
            'headers' => [
                'X-Token' => decrypt($this->user->bank_api_key)
            ]
            ]);
    }

    public function getDefaultAccountId()
    {
        $clientInfo = $this->getClientInfo();
        // return $clientInfo['accounts'][1]['id'];
        return array_map(function($account) {
            return $account['id'];
        }, $clientInfo['accounts']);
    }


    public function getClientInfo()
    {
        $response = $this->client->get('personal/client-info');
        return json_decode($response->getBody(), true);

    }

    public function getTransactions($accountId, $fromDate = null, $toDate = null)
    {
        if(!$fromDate) {
            $fromDate = now()->subMonth()->timestamp;
        }

        if(!$toDate) {
            $toDate = now()->timestamp;
        }

        $response = $this->client->get("personal/statement/{$accountId}/{$fromDate}/{$toDate}");
        $content = $response->getBody()->getContents();
 
        return json_decode($response->getBody(), true);
    }

        public function getAllTransactions($fromDate = null, $toDate = null)
        {
            $accountIds = $this->getDefaultAccountId();
            $allTransactions = [];

            foreach ($accountIds as $accountId) {
                $transactions = $this->getTransactions($accountId, $fromDate, $toDate);
                $allTransactions = array_merge($allTransactions, $transactions);
            }

            return $allTransactions;
        }

    public function getPaginatedAllTransactions($fromDate = null, $toDate = null)
    {
        $transactions = $this->getAllTransactions($fromDate, $toDate);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;
        $currentItems = array_slice($transactions, ($currentPage - 1) * $perPage, $perPage);

        return new LengthAwarePaginator($currentItems, count($transactions), $perPage, $currentPage, [
            'path' => request()->url(),
        ]);

    }

}