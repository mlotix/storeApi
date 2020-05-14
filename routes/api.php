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

//Categories
Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);

//Products
Route::resource('products', 'Product\ProductController', ['only' => ['index', 'show']]);
//Products Transaction
Route::resource('products.transactions', 'Product\ProductTransactionController', ['only' => ['index']]);
//Products buyers
Route::resource('products.buyers', 'Product\ProductBuyerController', ['only' => ['index']]);
//Products categories
Route::resource('products.categories', 'Product\ProductCategoryController', ['except' => ['edit', 'create', 'store']]);

//Sellers
Route::resource('sellers', 'Seller\SellerController', ['only' => ['index', 'show']]);

//transactions
Route::resource('transactions', 'Transaction\TransactionController', ['only' => ['index', 'show']]);
//transaction Categories
Route::resource('transactions.categories', 'Transaction\TransactionCategoryController', ['only' => ['index']]);
//transaction Seller
Route::resource('transactions.seller', 'Transaction\TransactionSellerController', ['only' => ['index']]);

//Users
Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);
