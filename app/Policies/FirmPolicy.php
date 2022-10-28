<?php

namespace App\Policies;

use App\Models\Firm;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FirmPolicy
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
     * @param  \App\Models\Firm  $firm
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Firm $firm)
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
     * @param  \App\Models\Firm  $firm
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Firm $firm)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Firm  $firm
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Firm $firm)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Firm  $firm
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Firm $firm)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Firm  $firm
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Firm $firm)
    {
        //
    }
}
