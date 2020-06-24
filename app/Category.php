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
      'parent_id',
    ];
    protected $hidden = [
      'pivot',
    ];

    public $transformer = CategoryTransformer::class;

    public function products() {
      return $this->belongsToMany(Product::class);
    }
    public function childs() {
      return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
