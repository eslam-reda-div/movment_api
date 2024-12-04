<?php

namespace App\Policies;

use App\Models\Admin;

use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can view any models.
     *
     * @param  \App\Models\Admin  $admin
     * @return bool
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('view_any_admin');
    }

    /**
     * Determine whether the admin can view the model.
     *
     * @param  \App\Models\Admin  $admin
     * @return bool
     */
    public function view(Admin $admin): bool
    {
        return $admin->can('view_admin');
    }

    /**
     * Determine whether the admin can create models.
     *
     * @param  \App\Models\Admin  $admin
     * @return bool
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('create_admin');
    }

    /**
     * Determine whether the admin can update the model.
     *
     * @param  \App\Models\Admin  $admin
     * @return bool
     */
    public function update(Admin $admin): bool
    {
        return $admin->can('update_admin');
    }

    /**
     * Determine whether the admin can delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @return bool
     */
    public function delete(Admin $admin): bool
    {
        return $admin->can('delete_admin');
    }

    /**
     * Determine whether the admin can bulk delete.
     *
     * @param  \App\Models\Admin  $admin
     * @return bool
     */
    public function deleteAny(Admin $admin): bool
    {
        return $admin->can('delete_any_admin');
    }

    /**
     * Determine whether the admin can permanently delete.
     *
     * @param  \App\Models\Admin  $admin
     * @return bool
     */
    public function forceDelete(Admin $admin): bool
    {
        return $admin->can('{{ ForceDelete }}');
    }

    /**
     * Determine whether the admin can permanently bulk delete.
     *
     * @param  \App\Models\Admin  $admin
     * @return bool
     */
    public function forceDeleteAny(Admin $admin): bool
    {
        return $admin->can('{{ ForceDeleteAny }}');
    }

    /**
     * Determine whether the admin can restore.
     *
     * @param  \App\Models\Admin  $admin
     * @return bool
     */
    public function restore(Admin $admin): bool
    {
        return $admin->can('{{ Restore }}');
    }

    /**
     * Determine whether the admin can bulk restore.
     *
     * @param  \App\Models\Admin  $admin
     * @return bool
     */
    public function restoreAny(Admin $admin): bool
    {
        return $admin->can('{{ RestoreAny }}');
    }

    /**
     * Determine whether the admin can bulk restore.
     *
     * @param  \App\Models\Admin  $admin
     * @return bool
     */
    public function replicate(Admin $admin): bool
    {
        return $admin->can('{{ Replicate }}');
    }

    /**
     * Determine whether the admin can reorder.
     *
     * @param  \App\Models\Admin  $admin
     * @return bool
     */
    public function reorder(Admin $admin): bool
    {
        return $admin->can('{{ Reorder }}');
    }
}
