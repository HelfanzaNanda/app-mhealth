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
Route::get('/', 'Frontend\AuthController@welcome')->name('index');
Route::get('/welcome', 'Frontend\AuthController@welcome')->name('welcome');
Route::get('/register/{role}', 'Frontend\AuthController@register')->name('register');


Route::post('/register/submit/{role}', 'Frontend\AuthController@register_submit')->name('register.submit');
Route::post('/login/submit/{role}', 'Frontend\AuthController@login_submit')->name('login.submit');
Route::get('/logout', 'Frontend\AuthController@logout')->name('logout');


Route::get('/login/{role}', 'Frontend\AuthController@login')->name('login');

Route::group(['prefix' => 'data', 'as' => 'data.'], function () {
    Route::post('kabupaten', 'Frontend\DataController@kabupaten')->name('kabupaten');
    Route::post('kecamatan', 'Frontend\DataController@kecamatan')->name('kecamatan');
    Route::post('kelurahan', 'Frontend\DataController@kelurahan')->name('kelurahan');
    Route::post('pasien', 'Frontend\DataController@pasien')->name('pasien');
});

Route::group(['prefix' => 'pasien', 'as' => 'pasien.'], function () {
    Route::get('/', 'Frontend\PasienController@home')->name('home');

    Route::group(['prefix' => 'health_education', 'as' => 'health_education.'], function () {
        Route::get('/', 'Frontend\PromosiKesehatanController@index')->name('index');
        Route::post('/load_items', 'Frontend\PromosiKesehatanController@load_items')->name('load_items');
        Route::get('/modal/detail', 'Frontend\PromosiKesehatanController@detail')->name('modal.detail');
    });

    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', 'Frontend\ProfileController@index')->name('index');
        Route::get('/modal/identity', 'Frontend\ProfileController@identity')->name('modal.identity');
        Route::get('/modal/edit', 'Frontend\ProfileController@edit')->name('modal.edit');
        Route::post('/update', 'Frontend\ProfileController@update')->name('update');
    });


    Route::get('modal/diary', 'Frontend\PasienController@diary')->name('modal.diary');
    Route::get('modal/consultation', 'Frontend\PasienController@consultation')->name('modal.consultation');
    Route::get('modal/health_records', 'Frontend\PasienController@health_records')->name('modal.health_records');
    Route::get('modal/pregnancy_test', 'Frontend\PasienController@pregnancy_test')->name('modal.pregnancy_test');
});


Route::group(['prefix' => 'bidan', 'as' => 'bidan.'], function () {
    Route::get('/', 'Frontend\BidanController@home')->name('home');

    Route::group(['prefix' => 'visit', 'as' => 'visit.'], function () {
        Route::get('/', 'Frontend\BidanController@visit')->name('index');
    });

    Route::group(['prefix' => 'pasien', 'as' => 'pasien.'], function () {
        Route::get('/', 'Frontend\BidanPasienController@index')->name('index');
        Route::post('/load_items', 'Frontend\BidanPasienController@load_items')->name('load_items');
        Route::get('/modal/detail', 'Frontend\BidanPasienController@detail')->name('modal.detail');
        Route::get('/modal/insert', 'Frontend\BidanPasienController@insert')->name('modal.insert');

        Route::post('/save', 'Frontend\BidanPasienController@save')->name('save');
    });

    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', 'Frontend\ProfileController@index')->name('index');
        Route::get('/modal/identity', 'Frontend\ProfileController@identity')->name('modal.identity');
        Route::get('/modal/edit', 'Frontend\ProfileController@edit')->name('modal.edit');
        Route::post('/update', 'Frontend\ProfileController@update')->name('update');
    });


    Route::get('modal/diary', 'Frontend\PasienController@diary')->name('modal.diary');
    Route::get('modal/consultation', 'Frontend\PasienController@consultation')->name('modal.consultation');
    Route::get('modal/health_records', 'Frontend\PasienController@health_records')->name('modal.health_records');
    Route::get('modal/pregnancy_test', 'Frontend\PasienController@pregnancy_test')->name('modal.pregnancy_test');
});














Route::group(['prefix' => 'backoffice', 'as' => 'backoffice.'], function () {
    Route::get('/', 'BackOfficeController@dashboard');
    Route::get('/inventory', 'BackOfficeController@inventory');
    Route::get('/analytic', 'BackOfficeController@analytic');


    Route::get('/category/{page}/{categoryid}', 'BackOfficeController@category');
    Route::get('/category/{page}', 'BackOfficeController@category');
    Route::get('/category/', 'BackOfficeController@category');

    Route::get('/meta/{page}/{metaid}', 'BackOfficeController@meta');
    Route::get('/meta/{page}', 'BackOfficeController@meta');
    Route::get('/meta/', 'BackOfficeController@meta');

    Route::group(['prefix' => 'kategori', 'as' => 'kategori.'], function () {
        Route::get('/', 'BackOffice\KategoriController@index')->name('index');
        Route::post('/datatables', 'BackOffice\KategoriController@datatables')->name('datatables');
        Route::get('insert', 'BackOffice\KategoriController@insert')->name('insert');
        Route::get('edit/{userid}', 'BackOffice\KategoriController@edit')->name('edit');
        Route::post('/save', 'BackOffice\KategoriController@save')->name('save');
        Route::post('/delete', 'BackOffice\KategoriController@delete')->name('delete');
    });

    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('/', 'BackOffice\UsersController@index')->name('index');
        Route::get('edit/{userid}', 'BackOffice\UsersController@edit')->name('edit');
        Route::get('insert', 'BackOffice\UsersController@insert')->name('insert');
        Route::post('/datatables', 'BackOffice\UsersController@datatables')->name('datatables');
        Route::post('/save', 'BackOffice\UsersController@save')->name('save');
        Route::post('/delete', 'BackOffice\UsersController@delete')->name('delete');
    });

    Route::group(['prefix' => 'bidan-profile', 'as' => 'bidan-profile.'], function () {
        Route::get('/', 'BackOffice\BidanProfileController@index')->name('index');
        Route::get('edit/{userid}', 'BackOffice\BidanProfileController@edit')->name('edit');
        Route::get('insert', 'BackOffice\BidanProfileController@insert')->name('insert');
        Route::post('/datatables', 'BackOffice\BidanProfileController@datatables')->name('datatables');
        Route::post('/save', 'BackOffice\BidanProfileController@save')->name('save');
        Route::post('/delete', 'BackOffice\BidanProfileController@delete')->name('delete');
    });

    Route::group(['prefix' => 'pasien-profile', 'as' => 'pasien-profile.'], function () {
        Route::get('/', 'BackOffice\PasienProfileController@index')->name('index');
        Route::get('edit/{userid}', 'BackOffice\PasienProfileController@edit')->name('edit');
        Route::get('insert', 'BackOffice\PasienProfileController@insert')->name('insert');
        Route::post('/datatables', 'BackOffice\PasienProfileController@datatables')->name('datatables');
        Route::post('/save', 'BackOffice\PasienProfileController@save')->name('save');
        Route::post('/delete', 'BackOffice\PasienProfileController@delete')->name('delete');
    });

    Route::group(['prefix' => 'faskes', 'as' => 'faskes.'], function () {
        Route::get('/', 'BackOffice\FaskesController@index')->name('index');
        Route::get('edit/{userid}', 'BackOffice\FaskesController@edit')->name('edit');
        Route::get('insert', 'BackOffice\FaskesController@insert')->name('insert');
        Route::post('/datatables', 'BackOffice\FaskesController@datatables')->name('datatables');
        Route::post('/save', 'BackOffice\FaskesController@save')->name('save');
        Route::post('/delete', 'BackOffice\FaskesController@delete')->name('delete');
    });

    Route::group(['prefix' => 'rujukan', 'as' => 'rujukan.'], function () {
        Route::get('/', 'BackOffice\RujukanController@index')->name('index');
        Route::get('edit/{userid}', 'BackOffice\RujukanController@edit')->name('edit');
        Route::get('insert', 'BackOffice\RujukanController@insert')->name('insert');
        Route::post('/datatables', 'BackOffice\RujukanController@datatables')->name('datatables');
        Route::post('/save', 'BackOffice\RujukanController@save')->name('save');
        Route::post('/delete', 'BackOffice\RujukanController@delete')->name('delete');
    });

    Route::group(['prefix' => 'kunjungan', 'as' => 'kunjungan.'], function () {
        Route::get('/', 'BackOffice\KunjunganController@index')->name('index');
        Route::get('edit/{userid}', 'BackOffice\KunjunganController@edit')->name('edit');
        Route::get('insert', 'BackOffice\KunjunganController@insert')->name('insert');
        Route::post('/datatables', 'BackOffice\KunjunganController@datatables')->name('datatables');
        Route::post('/save', 'BackOffice\KunjunganController@save')->name('save');
        Route::post('/delete', 'BackOffice\KunjunganController@delete')->name('delete');
    });

    Route::group(['prefix' => 'promosi-kesehatan', 'as' => 'promosi-kesehatan.'], function () {
        Route::get('/', 'BackOffice\PromosiKesehatanController@index')->name('index');
        Route::get('edit/{userid}', 'BackOffice\PromosiKesehatanController@edit')->name('edit');
        Route::get('insert', 'BackOffice\PromosiKesehatanController@insert')->name('insert');
        Route::post('/datatables', 'BackOffice\PromosiKesehatanController@datatables')->name('datatables');
        Route::post('/save', 'BackOffice\PromosiKesehatanController@save')->name('save');
        Route::post('/delete', 'BackOffice\PromosiKesehatanController@delete')->name('delete');
    });

    Route::group(['prefix' => 'banner', 'as' => 'banner.'], function () {
        Route::get('/', 'BackOffice\BannerController@index')->name('index');
        Route::get('edit/{userid}', 'BackOffice\BannerController@edit')->name('edit');
        Route::get('insert', 'BackOffice\BannerController@insert')->name('insert');
        Route::post('/datatables', 'BackOffice\BannerController@datatables')->name('datatables');
        Route::post('/save', 'BackOffice\BannerController@save')->name('save');
        Route::post('/delete', 'BackOffice\BannerController@delete')->name('delete');
    });




    Route::get('/login', 'BackOfficeController@login');
});
