<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Transaction;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class BuyerTransactionController extends ApiController
{
  public function __construct()
  {
    Parent::__construct();
    $this->middleware('scope:read-stats')->only('index');
    $this->middleware('can:view,buyer')->only('index');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $transactions = $buyer->transactions;

        return $this->showAll($transactions);
    }

}
