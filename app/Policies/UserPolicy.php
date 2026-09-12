<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewProfile(User $user, User $profile): bool
    {
        return $user->is($profile) && $user->can('profile.view');
    }

    public function updateProfile(User $user, User $profile): bool
    {
        return $user->is($profile) && $user->can('profile.update');
    }

    public function deleteProfile(User $user, User $profile): bool
    {
        return $user->is($profile);
    }

    public function viewAny(User $user): bool
    {
        return $user->can('user.view');
    }

    public function update(User $user, User $target): bool
    {
        return $user->can('user.update');
    }
}
