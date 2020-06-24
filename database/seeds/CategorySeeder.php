<?php

use Illuminate\Database\Seeder;
use App\Category;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::flushEventListeners();
        $json = File::get("database/custom_data/categories.json");
        $data = json_decode($json);

        foreach ($data as $obj) {
          Category::create(array(
            'id' => $obj->id,
            'name' => $obj->name,
            'description' => $obj->description,
            'parent_id' => $obj->parent_id,
          ));
        }
    }
}
