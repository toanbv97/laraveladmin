<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vote;
use Illuminate\Auth\Access\HandlesAuthorization;

class VotePolicy
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
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewPost(User $user)
    {
        if ($user->is_admin == 1) {
            return \true;
        } else {
            return $user->checkPermissionAccess('view_vote_post');
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function createPost(User $user)
    {
        if ($user->is_admin == 1) {
            return \true;
        } else {
            return $user->checkPermissionAccess('create_vote_post');
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function updatePost(User $user)
    {
        if ($user->is_admin == 1) {
            return \true;
        } else {
            return $user->checkPermissionAccess('update_vote_post');
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deletePost(User $user)
    {
        if ($user->is_admin == 1) {
            return \true;
        } else {
            return $user->checkPermissionAccess('delete_vote_post');
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user)
    {
        //
    }

    public function viewProduct(User $user)
    {
        if ($user->is_admin == 1) {
            return \true;
        } else {
            return $user->checkPermissionAccess('view_vote_product');
        }
    }
    public function createProduct(User $user)
    {
        if ($user->is_admin == 1) {
            return \true;
        } else {
            return $user->checkPermissionAccess('create_vote_product');
        }
    }

    public function updateProduct(User $user)
    {
        if ($user->is_admin == 1) {
            return \true;
        } else {
            return $user->checkPermissionAccess('update_vote_product');
        }
    }

    public function deleteProduct(User $user)
    {
        if ($user->is_admin == 1) {
            return \true;
        } else {
            return $user->checkPermissionAccess('delete_vote_product');
        }
    }
}
