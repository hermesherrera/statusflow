<?php

namespace HermesHerrera\StatusFlow\Policies;

use App\Models\User;
use HermesHerrera\StatusFlow\Models\StatusFlow;

class StatusFlowPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('status_flows.access');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, StatusFlow $statusFlow): bool
    {
        return $user->can('status_flows.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('status_flows.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, StatusFlow $statusFlow): bool
    {
        return $user->can('status_flows.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, StatusFlow $statusFlow): bool
    {
        return $user->can('status_flows.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, StatusFlow $statusFlow): bool
    {
        return $user->can('status_flows.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, StatusFlow $statusFlow): bool
    {
        return $user->can('status_flows.force_delete');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function audit(User $user, StatusFlow $statusFlow): bool
    {
        return $user->can('status_flows.audit');
    }
}
