<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Category;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Category $category)
    {
      return [
          'id' => (int)$category->id,
          'name' => (string)$category->name,
          'desc' => (string)$category->description,
          'creationDate' => (string)$category->created_at,

          'links' => [
            'category.products' => [
              'href' => route('categories.products.index', $category->id)
            ]
          ],
      ];
    }

    public static function attributeMap($index) {
      $attributes = [
        'id' => 'id',
        'name' => 'name',
        'desc' => 'description',
        'creationDate' => 'created_at',
      ];

      return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
