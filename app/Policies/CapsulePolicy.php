<?php

namespace App\Policies;

use App\Models\Capsule;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CapsulePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Capsule $capsule): bool
    {
        return $user->id === $capsule->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Capsule $capsule): bool
    {
        return $user->id === $capsule->user_id && $capsule->isDraft();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Capsule $capsule): bool
    {
        return $user->id === $capsule->user_id && $capsule->isDraft();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Capsule $capsule): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Capsule $capsule): bool
    {
        return false;
    }
} 