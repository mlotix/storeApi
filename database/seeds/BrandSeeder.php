<?php

use Illuminate\Database\Seeder;
use App\Brand;
class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Brand::flushEventListeners();
        //factory(Brand::class, 20)->create();
        $json = File::get("database/custom_data/brands.json");
        $data = json_decode($json);

        foreach ($data as $obj) {
          Brand::create(array(
            'id' => $obj->id,
            'name' => $obj->name,
            'description' => $obj->description,
          ));
        }
    }
}
