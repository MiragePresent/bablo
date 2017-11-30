<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotient extends Model
{

    const NOT_PAID = 0;
    const PARTIALLY_PAID = 1;
    const PAID = 2;

    protected $fillable = [
        'user_id',
        'quotient_id',
        'check_id',
        'amount',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(\User::class);
    }

    public function check()
    {
        return $this->belongsTo(\Check::class);
    }

    public function payments()
    {
        return $this->hasMany(\Payment::class);
    }
}
