<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PatientPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Admin i laborant mogu vidjeti sve pacijente
        return in_array($user->role, ['admin', 'laborant']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Patient $patient): bool
    {
        // Admin i laborant mogu vidjeti sve pacijente
        if (in_array($user->role, ['admin', 'laborant'])) {
            return true;
        }

        // Pacijent može vidjeti samo sebe
        return $user->patient && $user->patient->id === $patient->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Samo admin i laborant mogu kreirati pacijente
        return in_array($user->role, ['admin', 'laborant']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Patient $patient): bool
    {
        // Admin i laborant mogu ažurirati sve pacijente
        if (in_array($user->role, ['admin', 'laborant'])) {
            return true;
        }

        // Pacijent može ažurirati samo sebe
        return $user->patient && $user->patient->id === $patient->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Patient $patient): bool
    {
        // Samo admin i laborant mogu brisati pacijente
        return in_array($user->role, ['admin', 'laborant']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Patient $patient): bool
    {
        return in_array($user->role, ['admin', 'laborant']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Patient $patient): bool
    {
        return in_array($user->role, ['admin', 'laborant']);
    }
}
