<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
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
/**---------------------------------------------------------------------------------------------------------------------------
 *                          ADMIN USER ROLE MANAGE
 * ----------------------------------------------------------------------------------------------------------------------------*/
Route::group(['namespace' => 'Admin'], function () {
    // Languages
    Route::get('languages/{locale}', 'LanguageController@language')->name('admin.languages');
    // Login
    Route::get('/login', 'LoginController@index')->name('admin.login');
    Route::post('/login', 'LoginController@login')->name('admin.login.post');

    // Forgot
    Route::get('/forgot', 'LoginController@forgot')->name('admin.forgot');
    Route::post('/forgot', 'LoginController@forgotPass')->name('admin.forgot.post');
    // Reset pass
    Route::get('/resetpass/{token}', 'LoginController@resetPass')->name('admin.resetpass');
    Route::post('/resetpass', 'LoginController@resetPassPost')->name('admin.resetpass.post');


    // Update info user and change or forget password
    Route::get('forgot-password', 'AdminController@forgotPasswordForm')->name('admin.password.forgot.get');
    Route::post('forgot-password', 'AdminController@forgotPassword')->name('admin.password.forgot.post');
    Route::get('reset-password/{token}', 'AdminController@resetPasswordForm')->name('admin.password.reset.get');
    Route::post('reset-password', 'AdminController@resetPassword')->name('admin.password.reset.post');
    // Authentication middleware
    Route::group(['middleware' => ['auth:admin']], function () {
        // Logout
        Route::get('/logout', 'LoginController@logout')->name('admin.logout');
        // Dashboard
        Route::get('/', 'HomeController@index')->name('admin.home');
        // Update account
        Route::get('account', 'AdminController@changeAccountForm')->name('admin.account.change.get');
        Route::post('change-account', 'AdminController@changeAccount')->name('admin.account.change.post');

        Route::group(['middleware' => ['permission']], function () {
            // All route in admin system CRUD
            Route::resources([
                'admins' => 'AdminController',
                'admin_menus' => 'AdminMenuController',
                'modules' => 'ModuleController',
                'module_functions' => 'ModuleFunctionController',
                'roles' => 'RoleController',
                'blocks' => 'BlockController',
                'block_contents' => 'BlockContentController',
                'pages' => 'PageController',
                'menus' => 'MenuController',
                'options' => 'OptionController',
                'widgets' => 'WidgetController',
                'components' => 'ComponentController',
                'component_configs' => 'ComponentConfigController',
                'widget_configs' => 'WidgetConfigController',
                'cms_taxonomys' => 'CmsTaxonomyController',
                'cms_posts' => 'CmsPostController',
                'cms_products' => 'CmsProductController',
                'product_category' => 'ProductCategoryController',
                'post_category' => 'PostCategoryController',
                'brands' => 'BrandController',
                'parameter' => 'ParameterController',
                'settings' => 'SettingController',
                'language' => 'LanguageController',
                'reviews' => 'ReviewController',
                'shiping' => 'ShipController',
                'discounts' => 'DiscountController',
                'customer' => 'CustomerController',
                'comments' => 'CommentController',
                'contacts' => 'ContactController',
                'loadupdates' => 'LoadUpdateController',
            ]);

            Route::get('setting_theme', 'SettingController@settingTheme')->name('settings.themes');

            //DatDT update change list
            Route::post('/update-status-product/{id}', "CmsProductController@loadStatus")->name("admin.loadStatusProduct");
            Route::post('/update-status-post/{id}', "CmsPostController@loadStatus")->name("admin.loadStatusPost");
            Route::post('/update-status-post-category/{id}', "PostCategoryController@loadStatus")->name("admin.loadStatusPostCategory");
            Route::post('/update-status-product-category/{id}', "ProductCategoryController@loadStatus")->name("admin.loadStatusProductCategory");
            Route::post('/update-status-parameter/{id}', "ParameterController@loadStatus")->name("admin.loadStatusParameter");
            Route::post('/update-status-page/{id}', "PageController@loadStatus")->name("admin.loadStatusPage");
            Route::post('/update-status-blockContent/{id}', "BlockContentController@loadStatus")->name("admin.loadStatusBlockContent");
            Route::post('/update-status-block/{id}', "BlockController@loadStatus")->name("admin.loadStatusBlock");
            Route::post('/update-status-widget/{id}', "WidgetController@loadStatus")->name("admin.loadStatusWidget");
            Route::post('/update-status-component/{id}', "ComponentController@loadStatus")->name("admin.loadStatusComponent");
            Route::post('/update-status-review/{id}', "ReviewController@loadStatus")->name("admin.loadStatusReview");
            Route::post('/update-status-comment/{id}', "CommentController@loadStatus")->name("admin.loadStatusComment");
            Route::post('/update-status-admin/{id}', "AdminController@loadStatus")->name("admin.loadStatusAdmin");
            Route::post('/update-status-adminMenu/{id}', "AdminMenuController@loadStatus")->name("admin.loadStatusAdminMenu");
            Route::post('/update-status-role/{id}', "RoleController@loadStatus")->name("admin.loadStatusRole");
            Route::post('/update-status-module-function/{id}', "ModuleFunctionController@loadStatus")->name("admin.loadStatusModuleFunction");
            Route::post('/update-status-module/{id}', "ModuleController@loadStatus")->name("admin.loadStatusModule");
            Route::post('/update-status-menu/{id}', "MenuController@loadStatus")->name("admin.loadStatusMenu");
        });

        // Excel Product
        Route::get('export_excel', 'CmsProductController@export_excel')->name('product.excel.export');

        Route::post('update-status-coupon', 'DiscountController@statusCoupon')->name('status_coupon');
        Route::post('add-block', 'BlockContentController@addBlock')->name('frontend.add_block');
        Route::post('block_contents/update_sort', 'BlockContentController@updateSort')->name('blocks.update_sort');

        Route::get('get_block_params', 'BlockController@getBlockParams')->name('blocks.params');
        Route::get('get_block_contents_by_template', 'BlockContentController@getBlockContentsByTemplate')->name('block_contents.get_by_template');
        Route::post('block/delete', 'BlockContentController@delete')->name('block.delete');

        // Call request
        Route::get('call_request', 'ContactController@listCallRequest')->name('call_request.index');
        Route::get('call_request/{contact}', 'ContactController@showCallRequest')->name('call_request.show');
        Route::put('call_request/{contact}', 'ContactController@update')->name('call_request.update');
        Route::delete('call_request/{contact}', 'ContactController@destroy')->name('call_request.destroy');

        //Dtd delete select all
        Route::get('/delete-select-all-call-request', "ContactController@deleteSelectCallRequest")->name("call_request.select.all");
        Route::get('/delete-select-all-contact', "ContactController@deleteSelectContact")->name("contact.select.all");
        Route::get('/delete-select-all-review', "ReviewController@deleteSelectReview")->name("review.select.all");
        Route::get('/delete-select-all-comment', "CommentController@deleteSelectComment")->name("comment.select.all");

        // For related and tags
        Route::get('search_post', 'CmsPostController@search')->name('cms_posts.search');
        Route::get('search_product', 'CmsProductController@search')->name('cms_product.search');

        Route::get('get_component_config', 'ComponentConfigController@getComponentConfig')->name('component.config');
        Route::post('component/update_sort', 'ComponentController@updateSort')->name('component.update_sort');
        Route::post('component/delete', 'ComponentController@delete')->name('component.delete');

        Route::post('menus/update_sort', 'MenuController@updateSort')->name('menus.update_sort');
        Route::post('menus/delete', 'MenuController@delete')->name('menus.delete');

        Route::post('parameter/update_sort', 'ParameterController@updateSort')->name('parameter.update_sort');
        Route::post('parameter/delete', 'ParameterController@delete')->name('parameter.delete');

        // language

        Route::post('languages/set-language-default', 'LanguageController@setLanguageIsDefault')->name('languages.set_default');

        // Order Products
        Route::get('order_products', 'OrderController@listOrderProduct')->name('order_products.index');
        Route::get('order_products/{order}', 'OrderController@showOrderProduct')->name('order_products.show');
        Route::put('order_products/{order}', 'OrderController@update')->name('order_products.update');
        Route::delete('order_products/{order}', 'OrderController@destroy')->name('order_products.destroy');
        Route::put('order_details/{orderDetail}', 'OrderDetailController@update')->name('order_details.update');
        Route::delete('order_details', 'OrderDetailController@destroy')->name('order_details.destroy');
        // Config to use laravel-filemanager
        Route::group(['prefix' => 'filemanager'], function () {
            \UniSharp\LaravelFilemanager\Lfm::routes();
        });

        //DatDT update change list
        Route::post('/load-order/{table}/{id}', "LoadUpdateController@loadOrderVeryModel")->name("admin.loadOrderVeryModel");
        Route::post('/update-isFeatured/{table}/{id}', "LoadUpdateController@updateIsfeatured")->name("admin.updateIsfeatured");
    });
});
