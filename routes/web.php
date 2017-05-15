<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
auth()->loginUsingId(1);

Route::get('/', function () {
  //  return view('shop.index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/products', 'ProductsController@index')->name('product.index');
Route::get('/profile', 'ProfileController@index')->name('user.profile');


Route::get('/add-to-cart/{id}','ProductsController@getAddToCart')->name('product.addToCart');
Route::get('/reduce/{id}','ProductsController@getReduceByOne')->name('product.reduceByOne');
Route::get('/remove/{id}','ProductsController@getRemoveItemFromCart')->name('product.removeFromCart');

Route::get('/shopping-cart','ProductsController@getCart')->name('product.shoppingCart');

Route::get('/checkout','ProductsController@getCheckout')->name('checkout');
Route::post('/checkout','ProductsController@postCheckout')->name('checkout');

Route::get('/customers', 'CustomersController@index')->name('customers');

Route::get('api/customers', 'CustomersController@getData')->name('customers.data');