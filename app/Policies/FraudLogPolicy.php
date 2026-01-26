<?php

namespace App\Policies;

use App\Models\FraudLog;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FraudLogPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FraudLog $fraudLog): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false; // Created via logic
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FraudLog $fraudLog): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FraudLog $fraudLog): bool
    {
        return $user->isAdmin();
    }
}
