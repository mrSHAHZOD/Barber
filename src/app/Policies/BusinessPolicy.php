<?php

namespace App\Policies;

use App\Models\Business;
use App\Models\User;

class BusinessPolicy
{
    /**
     * Faqat owner businessni ko'ra oladi.
     */
    public function view(User $user, Business $business): bool
    {
        return $user->id === $business->owner_id;
    }

    /**
     * Faqat owner update qila oladi.
     */
    public function update(User $user, Business $business): bool
    {
        return $user->id === $business->owner_id;
    }

    /**
     * Faqat owner delete qila oladi.
     */
    public function delete(User $user, Business $business): bool
    {
        return $user->id === $business->owner_id;
    }
}
