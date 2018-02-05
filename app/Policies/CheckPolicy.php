<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class CheckPolicy
{
    use HandlesAuthorization;

    /**
     *  Determine whether the user can view the check.
     *
     * @param \User $user
     * @param \Check $check
     * @return bool
     */
    public function view(\User $user, \Check $check)
    {

        return $user->id == $check->user_id;
    }

    /**
     *  Determine whether the user can update the check.
     *
     * @param \User $user
     * @param \Check $check
     * @return bool
     */
    public function update(\User $user, \Check $check)
    {
        return ($user->id == $check->user_id) && !$check->isPaid();
    }

    /**
     *  Determine whether the user can delete the check.
     *
     * @param \User $user
     * @param \Check $check
     * @return bool
     */
    public function delete(\User $user, \Check $check)
    {
        return $this->view($user, $check) && !$check->isPartiallyPaid();
    }
}
