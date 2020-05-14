<?php

namespace App\Http\Controllers\Basketitem;

use App\Basketitem;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class BasketitemController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
