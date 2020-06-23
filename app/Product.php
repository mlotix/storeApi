<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Seller;
use App\Transaction;
use App\Basketitem;
use App\Brand;
use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
  use SoftDeletes;

  const AVAILABLE_PRODUCT = 'available';
  const UNAVAILABLE_PRODUCT = 'unavailable';

  public $transformer = ProductTransformer::class;

    protected $fillable = [
      'name',
      'description',
      'price',
      'quantity',
      'status',
      'image',
      'brand_id',
      'seller_id',
    ];

    public function isAvailable() {
      return $this->status == Product::AVAILABLE_PRODUCT;
    }

    public function categories() {
      return $this->belongsToMany(Category::class);
    }
    public function seller() {
      return $this->belongsTo(Seller::class);
    }
    public function transactions() {
      return $this->hasMany(Transaction::class);
    }
    public function basketitems() {
      return $this->hasMany(Basketitem::class);
    }
    public function brand() {
      return $this->belongsTo(Brand::class);
    }
}
