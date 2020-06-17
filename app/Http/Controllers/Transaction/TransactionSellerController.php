<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Transaction;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class TransactionSellerController extends ApiController
{
  public function __construct()
  {
    Parent::__construct();
    $this->middleware('scope:read-stats');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Transaction $transaction)   //admin only method
    {
      Gate::authorize('make-admin-action');

      $seller = $transaction->product->seller;

      return $this->showOne($seller);
    }
}
