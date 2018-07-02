<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
/////////////////////////////// PAYMENT WEBHOOKS
Route::post('/mollie/reservation_webhook','WebhookController@reservation_paid');
Route::post('/mollie/touristtax_webhook','WebhookController@touristtax_paid');

/////////////////////////////// FACEBOOK LOGIN
Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');

// Route::get('/login', 'Auth\LoginController@index')->name('adminlogin');
// Route::post('/login', 'Auth\LoginController@login');

//////////////////////////////// INDEX RESERVATIONS
Route::get('/admin/login', 'Auth\AdminLoginController@index')->name('adminlogin');
// Route::post('/admin/login', 'Auth\AdminLoginController@login');
$this->post('/admin/login', 'Auth\AdminLoginController@login')->name('adminlogin');
Route::get('admin/logout', 'Auth\AdminLoginController@logout')->name('balie.logout');

//////////////////////////////// INDEX RESERVATIONS
Route::get('/balie/login', 'Auth\BalieLoginController@index')->name('balielogin');
Route::post('/balie/login', 'Auth\BalieLoginController@login');
Route::get('balie/logout', 'Auth\AdminLoginController@logout')->name('balie.logout');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/terms', function () {
    return view('terms/terms&conditions');
});
Route::get('/terms/old', function () {
    return view('terms/old_terms&conditions');
});
Route::get('/terms/cancellation', function () {
    return view('terms/cancellation');
});
Route::post('/price/week', 'PriceController@getWeekPrice');

Auth::routes();

Route::group(['middleware' => ['web']], function () {

    //////////////////////////////// HOME
    Route::get('/home', 'HomeController@index');

    //////////////////////////////// LOGIN OVERRIDE
    $this->get('/login', 'Auth\LoginController@index')->name('login');
    $this->get('/register', 'Auth\RegisterController@index')->name('register');

    //////////////////////////////// ARCHIVE
    Route::get('/archive', 'ArchiveController@index');
    Route::post('/archive/yeardata', 'ArchiveController@yeardata');
    Route::post('/archive/taxpayment', 'PaymentsController@TouristtaxPaymentArchive');

    //////////////////////////////// SEARCH 
    Route::get('/search/adminreservations', 'SearchController@searchAdminReservations');
    Route::get('/search/reservations', 'SearchController@searchReservations');
    Route::get('/search/users', 'SearchController@searchUsers');

    //////////////////////////////// PROFILE
    Route::get('/users/profile', 'UserController@index');
    Route::patch('/users/profile', 'UserController@update');

    //////////////////////////////// INBOX
    Route::get('/users/inbox', 'InboxController@index');
    Route::post('/users/inbox', 'InboxController@markAsRead');

    //////////////////////////////// PRIVACY
    Route::get('/users/privacy', 'PrivacyController@index');
    Route::patch('/users/privacy', 'PrivacyController@update');

    //////////////////////////////// SETTINGS
    Route::get('/users/settings', 'UserSettingsController@index');
    Route::patch('/users/settings', 'UserSettingsController@update');
    Route::delete('/users/settings', 'UserSettingsController@delete');

    /////////////////////////////// ACCOMODATIONS
    Route::get('/accommodations/all', 'AccommodationsController@index');
    Route::post('/accommodations/new', 'AccommodationsController@new');

     /////////////////////////////// ACCOMODATIONS
    Route::post('/payment/checkpayment', 'PaymentsCore@checkPayment');

    /////////////////////////////// MY RESERVATIONS
    Route::get('/reservations/myreservations', 'MyReservationController@index');
    Route::post('/reservations/myreservations', 'PaymentsController@ReservationPayment');
    Route::post('/reservations/myreservations/cancel', 'ReservationController@cancel');
    Route::post('/reservations/myreservations/reject', 'ReservationController@reject');
    Route::post('/reservations/myreservations/delete', 'ReservationController@destroy');

    //////////////////////////////// MAKE RESERVATIONS
    Route::post('/reservations/new', 'ReservationController@index');
    Route::post('/reservations/new/save', 'ReservationController@store');
    Route::post('/reservations/new/steptwo', 'ReservationController@stepTwo');
    Route::post('/reservations/new/stepthree', 'ReservationController@stepThree');

    //////////////////////////////// TAX ROUTES
    Route::post('/touristtax/new', 'TouristtaxController@index');
    Route::post('/touristtax/payment', 'PaymentsController@TouristtaxPayment');

    Route::post('/invoice/receipt', 'ReceiptController@index');
    Route::post('/invoice/taxreceipt', 'TaxInvoiceController@index');
});

//////////////////////////////// HELP
Route::get('/help', 'HelpController@index');

//////////////////////////////// ADMIN ROUTES
Route::group(['middleware' => 'auth:admin'], function () {

    Route::post('/media/upload', 'MediaController@upload');

    //////////////////////////////// ADMIN UPDATE
    Route::get('/update/check', 'UpdateCore@checkRequest');

    //////////////////////////////// ADMIN SEARCH
    Route::post('/search/input', 'SearchController@inputSearch');

    //////////////////////////////// ADMIN ARCHIVE
    Route::get('/admin/archive', 'ArchiveController@adminIndex');
    Route::get('/admin/archive/yeardata', 'ArchiveController@adminYeardata');
    Route::post('/admin/archive/yeardata', 'ArchiveController@adminYeardata');
    Route::post('/admin/archive/update/tax', 'ArchiveController@updateTaxPayment');
    Route::post('/admin/archive/update/rent', 'ArchiveController@updateRentPayment');
    
    //////////////////////////////// LOCATION OPTIONS
    Route::get('/admin/locations', 'AdminLocationsController@index');
    Route::post('/admin/locations', 'AdminLocationsController@update');
    
    //////////////////////////////// ALL RESERVATIONS
    Route::get('/admin/allreservations', 'AdminReservationsController@index');
    Route::patch('/admin/allreservations', 'AdminReservationsController@update');
    Route::get('/admin/allreservations/ajax', 'AdminReservationsController@update');
    Route::post('/admin/allreservations/cancel', 'AdminReservationsController@cancel');
    Route::post('/admin/allreservations/rejected', 'AdminReservationsController@rejected');
    Route::post('/admin/allreservations', 'AdminReservationsController@search');
    Route::post('/admin/allreservations/assign', 'AdminReservationsController@autoAssign');

    //////////////////////////////// OPTIONS
    Route::get('/admin/options', 'OptionsCore@index');
    Route::patch('/admin/options', 'OptionsCore@updateSettings');
    Route::post('/admin/options', 'OptionsCore@newyear');

    //////////////////////////////// ADMIN USERS
    Route::get('/admin/accounts', 'AdminUserController@index');
    Route::post('/admin/accounts', 'AdminUserController@store');
    Route::patch('/admin/accounts', 'AdminUserController@update');

    

    //////////////////////////////// INDEX RESERVATIONS
    Route::get('/admin', 'AdminIndexController@index')->name('admin.home');
});

Route::group(['middleware' => 'auth:balie'], function () {

    //////////////////////////////// BALIE
    Route::get('/balie', 'BalieController@index');
    Route::post('/balie/update', 'BalieController@update');

});
