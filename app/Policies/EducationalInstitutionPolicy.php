<?php

namespace App\Policies;

use App\Models\EducationalInstitution;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EducationalInstitutionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_educational::institution');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, EducationalInstitution $educationalInstitution): bool
    {
        return $user->can('view_educational::institution');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_educational::institution');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, EducationalInstitution $educationalInstitution): bool
    {
        return $user->can('update_educational::institution');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, EducationalInstitution $educationalInstitution): bool
    {
        return $user->can('delete_educational::institution');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, EducationalInstitution $educationalInstitution): bool
    {
        return $user->can('restore_educational::institution');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, EducationalInstitution $educationalInstitution): bool
    {
        return $user->can('force_delete_educational::institution');
    }
}
