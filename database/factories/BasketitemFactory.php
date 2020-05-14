<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Basketitem;
use Faker\Generator as Faker;
use App\Buyer;
use App\Product;

$factory->define(Basketitem::class, function (Faker $faker) {

    $product = Product::all()->random();
    $seller_id = $product->seller_id;
    $buyer = Buyer::all()->except($seller_id)->random();
    return [
        'product_id' => $product,
        'buyer_id' => $buyer,
        'quantity' => $faker->numberBetween(1,20),
    ];
});
