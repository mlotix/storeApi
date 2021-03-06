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
//categories brands
Route::resource('categories.brands', 'Category\CategoryBrandController', ['only' => ['index']]);
//categories childs
Route::get('/categories/{category}/childs', 'Category\CategoryController@childs')->name('category_childs');

//Brands
Route::resource('brands', 'Brand\BrandController', ['except' => ['create', 'edit']]);
//brands categories
Route::resource('brands.categories', 'Brand\BrandCategoryController', ['only' => ['index']]);
//brands products
Route::resource('brands.products', 'Brand\BrandProductController', ['only' => ['index', 'show']]);
//brands sellers
Route::resource('brands.sellers', 'Brand\BrandSellerController', ['only' => ['index']]);
//brands transactions
Route::resource('brands.transactions', 'Brand\BrandTransactionController', ['only' => ['index']]);


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
//products brand
Route::resource('products.brand', 'Product\ProductBrandController', ['only' => ['index']]);

//Basket
Route::resource('basketitems', 'Basketitem\BasketitemController', ['only' => ['index', 'show']]);
// Basket Categories
Route::resource('basketitems.categories', 'Basketitem\BasketitemCategoryController', ['only' => ['index']]);
//Basket Brands
Route::resource('basketitems.brands', 'Basketitem\BasketitemBrandController', ['only' => ['index']]);

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
//transaction brand
Route::resource('transactions.brand', 'Transaction\TransactionBrandController', ['only' => ['index']]);

//Users
Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);
Route::get('user', 'User\UserController@single')->name('singleUser');

//verify users
Route::get('/verify/{token}', 'User\UserController@verify')->name('verify');

//resend Verify
Route::get('/verify/new/{email}', 'User\UserController@resend_verify')->name('resend_verify');
Route::get('/verify/update/{email}', 'User\UserController@resend_update')->name('resend_update');

//oauth2 token
Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken')->middleware('cors');

//login and logout
Route::post('login', 'User\UserController@login')->name('login');
Route::post('refresh', 'User\UserController@refresh')->name('refresh_token');
Route::get('logout', 'User\UserController@logout')->name('logout');
