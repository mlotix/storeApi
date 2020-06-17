<?php

namespace App\Http\Controllers\Basketitem;

use App\Basketitem;
use App\Product;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class BasketitemCategoryController extends ApiController
{
  public function __construct()
  {
    Parent::__construct();
    $this->middleware('can:view,basketitem')->only('index');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Basketitem $basketitem)
    {
      $categories = $basketitem->product->categories;

      return $this->showAll($categories);
    }
}
