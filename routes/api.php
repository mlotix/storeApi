<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Buyers
Route::resource('buyers', 'Buyer\BuyerController', ['only' => ['index', 'show']]);
//Buyers transactions
Route::resource('buyers.transactions', 'Buyer\BuyerTransactionController', ['only' => ['index']]);
//Buyers Basket
Route::resource('buyers.basketitems', 'Buyer\BuyerBasketitemController', ['except' => ['create', 'edit']]);
//Buyers Basket Transactions
Route::resource('buyers.basketitems.transactions', 'Buyer\BuyerBasketitemTransactionController', ['only' => ['store']]);

//Categories
Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);
//Categories Products
Route::resource('categories.products', 'Category\CategoryProductController', ['only' => ['index']]);

//Products
Route::resource('products', 'Product\ProductController', ['only' => ['index', 'show']]);
//Products Transaction
Route::resource('products.transactions', 'Product\ProductTransactionController', ['only' => ['index']]);
//Products buyers
Route::resource('products.buyers', 'Product\ProductBuyerController', ['only' => ['index']]);
//Products categories
Route::resource('products.categories', 'Product\ProductCategoryController', ['except' => ['edit', 'create', 'store']]);
//Products Basket
Route::resource('products.basketitems', 'Product\ProductBasketitemController', ['only' => ['index']]);

//Basket
Route::resource('basketitems', 'Basketitem\BasketitemController', ['only' => ['index', 'show']]);
// Basket Categories
Route::resource('basketitems.categories', 'Basketitem\BasketitemCategoryController', ['only' => ['index']]);

//Sellers
Route::resource('sellers', 'Seller\SellerController', ['only' => ['index', 'show']]);
//Sellers Products
Route::resource('sellers.products', 'Seller\SellerProductController', ['except' => ['create', 'edit']]);
//Sellers Transactions
Route::resource('sellers.transactions', 'Seller\SellerTransactionController', ['only' => ['index']]);

//transactions
Route::resource('transactions', 'Transaction\TransactionController', ['only' => ['index', 'show']]);
//transaction Categories
Route::resource('transactions.categories', 'Transaction\TransactionCategoryController', ['only' => ['index']]);
//transaction Seller
Route::resource('transactions.seller', 'Transaction\TransactionSellerController', ['only' => ['index']]);

//Users
Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);
