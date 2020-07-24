<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class BuyerController extends ApiController
{
  public function __construct()
  {
    Parent::__construct();
    $this->middleware('scope:read-stats')->only(['show', 'index']);
    $this->middleware('can:view,buyer')->only('show');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() //admin only method
    {
      //Gate::authorize('make-admin-action');

      $buyers = Buyer::has('transactions')->get();
      return $this->showAll($buyers);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $buyer)
    {
      $buyer = Buyer::has('transactions')->findOrFail($buyer->id);
      return $this->showOne($buyer);
    }

}
