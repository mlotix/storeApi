<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Brand;
class BrandTransformer extends TransformerAbstract
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
     public function transform(Brand $brand)
     {
       return [
           'id' => (int)$brand->id,
           'name' => (string)$brand->name,
           'desc' => (string)$brand->description,
           'creationDate' => (string)$brand->created_at,

           'links' => [
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
