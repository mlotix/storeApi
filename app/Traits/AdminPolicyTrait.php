<?php
namespace App\Traits;


/**
 *
 */
trait AdminPolicyTrait
{
  public function before($user, $ability)
  {
    return $user->isAdmin();
  }
}
