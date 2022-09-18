<?php

namespace App\Policies\Unit;

use App\Models\User;
use App\Models\Unit\Department;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('view_any_department');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Unit\Department  $department
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Department $department)
    {
        return $user->can('view_department');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Unit\Department  $department
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create_department');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Unit\Department  $department
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Department $department)
    {
        return $user->can('update_department');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Unit\Department  $department
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Department $department)
    {
        return $user->can('delete_department');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(User $user)
    {
        return $user->can('delete_any_department');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Unit\Department  $department
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Department $department)
    {
        return $user->can('force_delete_department');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(User $user)
    {
        return $user->can('force_delete_any_department');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Unit\Department  $department
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Department $department)
    {
        return $user->can('restore_department');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user)
    {
        return $user->can('restore_any_department');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Unit\Department  $department
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(User $user, Department $department)
    {
        return $user->can('replicate_department');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(User $user)
    {
        return $user->can('reorder_department');
    }

}
