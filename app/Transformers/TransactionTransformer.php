<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Transaction;

class TransactionTransformer extends TransformerAbstract
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
    public function transform(Transaction $transaction)
    {
      return [
          'id' => (int)$transaction->id,
          'quantity' => (int)$transaction->quantity,
          'amount' => (float)$transaction->amount,
          'buyer' => $transaction->buyer()->get(array('id', 'name')),
          'product' => $transaction->product()->get(array('id','name')),
          'date' => (string)$transaction->created_at,

          'links' => [
            'transaction.categories' => [
              'href' => route('transactions.categories.index', $transaction->id)
            ],
            'transaction.sellers' => [
              'href' => route('transactions.seller.index', $transaction->id)
            ],
          ],
      ];
    }

    public static function attributeMap($index) {
      $attributes = [
        'id' => 'id',
        'quantity' => 'quantity',
        'amount' => 'amount',
        'buyer' => 'buyer_id',
        'product' => 'product_id',
        'date' => 'created_at',
      ];

      return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
