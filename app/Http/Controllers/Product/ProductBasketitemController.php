<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Product;
use App\Busketitem;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class ProductBasketitemController extends ApiController
{
  public function __construct()
  {
    Parent::__construct();
    $this->middleware('scope:read-stats')->only('index');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product) //admin only
    {
        Gate::authorize('make-admin-action');

        $products = $product->basketitems;

        return $this->showAll($products);
    }
}
