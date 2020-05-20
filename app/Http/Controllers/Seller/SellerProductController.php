<?php

namespace App\Http\Controllers\Seller;
use App\Http\Controllers\ApiController;
use App\Seller;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SellerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $products = $seller->products;

        return $this->showAll($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Seller $seller)
    {
      $rules = [
        'name' => 'required|min:3|max:64|string',
        'description' => 'min:3|string',
        'price' => 'numeric|gt:0|lt:100000|required',
        'quantity' => 'required|integer|gt:-1|lt:100000',
        'image' => 'required|string|min:3',
        'categories' => 'required|array',
        'categories.*' => 'integer|gt:0',
      ];
      $data = $request->validate($rules);

      $product = [
        'name' => $data['name'],
        'description' => $data['description'],
        'price' => $data['price'],
        'quantity' => $data['quantity'],
        'status' => $data['quantity'] == 0 ? Product::UNAVAILABLE_PRODUCT : Product::AVAILABLE_PRODUCT,
        'image' => $data['image'],
        'seller_id' => $seller->id,
      ];

      $product = Product::create($product);

      $categories = $data['categories'];
      $product->categories()->sync($categories);

      return $this->showOne($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller, Product $product)
    {
      $product = $seller->products->where('id', $product->id);

      return $this->showAll($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller, Product $product)
    {
      $rules = [
        'name' => 'min:3|max:64|string',
        'description' => 'min:3|string',
        'price' => 'numeric|gt:0|lt:100000',
        'quantity' => 'integer|gt:-1|lt:100000',
        'image' => 'string|min:3',
        'categories' => 'array',
        'categories.*' => 'integer|gt:0',
      ];
      $data = $request->validate($rules);

      if($request->filled('name')) {
        $product->name = $request->name;
      }
      if($request->filled('description')) {
        $product->description = $request->description;
      }
      if($request->filled('price')) {
        $product->price = $request->price;
      }
      if($request->filled('quantity')) {
        $product->quantity = $request->quantity;
      }
      if($request->filled('image')) {
        $product->image = $request->image;
      }
      if($request->filled('categories')) {
        $product->categories()->sync($request->categories);
      }

      if($product->isClean() && !$request->categories) {
        return $this->errorResponse('Nothing has changed', 422);
      }

        $product->save();

        return $this->showOne($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller, Product $product)
    {
        if($product->seller_id != $seller->id) {
          return $this->errorResponse('This product does not belong to you', 401);
        }

        $product->delete();

        DB::table('basketitems')->where('product_id', $product->id)->delete();

        return $this->showOne($product);
    }
}
