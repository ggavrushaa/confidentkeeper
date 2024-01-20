<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\Currency;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id',
        'amount', 'comment', 'name',
        'receipt_image', 'currency_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

}
