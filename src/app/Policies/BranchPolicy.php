<?php

namespace App\Policies;

use App\Models\Branch;
use App\Models\User;

class BranchPolicy
{
    public function view(User $user, Branch $branch): bool
    {
        return $branch->business->owner_id === $user->id;
    }

    public function update(User $user, Branch $branch): bool
    {
        return $branch->business->owner_id === $user->id;
    }

    public function delete(User $user, Branch $branch): bool
    {
        return $branch->business->owner_id === $user->id;
    }
}
