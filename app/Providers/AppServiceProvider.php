<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Product;

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
    }
}
