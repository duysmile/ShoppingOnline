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

Route::get('/', 'Client\HomeController@index')->name('home');
Route::get('/detail/{slug}', 'Client\HomeController@detailProduct')->name('detail-product');
Route::get('/list/{category}', 'Client\HomeController@list')->name('list-products');
Route::get('/product/search', 'Client\HomeController@searchProduct')->name('product.search');

Route::group([
    'middleware' => 'guest'
], function () {
    Route::post('/login', 'Client\LoginController@postLogin')->name('login');
    Route::post('/signup', 'Client\SignUpController@postSignup')->name('signup');
    Route::post('/password-reset', 'Client\PasswordResetController@postToken')->name('password-reset-send');

    Route::get('/user/verify/{token}', 'Client\SignUpController@verifyEmail')->name('verify_email');
    Route::get('/user/forgot-password/{token}', 'Client\PasswordResetController@reset');
    Route::post('/user/forgot-password', 'Client\PasswordResetController@storeNewPass')->name('reset_password');

    Route::get('/redirect/{social}', 'Client\SocialAuthController@redirect')->name('login_social');
    Route::get('/callback/{social}', 'Client\SocialAuthController@callback');
});

Route::group([
    'middleware' => 'auth'
], function () {
    Route::get('/cart', 'Client\CartController@index')->name('cart');

    Route::post('/add-cart', 'Client\CartController@addCartOneItem')->name('add-cart');
    Route::patch('/update-cart-item', 'Client\CartController@updateQtyItem')->name('update-cart');
    Route::delete('/delete-cart-item', 'Client\CartController@deleteItem')->name('delete-item-card');

    Route::post('/checkout', 'Client\PaymentController@confirmInvoice')->name('confirm-invoice');
    Route::post('/buy-product', 'Client\PaymentController@addInvoice')->name('buy-product');

    Route::get('/profile', 'Client\ProfileController@index')->name('profile-user');
    Route::post('/update-profile', 'Client\ProfileController@update')->name('update-profile');
    Route::post('/invoices/load', 'Client\ProfileController@loadInvoices')->name('load-invoices');
    Route::post('/invoices/confirm', 'Client\ProfileController@confirm')->name('invoices-client.confirm');
    Route::delete('/invoices/cancel', 'Client\ProfileController@cancel')->name('invoices-client.cancel');

    Route::get('/logout', 'Client\LoginController@logout')->name('logout');

    Route::get('error', function() {
        return view('client.error', ['message' => 'Hello']);
    });
});

Route::group([
    'middleware' => ['role:staff,admin'],
    'prefix' => 'admin'
], function () {
    Route::resource('products', 'Admin\ProductsController');
    Route::get('/invoices/in-progress', 'Admin\InvoicesController@inProgress')->name('invoices.in-progress');
    Route::get('/invoices/in-transport', 'Admin\InvoicesController@inTransport')->name('invoices.in-transport');
    Route::get('/invoices/in-success', 'Admin\InvoicesController@inSuccess')->name('invoices.in-success');
    Route::get('/invoices/in-canceled', 'Admin\InvoicesController@inCanceled')->name('invoices.in-canceled');

    Route::patch('/invoices/update-status', 'Admin\InvoicesController@updateStatus')->name('invoices.update-status');
    Route::patch('/invoices/update-status/{id}', 'Admin\InvoicesController@updateStatusDetail')->name('invoices.update-status-detail');
    Route::delete('/invoices/cancel', 'Admin\InvoicesController@cancel')->name('invoices.cancel');
    Route::get('/invoices/{id}', 'Admin\InvoicesController@showDetail')->name('invoices.detail');

    Route::resource('categories', 'Admin\CategoryController')->middleware('role:admin');
    Route::resource('users', 'Admin\UserController')->middleware('role:admin');
    Route::get('/staff', 'Admin\UserController@getStaff')->name('users.staff')->middleware('role:admin');

    Route::get('/revenue', 'Admin\DashboardController@getRevenue')->name('dashboard.revenue');
    Route::get('/order', 'Admin\DashboardController@getOrder')->name('dashboard.order');

    Route::group([
        'prefix' => 'approve',
        'middleware' => 'role:admin'
    ], function () {
        Route::get('/', 'Admin\ApproveController@index')->name('approve.index');
        Route::patch('/', 'Admin\ApproveController@approve')->name('approve.update');
    });
    Route::get('/', 'Admin\DashboardController@index')->name('admin');
});
