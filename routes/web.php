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
Route::get('/detail', function () {
    return view('detail');
});
Route::get('/list', function () {
    return view('list_products');
});
Route::get('/home', 'HomeController@index')->name('home');

Route::group([
    'middleware' => 'guest'
], function () {
    Route::post('/login', 'LoginController@postLogin')->name('login');
    Route::post('/signup', 'SignUpController@postSignup')->name('signup');
    Route::post('/password-reset', 'PasswordResetController@postToken')->name('password-reset-send');

    Route::get('/user/verify/{token}', 'SignUpController@verifyEmail')->name('verify_email');
    Route::get('/user/forgot-password/{token}', 'PasswordResetController@reset');
    Route::post('/user/forgot-password', 'PasswordResetController@storeNewPass')->name('reset_password');

    Route::get('/redirect/{social}', 'SocialAuthController@redirect')->name('login_social');
    Route::get('/callback/{social}', 'SocialAuthController@callback');
});

Route::group([
    'middleware' => 'auth'
], function () {
    Route::get('/cart', function () {
        return view('cart');
    });

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile-user');

    Route::get('/logout', 'LoginController@logout')->name('logout');
});

Route::group([
    'middleware' => 'role:admin',
    'prefix' => 'admin'
], function () {
//    Route::resource('products', 'ProductsController');
//    Route::resource('invoices', 'InvoicesController');
//    Route::resource('users', 'UsersController');
    Route::get('/', function (){
       return view('admin');
    })->name('admin');
    Route::get('/products', function () {
        return view('admin.products.show');
    });
    Route::get('/products/create', function () {
        return view('admin.products.add');
    });
});
