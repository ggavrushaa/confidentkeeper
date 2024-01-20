<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;
    protected $table = 'saving_goals';

    protected $fillable = [
      'user_id',  'title', 'description',
      'total_amount', 'current_amount',
      'status', 'image', 'deadline',
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
