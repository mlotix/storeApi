<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Category;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::flushEventListeners();
        factory(Product::class, 100)->create()->each(
          function($product) {
            $categories = Category::all()->random(rand(1,5))->pluck('id');
            $product->categories()->attach($categories);
          }
        );
    }
}
