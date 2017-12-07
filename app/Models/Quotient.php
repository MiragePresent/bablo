<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Quotient Model
 *
 * @property int $id
 * @property int $user_id
 * @property int $check_id
 * @property int $status
 * @property float $amount
 *
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Check $check
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment $payments
 *
 */

class Quotient extends Model
{

    const DEFAULT_STATUS = 0;
    const NOT_PAID = 0;
    const PARTIALLY_PAID = 1;
    const PAID = 2;
    const APPROVED = 3;
    const DISAPPROVED = 4;

    protected $fillable = [
        'user_id',
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
        return $this->belongsToMany(\Payment::class);
    }
}
