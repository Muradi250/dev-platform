<?php

namespace App\Policies;

use App\Models\User;


class UserPolicy
{


    /*
    |--------------------------------------------------------------------------
    | View Users List
    |--------------------------------------------------------------------------
    |
    | چه کسانی لیست کاربران را ببینند
    |
    */

    public function viewAny(User $user): bool
    {

        return $user->isActive()
            &&
            $user->hasAnyRole([
                'super-admin',
                'admin',
            ]);

    }






    /*
    |--------------------------------------------------------------------------
    | View User
    |--------------------------------------------------------------------------
    */

    public function view(User $user, User $model): bool
    {


        /*
        Owner همیشه خودش را ببیند
        */

        if ($user->id === $model->id) {

            return true;

        }



        /*
        Super Admin کاربران را ببیند
        */

        return $user->hasRole('super-admin')
            &&
            ! $model->is_owner;


    }







    /*
    |--------------------------------------------------------------------------
    | Create User
    |--------------------------------------------------------------------------
    */

    public function create(User $user): bool
    {


        return $user->hasAnyRole([

            'super-admin',

            'admin',

        ]);


    }







    /*
    |--------------------------------------------------------------------------
    | Update User
    |--------------------------------------------------------------------------
    */

    public function update(User $user, User $model): bool
    {



        /*
        Owner فقط خودش را ویرایش کند
        */

        if ($model->is_owner) {


            return $user->id === $model->id;


        }





        /*
        Super Admin
        */

        if ($user->hasRole('super-admin')) {


            return true;


        }





        /*
        Admin
        */

        if ($user->hasRole('admin')) {


            return ! $model->hasRole('super-admin');


        }



        return false;


    }







    /*
    |--------------------------------------------------------------------------
    | Delete User
    |--------------------------------------------------------------------------
    */

    public function delete(User $user, User $model): bool
    {


        /*
        Owner هرگز حذف نشود
        */

        if ($model->is_owner) {


            return false;


        }





        /*
        Super Admin حذف کند
        */

        return $user->hasRole('super-admin');


    }








    /*
    |--------------------------------------------------------------------------
    | Restore
    |--------------------------------------------------------------------------
    */

    public function restore(User $user, User $model): bool
    {


        return $user->hasRole('super-admin')
            &&
            ! $model->is_owner;


    }








    /*
    |--------------------------------------------------------------------------
    | Force Delete
    |--------------------------------------------------------------------------
    */

    public function forceDelete(User $user, User $model): bool
    {


        /*
        هیچ وقت Owner حذف دائمی نشود
        */

        if ($model->is_owner) {


            return false;


        }


        return $user->hasRole('super-admin');


    }



}