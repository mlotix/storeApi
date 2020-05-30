<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Seller;

class SellerTransformer extends TransformerAbstract
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
    public function transform(Seller $seller)
    {
      return [
          'id' => (int)$seller->id,
          'name' => (string)$seller->name,
          'email' => (string)$seller->email,
          'verified' => ($seller->verified === '1'),

          'links' => [
            'seller.products' => [
              'href' => route('sellers.products.index', $seller->id)
            ],
            'seller.transactions' => [
              'href' => route('sellers.transactions.index', $seller->id)
            ],
          ],
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
