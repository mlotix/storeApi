<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Buyer;

class BuyerTransformer extends TransformerAbstract
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
    public function transform(Buyer $buyer)
    {
      return [
          'id' => (int)$buyer->id,
          'name' => (string)$buyer->name,
          'email' => (string)$buyer->email,
          'verified' => ($buyer->verified === '1'),

          'links' => [
            'buyer.basketitems' => [
              'href' => route('buyers.basketitems.index', $buyer->id)
            ]
          ],
          'buyer.transactions' => [
            'href' => route('buyers.transactions.index', $buyer->id)
          ]
      ];
    }

    public static function attributeMap($index) {
      $attributes = [
        'id' => 'id',
        'name' => 'name',
        'email' => 'email',
        'verified' => 'verified',
        'created_at' => 'created_at',
        'creationDate' => 'created_at',
      ];

      return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
