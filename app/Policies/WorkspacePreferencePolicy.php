<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkspacePreference;

class WorkspacePreferencePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('dashboard.view');
    }

    public function view(User $user, WorkspacePreference $preference): bool
    {
        return $user->can('dashboard.view') && $preference->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->can('dashboard.view');
    }

    public function update(User $user, WorkspacePreference $preference): bool
    {
        return $user->can('dashboard.view') && $preference->user_id === $user->id;
    }

    public function delete(User $user, WorkspacePreference $preference): bool
    {
        return $user->can('dashboard.view') && $preference->user_id === $user->id;
    }
}
