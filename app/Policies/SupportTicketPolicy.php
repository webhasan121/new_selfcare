<?php

namespace App\Policies;

use App\Models\SupportTicket;
use App\Models\User;

class SupportTicketPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('support.view');
    }

    public function view(User $user, SupportTicket $ticket): bool
    {
        return $user->can('support.view') && $this->canAccess($user, $ticket);
    }

    public function create(User $user): bool
    {
        return $user->can('support.create');
    }

    public function update(User $user, SupportTicket $ticket): bool
    {
        return $user->can('support.update') && $this->canAccess($user, $ticket);
    }

    public function delete(User $user, SupportTicket $ticket): bool
    {
        return $user->can('support.delete') && $this->canAccess($user, $ticket);
    }

    private function canAccess(User $user, SupportTicket $ticket): bool
    {
        return $user->hasRole('support_staff') || $ticket->user_id === $user->id;
    }
}
