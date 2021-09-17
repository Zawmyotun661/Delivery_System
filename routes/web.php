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

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/admin','App\Http\Controllers\admin\AdminDashboardController@index');
Route::get('/clients','App\Http\Controllers\UserController@index');
Route::resource('/country','App\Http\Controllers\CountryController');
// Route::resource('/companies', 'App\Http\Controllers\CompanyController');
//  Route::resource('/clients', 'App\Http\Controllers\ClientController');
 Route::resource('/drivers', 'App\Http\Controllers\DriverController');
 Route::resource('/packages', 'App\Http\Controllers\PackageController');




Route::get('/home','App\Http\Controllers\HomeController@index')->name('home');


Route::namespace('App\Http\Controllers')->group(function () {
    Auth::routes();
});