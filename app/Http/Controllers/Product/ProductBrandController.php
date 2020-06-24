<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Product;
use Illuminate\Http\Request;

class ProductBrandController extends ApiController
{
    public function __construct()
    {
      $this->middleware('auth:api')->except('index');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
      $brand = $product->brand;

      return $this->showOne($brand);
    }

}
