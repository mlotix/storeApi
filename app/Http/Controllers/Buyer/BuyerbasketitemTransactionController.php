<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Transaction;
use App\Basketitem;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class BuyerbasketitemTransactionController extends ApiController
{
  public function __construct()
  {
    Parent::__construct();
    $this->middleware('scope:purchase-product')->only(['store']);
    $this->middleware('can:purchase,buyer')->only('store');
  }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Buyer $buyer, Basketitem $basketitem)
    {
        /*$rules = [
          'quantity' => 'required|Integer|gt:0|lt:100',
        ];

        $quantity = $request->validate($rules);
        $quantity = $quantity['quantity'];*/
        $product = $basketitem->product;

        if($basketitem->buyer_id != $buyer->id){
          return $this->errorResponse('This item is not in the basket', 403);
        }
        $quantity = $basketitem->quantity;

        if($quantity > $product->quantity){
          $message = 'There are only ' . $product->quantity . ' items available';
          return $this->errorResponse($message, 422);
        }

        $product->quantity = $product->quantity - $quantity;
        if($product->quantity<0){
          $product->quantity = 0;
        }
        $product->save();

        $price = $product->price;
        $amount = $quantity*$price;
        $data = ['quantity' => $quantity, 'amount' => $amount, 'buyer_id' => $buyer->id, 'product_id' => $product->id];

        $transaction = Transaction::create($data);

        $basketitem->delete();

        return $this->showOne($transaction, 201);
    }

}
