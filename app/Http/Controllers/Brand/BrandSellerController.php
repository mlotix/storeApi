<?php

namespace App\Http\Controllers\Brand;

use App\Brand;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class BrandSellerController extends ApiController
{

    public function __construct()
    {
      $this->middleware('auth:api')->except(['index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Brand $brand)
    {
        $sellers = $brand->products()->with('seller')->get()->pluck('seller')->unique();
        return $this->showAll($sellers);
    }

}
