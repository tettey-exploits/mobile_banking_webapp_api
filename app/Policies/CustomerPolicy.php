<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CustomerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Customer $customer): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $permission = Permission::firstWhere("permission", "add new customer");
        $allowed_roles = $permission->roles()->pluck("role");
        $is_allowed_access = false;

        foreach($user->roles as $role){
            if($allowed_roles->contains($role->role)){
                $is_allowed_access = true;
                break;
            }
        }

        return $is_allowed_access;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Customer $customer): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Customer $customer): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Customer $customer): bool
    {
        //
    }

}
