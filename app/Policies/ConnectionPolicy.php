<?php

namespace App\Policies;

use App\Models\Connection;
use App\Models\User;

class ConnectionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('connection.view');
    }

    public function view(User $user, Connection $connection): bool
    {
        return $user->can('connection.view') && $connection->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->can('connection.create');
    }

    public function update(User $user, Connection $connection): bool
    {
        return $user->can('connection.update') && $connection->user_id === $user->id;
    }

    public function delete(User $user, Connection $connection): bool
    {
        return $user->can('connection.delete') && $connection->user_id === $user->id;
    }
}
