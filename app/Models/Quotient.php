<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment[] $payments
 *
 *
 * @method static $this latest()
 * @method static $this notPaid()
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

    // RELATIONS

    /**
     *  User relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\User::class);
    }

    /**
     * Check relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function check()
    {
        return $this->belongsTo(\Check::class);
    }

    /**
     *  Payments relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(\Payment::class);
    }

    // SCOPES

    /**
     *  Get quotients. Latest first
     * @param Builder $query
     * @return Builder
     */
    public function scopeLatest(Builder $query)
    {
        return $query->orderBy('created_at')
            ->orderBy('updated_at');
    }

    /**
     *  Get quotients. Latest first
     * @param Builder $query
     * @return Builder
     */
    public function scopeNotPaid(Builder $query)
    {
        return $query->whereNotIn('status', [ self::PAID, self::DISAPPROVED ]);
    }

    // HELPERS

    /**
     *  Determinate that quotient is not paid
     *
     * @return bool
     */
    public function isNotPaid()
    {
        return $this->status === self::NOT_PAID;
    }

    /**
     *  Determinate that quotient is partially paid
     *
     * @return bool
     */
    public function isPartiallyPaid()
    {
        return $this->status === self::PARTIALLY_PAID;
    }

    /**
     *  Determinate that quotient is paid
     *
     * @return bool
     */
    public function isPaid()
    {
        return $this->status === self::PAID;
    }

    /**
     *  Determinate that quotient is approved
     *
     * @return bool
     */
    public function isApproved()
    {
        return $this->status === self::APPROVED || $this->isPaid() || $this->isPartiallyPaid();
    }

    /**
     *  Determinate that quotient is dissaproved
     *
     * @return bool
     */
    public function isDisapproved()
    {
        return $this->status === self::DISAPPROVED;
    }
}
