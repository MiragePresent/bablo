<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $fillable = [
        'user_id',
        'quotient_id',
        'amount',
        'comment'
    ];

    public function user()
    {
        return $this->belongsTo(\User::class);
    }

    public function quotient()
    {
        return $this->belongsTo(\Quotient::class);
    }

}
