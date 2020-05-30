<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Basketitem;
use App\Product;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class BuyerBasketitemController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $basket = $buyer->basketitems;

        return $this->showAll($basket);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Buyer $buyer)
    {
      $rules = [
        'product_id' => 'Integer|gt:0|required',
        'quantity' => 'Integer|gt:0|lt:100|required',
      ];
      $data = $request->validate($rules);

      $product = Product::findOrFail($data['product_id']);
      $buyer_id = $buyer->id;

      $check = ['product_id' => $data['product_id'], 'buyer_id' => $buyer_id];

      if(Basketitem::where($check)->exists()){
        return $this->errorResponse('This item is already in the backet', 422);
      }

      $basketitem = ['product_id' => $data['product_id'], 'quantity' => $data['quantity'], 'buyer_id' => $buyer_id];
      $basketitem = Basketitem::create($basketitem);

      return $this->showOne($basketitem, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $buyer, Basketitem $basketitem)
    {
      $item = $buyer->basketitems()->where('id', '=', $basketitem->id)->get();
      return $this->showAll($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Buyer $buyer, Basketitem $basketitem)
    {
        $rules = [
          'quantity' => 'required|Integer|gt:0|lt:100',
        ];

        $data = $request->validate($rules);
        $quantity = $data['quantity'];

        if($basketitem->buyer_id != $buyer->id){
          return $this->errorResponse('This item is not in the basket', 403);
        }

        if($quantity == $basketitem->quantity) {
          return $this->errorResponse('Nothing has changed', 422);
        }
        else {
          $basketitem->quantity = $quantity;
        }
        $basketitem->save();

        return $this->showOne($basketitem);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Buyer $buyer, Basketitem $basketitem)
    {
      if($basketitem->buyer_id != $buyer->id){
        return $this->errorResponse('This item is not in the basket', 403);
      }

      $basketitem->delete();

      return $this->showOne($basketitem);
    }
}
