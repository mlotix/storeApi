<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
      'name',
      'description',
    ];
    protected $hidden = [
      'pivot',
    ];

    public $transformer = CategoryTransformer::class;

    public function products() {
      return $this->belongsToMany(Product::class);
    }
}
