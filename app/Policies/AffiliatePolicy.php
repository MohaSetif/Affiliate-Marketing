<?php

namespace App\Policies;

use App\Models\Affiliate;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AffiliatePolicy
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
    public function view(User $user, Affiliate $affiliate): bool
    {
        return $user->isAdmin() || ($user->isAffiliate() && $user->affiliate && $user->affiliate->id === $affiliate->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Affiliate $affiliate): bool
    {
        return $user->isAdmin() || ($user->isAffiliate() && $user->affiliate && $user->affiliate->id === $affiliate->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Affiliate $affiliate): bool
    {
        return $user->isAdmin();
    }
}
