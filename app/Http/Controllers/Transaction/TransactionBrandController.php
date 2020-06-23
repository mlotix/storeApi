<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionBrandController extends Controller
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

         $brands = $transaction->product->brand;

         return $this->showAll($brands);
     }
}
