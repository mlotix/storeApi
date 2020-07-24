<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use Carbon\Carbon;

use App\Buyer;
use App\Policies\BuyerPolicy;
use App\Basketitem;
use App\Policies\BasketitemPolicy;
use App\Category;
use App\Policies\CategoryPolicy;
use App\Product;
use App\Policies\ProductPolicy;
use App\Seller;
use App\Policies\SellerPolicy;
use App\Transaction;
use App\Policies\TransactionPolicy;
use App\User;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Buyer::class => BuyerPolicy::class,
        Basketitem::class => BasketitemPolicy::class,
        Category::class => CategoryPolicy::class,
        Product::class => ProductPolicy::class,
        Seller::class => SellerPolicy::class,
        Transaction::class => TransactionPolicy::class,
        User::class => UserPolicy::class,
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
    }
}
