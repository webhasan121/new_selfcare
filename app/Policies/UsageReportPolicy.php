<?php

namespace App\Policies;

use App\Models\UsageReport;
use App\Models\User;

class UsageReportPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('usage.view');
    }

    public function view(User $user, UsageReport $report): bool
    {
        return $user->can('usage.view') && $report->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->can('usage.view');
    }

    public function update(User $user, UsageReport $report): bool
    {
        return $user->can('usage.view') && $report->user_id === $user->id;
    }

    public function delete(User $user, UsageReport $report): bool
    {
        return $user->can('usage.view') && $report->user_id === $user->id;
    }
}
