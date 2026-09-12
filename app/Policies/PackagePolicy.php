<?php

namespace App\Policies;

use App\Models\User;

class PackagePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('package.view');
    }
}
