<?php

use Illuminate\Http\Request;

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



/**
 * Buyers
 */
Route::resource('buyers','Buyer\BuyerController',['only' =>['index','show']]);
Route::resource('buyers.transactions','Buyer\BuyerTransactionController',['only' =>['index']]);
Route::resource('buyers.products','Buyer\BuyerProductController',['only' =>['index']]);
Route::resource('buyers.sellers','Buyer\BuyerSellerController',['only' =>['index']]);

/**
 * Categories
 */
Route::resource('categories','Category\CategoryController',['except' =>['create','edit']]);

/**
 * Products
 */
Route::resource('products','Product\ProductController',['only' =>['index','show']]);

/**
 * Sellers
 */
Route::resource('sellers','Seller\SellerController',['only' =>['index','show']]);

/**
 * Transactions
 */
Route::resource('transactions','Transaction\TransactionController',['only' =>['index','show']]);
//
//como trabajaremos con 2 recurso en esta ruta el nombre de la rta sera precedido delos modelos involucrados
//separados atravez de un punto
Route::resource('transactions.categories','Transaction\TransactionCategoryController',['only' =>['index']]);
Route::resource('transactions.sellers','Transaction\TransactionSellerController',['only' =>['index']]);


/**
 * Users
 */
Route::resource('users','user\UserController',['except' =>['create','edit']]);


