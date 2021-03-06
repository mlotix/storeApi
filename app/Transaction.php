<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\Buyer;
use App\Transformers\TransactionTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;


class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
      'quantity',
      'amount',
      'buyer_id',
      'product_id',
    ];

    public $transformer = TransactionTransformer::class;

    public function buyer() {
      return $this->belongsTo(Buyer::class);
    }

    public function product() {
      return $this->belongsTo(Product::class);
    }
}
