<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use App\User;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 1000),
        'quantity' => $quantity = $faker->numberBetween(0,20),
        'status' => $quantity == 0 ? Product::UNAVAILABLE_PRODUCT : Product::AVAILABLE_PRODUCT,
        'image' => $faker->randomElement(['1.png', '2.png', '3.png']),
        'seller_id' => User::all()->random()->id,

    ];
});
