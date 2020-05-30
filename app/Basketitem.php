<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Buyer;
use App\Product;
use App\Transformers\BasketitemTransformer;

class Basketitem extends Model
{
    protected $fillable = [
      'quantity',
      'buyer_id',
      'product_id',
    ];

    public $transformer = BasketitemTransformer::class;
    
    public function buyer() {
      return $this->belongsTo(Buyer::class);
    }
    public function product() {
      return $this->belongsTo(Product::class);
    }
}
