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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/detail', function() {
   return view('detail');
});

Route::get('/list', function() {
    return view('list_products');
});

Route::get('/cart', function() {
    return view('cart');
});

Route::get('/profile', function() {
    return view('profile');
});

Route::get('/admin', function() {
    return view('admin');
});

Route::prefix('admin')->group(function() {
//    Route::resource('products', 'ProductsController');
//    Route::resource('invoices', 'InvoicesController');
//    Route::resource('Users', 'UsersController');
    Route::get('/products', function () {
        return view('admin.products.show');
    });
    Route::get('/products/create', function () {
        return view('admin.products.add');
    });
});
