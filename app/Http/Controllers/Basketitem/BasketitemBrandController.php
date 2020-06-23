<?php

namespace App\Http\Controllers\Basketitem;

use App\Basketitem;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class BasketitemBrandController extends ApiController
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
      $brands = $basketitem->product->brand;

      return $this->showAll($brands);
    }

}
