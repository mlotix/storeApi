<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transaction;
use App\Seller;
use App\User;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {

    $seller = Seller::has('products')->get()->random();
    $buyer = User::all()->except($seller->id)->random();
    $product = $seller->products->random()->id;
    $quantity = $faker->numberBetween(1,3);
    //$price = Product::findOrFail($product)->get('price');
    $price = Product::select('price')->where('id', $product)->get()->pluck('price');
    $amount = $quantity*$price[0];

    return [
        'quantity' => $quantity,
        'amount' => $amount,
        'buyer_id' => $buyer,
        'product_id' => $product,

    ];
});
