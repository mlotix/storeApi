<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Product;

class ProductTransformer extends TransformerAbstract
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
    public function transform(Product $product)
    {
        return [
            'id' => (int)$product->id,
            'name' => (string)$product->name,
            'desc' => (string)$product->description,
            'price' => (float)$product->price,
            'quantity' => (int)$product->quantity,
            'status' => (string)$product->status,
            'image' => url("img/{$product->image}"),
            'brand' => $product->brand()->get(array('id', 'name')),
            'seller' => $product->seller()->get(array('id', 'name')),
            'creationDate' => (string)$product->created_at,

            'links' => [
              'product.basketitems' => [
                'href' => route('products.basketitems.index', $product->id)
              ],
              'product.buyers' => [
                'href' => route('products.buyers.index', $product->id)
              ],
              'product.categories' => [
                'href' => route('products.categories.index', $product->id)
              ],
              'product.transactions' => [
                'href' => route('products.transactions.index', $product->id)
              ],
              'product.brand' => [
                'href' => route('products.brand.index', $product->id)
              ],
            ],
        ];
    }

    public static function attributeMap($index) {
      $attributes = [
        'id' => 'id',
        'name' => 'name',
        'desc' => 'description',
        'price' => 'price',
        'quantity' => 'quantity',
        'status' => 'status',
        'seller' => 'seller_id',
        'brand' => 'brand_id',
        'creationDate' => 'created_at',
      ];

      return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
