<?php

namespace App\Policies;

use App\Models\AffiliateRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AffiliateRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isMerchant() || $user->isAffiliate();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AffiliateRequest $affiliateRequest): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isMerchant()) {
            return $user->merchant && $user->merchant->id === $affiliateRequest->merchant_id;
        }

        if ($user->isAffiliate()) {
            return $user->affiliate && $user->affiliate->id === $affiliateRequest->affiliate_id;
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
    public function update(User $user, AffiliateRequest $affiliateRequest): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isMerchant()) {
            return $user->merchant && $user->merchant->id === $affiliateRequest->merchant_id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AffiliateRequest $affiliateRequest): bool
    {
        return $user->isAdmin();
    }
}
