<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Basketitem;

class BasketitemTransformer extends TransformerAbstract
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
    public function transform(Basketitem $basketitem)
    {
      return [
          'id' => (int)$basketitem->id,
          'quantity' => (int)$basketitem->quantity,
          'product' => $basketitem->product()->get(array('id', 'name', 'price', 'quantity', 'status', 'image')),
          'buyer_id' => (int)$basketitem->buyer_id,
          'addedDate' => (string)$basketitem->created_at,

          'links' => [
            'basketitem.categories' => [
              'href' => route('basketitems.categories.index', $basketitem->id)
            ],
            'basketitem.brands' => [
              'href' => route('basketitems.brands.index', $basketitem->id)
            ],
          ]
      ];
    }

    public static function attributeMap($index) {
      $attributes = [
        'id' => 'id',
        'quantity' => 'quantity',
        'product' => 'product_id',
        'buyer' => 'buyer_id',
        'addedDate' => 'created_at',
      ];

      return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
