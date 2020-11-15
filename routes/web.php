<?php

use App\Http\Controllers\CartContrller;

Auth::routes();

Route::redirect('/', '/home');

Route::get('/home', 'HomeController@index')->name('home'); //home controller items list (Home)

Route::get('/add-to-cart/{product_id}','CartContrller@add')->name('cart.add')->middleware('auth');   //Authentication user check

Route::get('/cart','CartContrller@index')->name('cart.index'); //load cart table (normal)

Route::get('/cart/load','CartContrller@load_cart_items_ajax')->name('cart.load_cart_items_ajax'); //load cart table (ajax)

Route::get('/cart/destroy{item_id}','CartContrller@destroy')->name('cart.destroy')->middleware('auth');//cart item delete 

Route::get('/cart/update{item_id}','CartContrller@update')->name('cart.update')->middleware('auth'); //old cart items plus-minus 

Route::get('/cart/update','CartContrller@update_ajax')->name('cart.update_ajax')->middleware('auth'); //cart items plus/minus with ajax

Route::get('/cart/update','CartContrller@update_ajax2')->name('cart.update_ajax2')->middleware('auth'); //cart items plus/minus with ajax

Route::get('/cart/checkout','CartContrller@checkout')->name('cart.checkout')->middleware('auth'); //checkout 
//route::resource()  can delete /update/add ,...in same controller 
Route::resource('orders','OrderController')->middleware('auth'); //Order controller  

Route::get('paypal/checkout','PaypalController@getExpressCheckout'); //paypal controller 

Route::get('paypal/checkout-success','PaypalController@getExpressCheckoutsuccess')->name('paypal.success'); //paypal controller sucess

Route::get('paypal/checkout-cancel','PaypalController@CancelPage')->name('paypal.cancel'); //paypal controller cancel 
