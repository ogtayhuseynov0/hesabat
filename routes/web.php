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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/',"DashboardController@main");
Route::get('/dashboard',"DashboardController@index");
Route::get('/dashboard/melumat/{query?}',"DashboardController@melumat");
Route::get('/dashboard/statistika',"DashboardController@statistika");
Route::get('/dashboard/statistika/ayliq',"DashboardController@ayliq");
Route::get('/dashboard/statistika/xidmetevler',"DashboardController@xidmetevler");
Route::post('/dashboard/statistika/xidmetevler',"DashboardController@xidmetevler");
Route::post('/dashboard/statistika/ayliq',"DashboardController@ayliq");
Route::get('/dashboard/elave',"XidmetController@elave");
Route::get('/dashboard/elave/xidmet/{id}',"XidmetController@xidmetSil");
Route::get('/dashboard/elave/xidmet',"XidmetController@elave");
Route::get('/dashboard/elave/xidmetdeyish',"XidmetController@elave");
Route::post('/dashboard/elave/xidmetdeyish',"XidmetController@deyishPost");
Route::post('/dashboard/elave/xidmet',"XidmetController@elavePost");
Route::get('/dashboard/elave/flkart',"XidmetController@elaveFlkart");
Route::get('/dashboard/elave/flkartsil',"XidmetController@idareFlkart");
Route::get('/dashboard/elave/flkartsil/{id}',"XidmetController@FlkartSil");
Route::post('/dashboard/elave/flkart',"XidmetController@elaveFlkartPost")->name('flkartpost');
Route::get('/dashboard/hesabatlar/{query?}',"DashboardController@hesabatlar");
Route::get('/dashboard/hesabatlar/sil/{id}',"DashboardController@hesabatSil");
