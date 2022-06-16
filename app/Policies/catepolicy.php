<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class catepolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        if ($user->is_admin == 1) {
            return \true;
        } else {
            return  $user->checkPermissionAccess('view_category');
        }
    }
    public function view(User $user)
    {
        if ($user->is_admin == 1) {
            return \true;
        } else {
            return  $user->checkPermissionAccess('view_category');
        }
    }
    public function create(User $user)
    {
        if ($user->is_admin == 1) {
            return \true;
        } else {
            return  $user->checkPermissionAccess('create_category');
        }
    }
    public function update(User $user)
    {
        if ($user->is_admin == 1) {
            return \true;
        } else {
            return  $user->checkPermissionAccess('update_category');
        }
    }
    public function delete(User $user)
    {
        if ($user->is_admin == 1) {
            return \true;
        } else {
            return  $user->checkPermissionAccess('delete_category');
        }
    }
    public function restore(User $user)
    {
        if ($user->is_admin == 1) {
            return \true;
        } else {
            return  $user->checkPermissionAccess('update_category');
        }
    }



    /////danh muc bai biet

    public function viewAnypost(User $user)
    {
        if ($user->is_admin == 1) {
            return \true;
        } else {
            return  $user->checkPermissionAccess('view_categorypost');
        }
    }
    public function viewpost(User $user)
    {
        if ($user->is_admin == 1) {
            return \true;
        } else {
            return  $user->checkPermissionAccess('view_categorypost');
        }
    }
    public function createpost(User $user)
    {
        if ($user->is_admin == 1) {
            return \true;
        } else {
            return  $user->checkPermissionAccess('create_categorypost');
        }
    }
    public function updatepost(User $user)
    {
        if ($user->is_admin == 1) {
            return \true;
        } else {
            return  $user->checkPermissionAccess('update_categorypost');
        }
    }
    public function deletepost(User $user)
    {
        if ($user->is_admin == 1) {
            return \true;
        } else {
            return  $user->checkPermissionAccess('delete_categorypost');
        }
    }
    public function restorepost(User $user)
    {
        if ($user->is_admin == 1) {
            return \true;
        } else {
            return  $user->checkPermissionAccess('update_categorypost');
        }
    }
}
