<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *  Payment Model
 *
 * @property int $id
 * @property int $user_id
 * @property int $status
 * @property float $amount
 * @property string $comment
 *
 * @property-read \App\Models\User
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Quotient[] $quotients
 *
 */

class Payment extends Model
{
    const DEFAULT_STATUS = 0;
    const APPROVED = 1;
    const DISAPPROVED = 2;


    protected $fillable = [
        'user_id',
        'quotient_id',
        'amount',
        'comment',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(\User::class);
    }

    public function quotients()
    {
        return $this->belongsToMany(\Quotient::class);
    }

}
