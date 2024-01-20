<?php
namespace App\Traits;
use Illuminate\Http\Request;
use Carbon\Carbon;
trait TransactionFilter
{
    public function filterTransactions($query, Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:50'],
            'from_date' => ['nullable', 'string', 'date'],
            'to_date' => ['nullable', 'string', 'date', 'after:from_date'],
        ]);

        if($search = $validated['search'] ?? null) {
            $query->where('name', 'like', "%{$search}%");
        }

        if($from_date = $validated['from_date'] ?? null) {
            $query->where('created_at', '>=', new Carbon($from_date));
        }

        if($to_date = $validated['to_date'] ?? null) {
            $query->where('created_at', '<=', new Carbon($to_date));
        }
        return $query;
    }
}
