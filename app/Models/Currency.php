<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;

class Currency extends Model
{
    use HasFactory;
    protected $fillable = [
        'code', 'name',
    ];

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
