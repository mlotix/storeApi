<?php

namespace App\Http\Controllers\Brand;

use App\Brand;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class BrandCategoryController extends ApiController
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
        $categories = $brand->products()->with('categories')->get()->pluck('categories')->collapse()->unique();

        return $this->showAll($categories);
    }
}
