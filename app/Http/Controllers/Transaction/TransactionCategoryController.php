<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Transaction;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class TransactionCategoryController extends ApiController
{
  public function __construct()
  {
    Parent::__construct();
    $this->middleware('scope:read-stats')->only('index');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Transaction $transaction) //admin only method
    {
      Gate::authorize('make-admin-action');

        $categories = $transaction->product->categories;

        return $this->showAll($categories);
    }

}
