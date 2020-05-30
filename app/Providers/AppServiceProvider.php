<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Product;
use App\Mail\UserCreated;
use App\Mail\UserEmailUpdated;
use App\User;
use Illuminate\Support\Facades\Mail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Product::updated(function($product) {
          if($product->quantity == 0 & $product->isAvailable()){
            $product->status = $product::UNAVAILABLE_PRODUCT;
          }
        });

        User::created(function($user) {
          retry(4, function() use ($user) {
            Mail::to($user)->send(new UserCreated($user));
          }, 250);
        });
        User::updated(function($user) {
          if($user->isDirty('email')) {
            retry(4, function() use ($user) {
              Mail::to($user)->send(new UserEmailUpdated($user));
            }, 250);
          }
        });
    }
}
