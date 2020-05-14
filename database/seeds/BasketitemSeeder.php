<?php

use Illuminate\Database\Seeder;
use App\Basketitem;
class BasketitemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(Basketitem::class, 200)->create();
    }
}
