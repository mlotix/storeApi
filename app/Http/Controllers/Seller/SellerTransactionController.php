<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Seller;
use App\Transaction;
use Illuminate\Http\Request;

class SellerTransactionController extends ApiController
{
  public function __construct()
  {
    Parent::__construct();
    $this->middleware('scope:read-stats')->only('index');
    $this->middleware('can:view,seller')->only('index');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
      $transactions = $seller->products()->whereHas('transactions')->with('transactions')->get();

      return $this->showAll($transactions);

    }
}
