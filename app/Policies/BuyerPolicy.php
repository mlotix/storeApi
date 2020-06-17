<?php

namespace App\Policies;

use App\Buyer;
use App\User;
use App\Traits\AdminPolicyTrait;
use Illuminate\Auth\Access\HandlesAuthorization;

class BuyerPolicy
{
  use AdminPolicyTrait;
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Buyer  $buyer
     * @return mixed
     */
    public function view(User $user, Buyer $buyer)
    {
      return $user->id === $buyer->id;
    }

    /**
     * Determine whether the user can add items to basket.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function addToBasket(User $user, Buyer $buyer)
    {
      return $user->id === $buyer->id;
    }
    /**
     * Determine whether the user can buy item from basket.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function purchase(User $user, Buyer $buyer)
    {
      return $user->id === $buyer->id;
    }
}
