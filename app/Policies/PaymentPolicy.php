<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentPolicy
{
    use HandlesAuthorization;


    /**
     *  Determine user can create payment
     *
     * @param \User $user
     * @param \Quotient $quotient
     * @return bool
     */
    public function create(\User $user, \Quotient $quotient)
    {
        return ($quotient->user_id == $user->id) && !(\Quotient::PAID !== $quotient->status);
    }
}
