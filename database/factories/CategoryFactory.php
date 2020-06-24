<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function () {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'parent_id' => null,
    ];
});
