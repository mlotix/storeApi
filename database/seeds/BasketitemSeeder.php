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
      Basketitem::flushEventListeners();
      factory(Basketitem::class, 300)->create();
    }
}
