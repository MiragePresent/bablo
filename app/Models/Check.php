<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Check extends Model
{

    const NOT_PAID = 0;
    const PARTIALLY_PAID = 1;
    const PAID = 2;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'amount',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(\User::class);
    }

    public function quotients()
    {
        return $this->hasMany(\Quotient::class);
    }

}
