<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Product;
use App\Transformers\BrandTransformer;

class Brand extends Model
{
    use SoftDeletes;

    protected $fillable = [
      'name',
      'description',
    ];
    
    public function products() {
      return $this->hasMany(Product::class);
    }

    public $transformer = BrandTransformer::class;
}
