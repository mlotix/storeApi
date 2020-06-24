<?php

namespace App\Http\Controllers\Brand;

use App\Brand;
use App\Http\Controllers\ApiController;
use App\Product;
use Illuminate\Http\Request;

class BrandProductController extends ApiController
{

    public function __construct()
    {
      $this->middleware('auth:api')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Brand $brand)
    {
      $products = $brand->products;
        return $this->showAll($products);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand, Product $product)
    {
      $products = $brand->products()->where('id', $product->id)->get();
      return $this->showAll($products);
    }

}
