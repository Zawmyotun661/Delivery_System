<?php

use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\Annotation\Route as AnnotationRoute;

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

Route::get('/','App\Http\Controllers\User\UserDashboardController@index');
Route::get('/online_shop','App\Http\Controllers\User\UserDashboardController@online_shop');
Route::get('/login', function () {
    return view('auth.login');
});
Route::get('search_user', [App\Http\Controllers\User\UserDashboardController::class, 'search'])->name('search_user');
Route::get('online_shop_search', [App\Http\Controllers\User\UserDashboardController::class, 'online_shop_search'])->name('online_shop_search');
/////////////////////////////DDDDDDDDDDDDD____DASGBOARD//////////////////////////
Route::group(['middleware'=> 'auth'], function(){
Route::get('/admin/user_list','App\Http\Controllers\admin\AdminDashboardController@index');
Route::resource('/driver_dashboard','App\Http\Controllers\DriverDashboardController');

/////////////////////////////////////////////////////////////////////////////////////
Route::get('package/{id}/edit','App\Http\Controllers\PackageController@edit_list');
Route::resource('/clients','App\Http\Controllers\ClientController');
Route::get('/clients/{id}/destroy', [App\Http\Controllers\ClientController::class, 'destroy']);
Route::resource('/country','App\Http\Controllers\CountryController');
Route::resource('/city','App\Http\Controllers\CityController');
Route::get('/city/{id}/destroy', [App\Http\Controllers\CityController::class, 'destroy']);
Route::resource('/township','App\Http\Controllers\TownshipController');
Route::get('/township/{id}/destroy', [App\Http\Controllers\TownshipController::class, 'destroy']);
 Route::resource('/drivers', 'App\Http\Controllers\DriverController');
Route::get('/drivers/{id}/destroy', [App\Http\Controllers\DriverController::class, 'destroy']);
 Route::resource('/packages', 'App\Http\Controllers\PackageController');
 Route::get('/admin/{id}/manage-role',[App\Http\Controllers\admin\AdminDashboardController::class, 'manage']);
 Route::post('/admin/{id}/update',[App\Http\Controllers\admin\AdminDashboardController::class, 'update']);
Route::get('/search_users',[App\Http\Controllers\admin\AdminDashboardController::class, 'search']);
Route::get('search', [App\Http\Controllers\DriverController::class, 'search'])->name('search');
Route::get('township_list', [App\Http\Controllers\PackageController::class, 'townshipList'])->name('township_list');
Route::post('create_package', [App\Http\Controllers\PackageController::class, 'store'])->name('create_package');
Route::post('update_package', [App\Http\Controllers\PackageController::class, 'update'])->name('update_package');
Route::get('search_package', [App\Http\Controllers\PackageController::class, 'search'])->name('search_package');
Route::get('search_package_list', [App\Http\Controllers\DriverDashboardController::class, 'search'])->name('package_list');
Route::get('/report_list','App\Http\Controllers\admin\AdminDashboardController@reports' );
Route::get('search_report', [App\Http\Controllers\admin\AdminDashboardController::class, 'searchReport'])->name('search_report');
Route::resource('/shoppers','App\Http\Controllers\ShopperController');
Route::get('shoppers/{id}/destroy', 'App\Http\Controllers\ShopperController@destroy');
Route::get('/shoppers/{id}/package-list', 'App\Http\Controllers\ShopperController@packages');
Route::get('/shoppers/{id}/new-package', 'App\Http\Controllers\PackageController@create');
Route::get('/shoppers/{id}/package/{pid}/edit', 'App\Http\Controllers\PackageController@edit');
Route::get('/shoppers/{id}/package/{pid}/destroy', 'App\Http\Controllers\PackageController@destroy');
Route::get('/shoppers/{id}/deposit-list', 'App\Http\Controllers\DepositController@index');
Route::get('/shoppers/{id}/new-deposit', 'App\Http\Controllers\DepositController@create');
Route::post('/shoppers/{id}/create-deposit', 'App\Http\Controllers\DepositController@store');
Route::get('/shoppers/{id}/deposit/{did}/destroy', 'App\Http\Controllers\DepositController@destroy');
Route::get('/shoppers/{id}/deposit/{did}/edit', 'App\Http\Controllers\DepositController@edit');
Route::Post('/shoppers/{id}/deposit/{did}/update', 'App\Http\Controllers\DepositController@update');
Route::get('export', [App\Http\Controllers\PackageController::class, 'export']);
Route::get('export/{data}', [App\Http\Controllers\PackageController::class, 'searchExport']);
Route::get('shoppers/{id}/export', [App\Http\Controllers\ShopperController::class, 'export']);
Route::get('shopperspdf/{id}/export', [App\Http\Controllers\ShopperController::class, 'exportPDF']);
Route::get('reports-export', [App\Http\Controllers\admin\AdminDashboardController::class, 'export']);
Route::get('reports-export/{data}', [App\Http\Controllers\admin\AdminDashboardController::class, 'searchExport']);
Route::get('shoppers/{id}/excel-export/{data}', [App\Http\Controllers\ShopperController::class, 'searchExport']);
Route::get('shoppers/{id}/pdf-export/{data}', [App\Http\Controllers\ShopperController::class, 'searchPdfExport']);
Route::get('search_client',[App\Http\Controllers\ClientController::class, 'search'])->name('search_client');
Route::get('search_township',[App\Http\Controllers\TownshipController::class, 'search'])->name('search_township');
Route::get('search_city',[App\Http\Controllers\CityController::class, 'search'])->name('search_city');
Route::get('search_customer',[App\Http\Controllers\ShopperController::class, 'search'])->name('search_customer');


Route::get('/home','App\Http\Controllers\HomeController@index')->name('home');
});
Route::namespace('App\Http\Controllers')->group(function () {
    Auth::routes();
});