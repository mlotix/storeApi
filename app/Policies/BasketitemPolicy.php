<?php

namespace App\Policies;

use App\Basketitem;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Traits\AdminPolicyTrait;

class BasketitemPolicy
{
  use AdminPolicyTrait;
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Basketitem  $basketitem
     * @return mixed
     */
    public function view(User $user, Basketitem $basketitem)
    {
        return $user->id === $basketitem->buyer_id;
    }
}
