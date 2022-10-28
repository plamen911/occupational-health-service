<?php

namespace App\Policies;

use App\Models\FirmPosition;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FirmPositionPolicy
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
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FirmPosition  $firmPosition
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, FirmPosition $firmPosition)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FirmPosition  $firmPosition
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, FirmPosition $firmPosition)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FirmPosition  $firmPosition
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, FirmPosition $firmPosition)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FirmPosition  $firmPosition
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, FirmPosition $firmPosition)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FirmPosition  $firmPosition
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, FirmPosition $firmPosition)
    {
        //
    }
}
