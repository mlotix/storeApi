<?php

namespace App\Policies;

use App\Seller;
use App\Product;
use App\User;
use App\Traits\AdminPolicyTrait;
use Illuminate\Auth\Access\HandlesAuthorization;

class SellerPolicy
{
  use AdminPolicyTrait;
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Seller  $seller
     * @return mixed
     */
    public function view(User $user, Seller $seller)
    {
      return $user->id === $seller->id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Seller  $seller
     * @return mixed
     */
    public function update(User $user, Seller $seller, Product $product)
    {
        return $user->id === $seller->id && $user->id === $product->seller_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Seller  $seller
     * @return mixed
     */
    public function delete(User $user, Seller $seller)
    {
        return $user->id === $seller->id && $user->id === $product->seller_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Seller  $seller
     * @return mixed
     */
    public function restore(User $user, Seller $seller)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Seller  $seller
     * @return mixed
     */
    public function forceDelete(User $user, Seller $seller)
    {
        //
    }
}
