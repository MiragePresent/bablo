<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Check Model
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property float  $amount
 * @property int    $status
 *
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Quotient[] $quotients
 *
 */

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

    /**
     *  Determine whether the is partially paid
     *
     * @return bool
     */
    public function isPartiallyPaid()
    {
        return $this->status === self::PARTIALLY_PAID;
    }

    /**
     *  Determine whether the is paid
     *
     * @return bool
     */
    public function isPaid()
    {
        return $this->status === self::PAID;
    }


}
