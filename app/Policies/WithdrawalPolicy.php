<?php

namespace App\Policies;

use App\Models\Withdrawal;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class WithdrawalPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isAffiliate();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Withdrawal $withdrawal): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isAffiliate()) {
            return $user->affiliate && $user->affiliate->id === $withdrawal->affiliate_id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAffiliate();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Withdrawal $withdrawal): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        // Affiliates might update their own pending withdrawals? 
        // Usually not after submission, but let's allow if pending.
        if ($user->isAffiliate() && $withdrawal->status === 'pending') {
            return $user->affiliate && $user->affiliate->id === $withdrawal->affiliate_id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Withdrawal $withdrawal): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Withdrawal $withdrawal): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Withdrawal $withdrawal): bool
    {
        return $user->isAdmin();
    }
}
