<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TransactionPolicy
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
    public function view(User $user, Transaction $transaction): bool
    {
        $is_allowed_access = false;
        $permission = Permission::firstWhere("permission", "access customer profiles");
        $allowed_roles = $permission->roles()->pluck("role");
        $user_roles = $user->roles()->pluck("role");

        foreach($user_roles as $role){
            if($allowed_roles->contains($role)){
                $is_allowed_access = true;
                break;
            }
        }

        return $is_allowed_access;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $is_allowed_access = false;
        $permission = Permission::firstWhere("permission", "take deposits");
        $allowed_roles = $permission->roles()->pluck("role");
        $user_roles = $user->roles()->pluck("role");

        foreach($user_roles as $role){
            if($allowed_roles->contains($role)){
                $is_allowed_access = true;
                break;
            }
        }

        return $is_allowed_access;

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Transaction $transaction): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Transaction $transaction): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Transaction $transaction): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Transaction $transaction): bool
    {
        //
    }
}
