<?php

use App\Http\Controllers\FrontEnd\StripePaymentController;
use Illuminate\Support\Facades\Route;

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

/**
 * For check roles (permission access) for each route (function_code),
 * required each route have to a name which used to the
 * check in middleware permission and this is defined in Module, Function Management
 * @author: ThangNH
 * @created_at: 2021/10/01
 */

Route::namespace('FrontEnd')->group(function () {
    // site map
    Route::get('/sitemap.xml', 'SitemapXmlController@index')->name('frontend.sitemap');
    Route::get('/{type}-sitemap.xml', 'SitemapXmlController@taxonomy')->name('frontend.sitemap.alias');


    // Config to use ckfinder
    Route::group(['middleware' => ['auth:admin']], function () {
        Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
            ->name('ckfinder_connector');

        Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
            ->name('ckfinder_browser');
    });
    Route::get('/language/{locale}', 'Controller@language')->name('frontend.language');

    Route::get('/language/{locale}', 'Controller@language')->name('frontend.language');
    Route::get('forgot-password', 'UserController@forgotPasswordForm')->name('frontend.password.forgot.get');
    Route::post('forgot-password', 'UserController@forgotPassword')->name('frontend.password.forgot.post');
    Route::get('reset-password/{token}', 'UserController@resetPasswordForm')->name('frontend.password.reset.get');
    Route::post('reset-password', 'UserController@resetPassword')->name('frontend.password.reset.post');

    Route::get('/account', 'UserController@index')->name('frontend.account');
    Route::post('/view-detail-order', 'UserController@view_details_order')->name('frontend.view_details_order');
    Route::post('/change-account', 'UserController@changeAccount')->name('frontend.change_account');


    Route::get('/cart', 'OrderController@cart')->name('frontend.order.cart');
    Route::get('/checkout/order-received/{id}', 'OrderController@orderReceived')->name('frontend.order.received');
    Route::post('/add-to-cart', 'OrderController@addToCart')->name('frontend.order.add_to_cart');
    Route::patch('update-cart', 'OrderController@updateCart')->name('frontend.order.cart.update');
    Route::delete('remove-from-cart', 'OrderController@removeCart')->name('frontend.order.cart.remove');
    Route::get('/checkout', 'OrderController@checkout')->name('frontend.order.checkout');
    Route::get('checkout/stripe', 'StripePaymentController@stripe')->name('frontend.stripe');
    Route::post('checkout/payment', 'StripePaymentController@getPayment')->name('stripe.payment');
    Route::post('checkout/stripe', 'StripePaymentController@stripePost')->name('stripe.post');
    Route::post('/get-city', 'OrderController@getCity')->name('frontend.order.getcity');
    Route::post('/get-ship', 'OrderController@getShip')->name('frontend.order.getship');
    Route::post('order-product', 'OrderController@storeOrderProduct')->name('frontend.order.store.product');

    Route::post('/quickview', 'PageController@quickview')->name('frontend.quickview');
    Route::post('review-product', 'ReviewController@store')->name('frontend.review');
    Route::post('comment-post', 'CommentController@store')->name('frontend.comment');

    Route::get('lien-he', 'ContactController@index')->name('frontend.contact');
    Route::post('send_contact', 'ContactController@store')->name('frontend.contact.store');

    //PAYPAL
    // Route::get('create-transaction', 'PayPalController@createTransaction')->name('createTransaction');
    Route::get('process-transaction', 'PayPalController@processTransaction')->name('processTransaction');
    Route::get('success-transaction', 'PayPalController@successTransaction')->name('successTransaction');
    Route::get('cancel-transaction', 'PayPalController@cancelTransaction')->name('cancelTransaction');
    //Copon
    Route::post('add-to-coupon', 'OrderController@addToCoupon')->name('frontend.order.coupon.add');
    Route::get('del-to-coupon', 'OrderController@unset_coupon')->name('frontend.order.coupon.del');
    // wishlist
    Route::get('/wishlist', 'UserController@wishlist')->name('frontend.wishlist');
    Route::post('check_show_wishlist', 'UserController@checkWishlist')->name('frontend.wishlist.check');
    Route::post('delete_wishlist', 'UserController@deleteWishlist')->name('frontend.wishlist.delete');
    // Compare
    Route::get('/show_compare', 'ReviewController@showCompare')->name('frontend.compare.show');
    Route::post('delete_compare', 'ReviewController@deleteCompare')->name('frontend.compare.delete');
    //search
    Route::get('/json_search', 'PageController@json_search')->name('frontend.search');

    Route::prefix('user')->group(function () {
        Route::get('/login', 'LoginController@index')->name('frontend.login');
        Route::post('/login', 'LoginController@login')->name('frontend.login.post');
        Route::post('register', 'UserController@signup')->name('frontend.register');

        // Route::get('verify-account', 'UserController@verifyAccount')->name('frontend.verify_account');
        // Route::get('forgot-password', 'UserController@forgotPasswordForm')->name('frontend.password.forgot.get');
        // Route::post('forgot-password', 'UserController@forgotPassword')->name('frontend.password.forgot.post');
        // Route::get('reset-password/{token}', 'UserController@resetPasswordForm')->name('frontend.password.reset.get');
        // Route::post('reset-password', 'UserController@resetPassword')->name('frontend.password.reset.post');

        Route::group(['middleware' => ['auth:web']], function () {
            Route::get('', 'UserController@index')->name('frontend.user');
            Route::get('/logout', 'LoginController@logout')->name('frontend.logout');
        });
    });

    Route::post('/view-more', 'PageController@view_more')->name('frontend.view_more');
    Route::get('/', 'PageController@index')->name('home.default');
    Route::get('{taxonomy}/{alias?}', 'PageController@index')->name('frontend.page');


    // Đối với các route đặc biệt được định danh sẽ viết hàm để gọi lấy ra widget mặc định,
    // layout cũng lấy theo route đó (sẽ không định kiểu style mà fix cứng)
});
