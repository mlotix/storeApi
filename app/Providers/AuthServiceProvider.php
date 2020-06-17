<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use Carbon\Carbon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        App\Buyer::class => App\Policies\BuyerPolicy::class,
        App\Basketitem::class => App\Policies\BasketitemPolicy::class,
        App\Category::class => App\Policies\CategoryPolicy::class,
        App\Product::class => App\Policies\ProductPolicy::class,
        App\Seller::class => App\Policies\SellerPolicy::class,
        App\Transaction::class => App\Policies\TransactionPolicy::class,
        App\User::class => App\Policies\UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {

        //policies and gates
        $this->registerPolicies();
        Gate::define('make-admin-action', function ($user) {
          return $user->isAdmin();
        });

        //passport
        Passport::tokensExpireIn(Carbon::now()->addMinutes(30));
        Passport::refreshTokensExpireIn(Carbon::now()->addMinutes(120));
        Passport::personalAccessTokensExpireIn(Carbon::now()->addDays(2));

        Passport::personalAccessClientId(
          config('passport.personal_access_client.id')
        );

        Passport::personalAccessClientSecret(
          config('passport.personal_access_client.secret')
        );

        Passport::tokensCan([
          'purchase-product' => 'Add item to basket and make a transaction',
          'manage-products' => 'CRUD products',
          'manage-account' => 'Read, modify account data. Delete the account',
          'read-stats' => 'Read statistics about the user account',
        ]);
    }
}
