<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Transaction;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class TransactionController extends ApiController
{
  public function __construct()
  {
    Parent::__construct();
    $this->middleware('scope:read-stats');
    $this->middleware('can:view,transaction')->only('show');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()   //admin only method
    {
      Gate::authorize('make-admin-action');

      $transactions = Transaction::all();

      return $this->showAll($transactions);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
      return $this->showOne($transaction);
    }

}
