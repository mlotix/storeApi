<?php

namespace App\Http\Controllers\Basketitem;

use App\Basketitem;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BasketitemController extends ApiController
{
  public function __construct()
  {
    Parent::__construct();
    $this->middleware('scope:read-stats')->only('show');
    $this->middleware('can:view,basketitem')->only('show');

  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() //admin only method
    {
      Gate::authorize('make-admin-action');

      $items = Basketitem::all();

      return $this->showAll($items);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Basketitem  $basketitems
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Basketitem::findOrFail($id);
        return $this->showOne($item);
    }

}
