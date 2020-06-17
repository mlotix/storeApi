<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Product;
use Illuminate\Http\Request;

class ProductBuyerController extends ApiController
{
  public function __construct()
  {
    Parent::__construct();
    $this->middleware('scope:read-stats')->only('index');
    $this->middleware('can:view,product')->only('index');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
      $buyers = $product->transactions()->with('buyer')->get()->pluck('buyer')->unique(); //przerobic zeby byla ilosc i buyer

      return $this->showAll($buyers);
    }
}
