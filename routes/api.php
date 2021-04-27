<?php

use Illuinate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/customer/login', 'Api\User\CustomerController@login');

Route::post('/admin/home', 'Api\AdminController@home');
Route::post('/admin/login', 'Api\AdminController@login');
Route::get('/admin/check', 'Api\AdminController@check');
Route::post('/admin/get_update', 'Api\AdminController@get_update');

Route::group(['prefix' => 'pasien'], function(){
    Route::post('/list', 'Api\Admin\ContactController@list');
    Route::post('/get', 'Api\Admin\ContactController@get');
    Route::post('/save', 'Api\Admin\ContactController@save');
    Route::post('/delete', 'Api\Admin\ContactController@delete');
});
Route::group(['prefix' => 'auto-response'], function(){
    Route::post('/list', 'Api\Admin\AutoResponseController@list');
    Route::post('/get', 'Api\Admin\AutoResponseController@get');
    Route::post('/save', 'Api\Admin\AutoResponseController@save');
    Route::post('/delete', 'Api\Admin\AutoResponseController@delete');
});
Route::group(['prefix' => 'schedule'], function(){
    Route::post('/list', 'Api\Admin\ScheduleController@list');
    Route::post('/get', 'Api\Admin\ScheduleController@get');
    Route::post('/save', 'Api\Admin\ScheduleController@save');
    Route::post('/delete', 'Api\Admin\ScheduleController@delete');
});
Route::group(['prefix' => 'category'], function(){
    Route::post('/list', 'Api\Admin\CategoryController@list');
    Route::post('/get', 'Api\Admin\CategoryController@get');
    Route::post('/save', 'Api\Admin\CategoryController@save');
    Route::post('/delete', 'Api\Admin\CategoryController@delete');
    Route::post('/upload_image', 'Api\Admin\CategoryController@upload_image');
    Route::post('/upload_logo', 'Api\Admin\CategoryController@upload_logo');
    Route::post('/upload_banner', 'Api\Admin\CategoryController@upload_banner');
    Route::post('/upload_banner_mobile', 'Api\Admin\CategoryController@upload_banner_mobile');
    Route::post('/toogle_show_on_home', 'Api\Admin\CategoryController@toogle_show_on_home');
});
Route::group(['prefix' => 'users'], function(){
    Route::post('/list', 'Api\Admin\UserController@list')->name('api.users.list');
    Route::post('/get', 'Api\Admin\UserController@get');
    Route::post('/save', 'Api\Admin\UserController@save');
    Route::post('/delete', 'Api\Admin\UserController@delete');
});
Route::group(['prefix' => 'bidan'], function(){
    Route::post('/list', 'Api\Admin\BidanController@list');
    Route::post('/get', 'Api\Admin\BidanController@get');
    Route::post('/save', 'Api\Admin\BidanController@save');
    Route::post('/delete', 'Api\Admin\BidanController@delete');
});
Route::group(['prefix' => 'pasien'], function(){
    Route::post('/list', 'Api\Admin\PasienController@list');
    Route::post('/get', 'Api\Admin\PasienController@get');
    Route::post('/save', 'Api\Admin\PasienController@save');
    Route::post('/delete', 'Api\Admin\PasienController@delete');
});
Route::group(['prefix' => 'notification'], function(){
    Route::post('/send_notification', 'Api\Admin\NotificationController@send_notification');
    Route::post('/list', 'Api\Admin\NotificationController@list');
    Route::post('/queue_list', 'Api\Admin\NotificationController@queue_list');
    Route::post('/get', 'Api\Admin\NotificationController@get');
    Route::post('/save', 'Api\Admin\NotificationController@save');
    Route::post('/delete', 'Api\Admin\NotificationController@delete');
    Route::post('/delete_queue', 'Api\Admin\NotificationController@delete_queue');
});
Route::group(['prefix' => 'content'], function(){

    Route::post('/get', 'Api\Admin\ContentController@get');
    Route::post('/save', 'Api\Admin\ContentController@save');
    Route::post('/save_batch', 'Api\Admin\ContentController@save_batch');
    Route::post('/upload', 'Api\Admin\ContentController@upload');

	Route::group(['prefix' => 'banner'], function(){
	    Route::post('/list', 'Api\Admin\Content\BannerController@list');
	    Route::post('/save', 'Api\Admin\Content\BannerController@save');
	    Route::post('/upload', 'Api\Admin\Content\BannerController@upload');
	    Route::post('/delete', 'Api\Admin\Content\BannerController@delete');
	});
});
Route::group(['prefix' => 'data'], function(){
    Route::post('/list_category', 'Api\User\DataController@list_category');
    Route::post('/list_banner', 'Api\User\DataController@list_banner');
    Route::post('/list_fabric', 'Api\User\DataController@list_fabric');
    Route::post('/list_blog', 'Api\User\DataController@list_blog');
    Route::post('/home', 'Api\User\DataController@home');
    Route::post('/list_collection', 'Api\User\DataController@list_collection');
    Route::post('/get_collection_by_slug', 'Api\User\DataController@get_collection_by_slug');
    Route::post('/get_category_by_slug', 'Api\User\DataController@get_category_by_slug');
    Route::post('/get_blog_category_by_slug', 'Api\User\DataController@get_blog_category_by_slug');
    Route::post('/list_lookbook', 'Api\User\DataController@list_lookbook');
    Route::post('/base_content', 'Api\User\DataController@base_content');
    Route::post('/get_content', 'Api\User\DataController@get_content');
    Route::post('/get_faq', 'Api\User\DataController@get_faq');

    Route::post('/get_blog_page', 'Api\User\DataController@get_blog_page');
    // Route::post('/quick-search', 'Api\User\DataController@quick_search');
});

Route::post('/verify_payment_webhook', 'Api\User\PaymentController@verify_payment_webhook');

Route::group(['prefix' => 'v1'], function(){
	Route::post('/access_log', 'Api\User\CustomerController@access_log');
	Route::post('/check_cod', 'Api\User\DataController@check_cod');
	Route::post('/check_waybill', 'Api\User\DataController@check_waybill');
	Route::get('/check_waybill/{waybill}', 'Api\User\DataController@check_waybill');
	Route::get('/cron_shipment', 'Api\User\DataController@cron_shipment');
	Route::get('/cron_push', 'Api\User\DataController@cron_push');
	Route::post('/subscribe', 'Api\User\DataController@subscribe');

	Route::group(['prefix' => 'customer'], function(){		
	    Route::post('/register', 'Api\User\CustomerController@register');
	    Route::post('/login', 'Api\User\CustomerController@login');
	    Route::post('/fb_login', 'Api\User\CustomerController@fb_login');
	    Route::post('/google_login', 'Api\User\CustomerController@google_login');
	    Route::post('/google_login_get_url', 'Api\User\CustomerController@google_login_get_url');
	    Route::get('/check', 'Api\User\CustomerController@check');
	    Route::get('/profile', 'Api\User\CustomerController@profile');
	    Route::post('/activation', 'Api\User\CustomerController@activation');
	    Route::post('/send_email_activation', 'Api\User\CustomerController@send_email_activation');
	    Route::post('/send_recovery_link', 'Api\User\CustomerController@send_recovery_link');
	    Route::post('/reset_password', 'Api\User\CustomerController@reset_password');
	    Route::post('/set_login_incentive', 'Api\User\CustomerController@set_login_incentive');
	    Route::post('/check_coupon', 'Api\User\CustomerController@check_coupon');
	});
    Route::post('/quick-search', 'Api\User\ProductController@quick_search');
    Route::post('/search', 'Api\User\ProductController@search');

	Route::group(['prefix' => 'pasien'], function(){
	    Route::post('/post_diary', 'Api\User\PasienController@post_diary');
	    Route::post('/add_riwayat_kehamilan', 'Api\User\PasienController@add_riwayat_kehamilan');
	    Route::post('/remove_riwayat_kehamilan', 'Api\User\PasienController@remove_riwayat_kehamilan');
	    Route::post('/get_profile', 'Api\User\PasienController@get_profile'); 
	});

	
	Route::group(['prefix' => 'blog'], function(){
	    Route::post('/detail', 'Api\User\BlogController@detail');
    	Route::post('/list', 'Api\User\BlogController@list');
	    Route::post('/submit_comment', 'Api\User\BlogController@submit_comment');
	    Route::post('/get_comment', 'Api\User\BlogController@get_comment');
	});

	Route::group(['prefix' => 'cart'], function(){
	    Route::post('/insert', 'Api\User\CartController@insert');
	    Route::post('/get', 'Api\User\CartController@get');
	    Route::post('/remove', 'Api\User\CartController@remove');
	    Route::post('/update', 'Api\User\CartController@update');
	});
	
	Route::post('/verify_payment', 'Api\User\PaymentController@verify_payment');

	Route::group(['prefix' => 'checkout'], function(){
	    Route::post('/process', 'Api\User\CheckoutController@process');
	    Route::post('/get', 'Api\User\CheckoutController@get');
	    Route::post('/get_shipping', 'Api\User\CheckoutController@get_shipping');
	    Route::post('/use_coupon', 'Api\User\CheckoutController@use_coupon');
	    Route::post('/payment', 'Api\User\CheckoutController@payment');
	});

	Route::group(['prefix' => 'customer'], function(){
	    Route::post('/address_list', 'Api\User\CustomerController@address_list');
	    Route::post('/address_remove', 'Api\User\CustomerController@address_remove');
	    Route::post('/address_save', 'Api\User\CustomerController@address_save');
	    Route::post('/profile', 'Api\User\CustomerController@profile');
	    Route::post('/update_profile', 'Api\User\CustomerController@update_profile');
	    Route::post('/update_password', 'Api\User\CustomerController@update_password');
	    Route::post('/purchase_history', 'Api\User\CustomerController@purchase_history');
	    Route::post('/purchase_detail', 'Api\User\CustomerController@purchase_detail');
	    Route::post('/invoice', 'Api\User\CustomerController@invoice');
	    Route::post('/toogle_wishlist', 'Api\User\CustomerController@toogle_wishlist');
	    Route::post('/get_wishlist', 'Api\User\CustomerController@get_wishlist');
	});


});


