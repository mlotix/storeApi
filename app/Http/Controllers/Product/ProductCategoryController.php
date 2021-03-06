<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Product;
use App\Category;
use Illuminate\Http\Request;

class ProductCategoryController extends ApiController
{
  public function __construct()
  {
    $this->middleware('auth:api')->except('index');
    $this->middleware('scope:manage-products')->except('index');
    $this->middleware('can:update,product')->only('update');
    $this->middleware('can:delete,product')->only('destroy');

  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $categories = $product->categories->makeHidden('pivot');

        return $this->showAll($categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, Category $category)
    {
      $product->categories()->syncWithoutDetaching($category->id);

      return $this->showAll($product->categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Category $category)
    {
      $product->categories()->detach($category->id);

      return $this->showAll($product->categories);
    }
}
