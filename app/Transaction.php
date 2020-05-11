<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\Buyer;


class Transaction extends Model
{
    protected $fillable = [
      'quantity',
      'buyer_id',
      'product_id',
    ];

    public function buyer() {
      $this->belongsTo(Buyer::class);
    }

    public function product() {
      $this->belongsTo(Product::class);
    }
}
