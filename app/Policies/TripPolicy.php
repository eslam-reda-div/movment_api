<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Trip;
use Illuminate\Auth\Access\HandlesAuthorization;

class TripPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('view_any_trip');
    }

    /**
     * Determine whether the admin can view the model.
     */
    public function view(Admin $admin, Trip $trip): bool
    {
        return $admin->can('view_trip');
    }

    /**
     * Determine whether the admin can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('create_trip');
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(Admin $admin, Trip $trip): bool
    {
        return $admin->can('update_trip');
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(Admin $admin, Trip $trip): bool
    {
        return $admin->can('delete_trip');
    }

    /**
     * Determine whether the admin can bulk delete.
     */
    public function deleteAny(Admin $admin): bool
    {
        return $admin->can('delete_any_trip');
    }

    /**
     * Determine whether the admin can permanently delete.
     */
    public function forceDelete(Admin $admin, Trip $trip): bool
    {
        return $admin->can('{{ ForceDelete }}');
    }

    /**
     * Determine whether the admin can permanently bulk delete.
     */
    public function forceDeleteAny(Admin $admin): bool
    {
        return $admin->can('{{ ForceDeleteAny }}');
    }

    /**
     * Determine whether the admin can restore.
     */
    public function restore(Admin $admin, Trip $trip): bool
    {
        return $admin->can('{{ Restore }}');
    }

    /**
     * Determine whether the admin can bulk restore.
     */
    public function restoreAny(Admin $admin): bool
    {
        return $admin->can('{{ RestoreAny }}');
    }

    /**
     * Determine whether the admin can replicate.
     */
    public function replicate(Admin $admin, Trip $trip): bool
    {
        return $admin->can('{{ Replicate }}');
    }

    /**
     * Determine whether the admin can reorder.
     */
    public function reorder(Admin $admin): bool
    {
        return $admin->can('{{ Reorder }}');
    }
}