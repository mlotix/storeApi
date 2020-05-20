<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Transaction;
use App\Basketitem;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class BuyerbasketitemTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $buyer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function edit(Buyer $buyer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Buyer $buyer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Buyer $buyer)
    {
        //
    }
}
