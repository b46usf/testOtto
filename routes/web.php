<?php

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
Route::get('/', function () {
    return view('welcome');
});
// route pages customer with model query builder
// Route::get('/customer', 'App\Http\Controllers\customerController@index');
// Route::get('/customer/input', 'App\Http\Controllers\customerController@create');
// Route::get('/customer/show', 'App\Http\Controllers\customerController@create');
// Route::post('/customer/edit', 'App\Http\Controllers\customerController@edit');
// Route::post('/customer/update', 'App\Http\Controllers\customerController@update');
// Route::post('/customer/delete', 'App\Http\Controllers\customerController@delete');
// Route::post('/customer/store', 'App\Http\Controllers\customerController@store');
// Route::post('/customer/table', 'App\Http\Controllers\customerController@show');
// route konsumen without model
// Route::get('/customer', 'App\Http\Controllers\konsumenController@index');
// Route::get('/customer/input', 'App\Http\Controllers\konsumenController@create');
// //Route::get('/customer/show', 'App\Http\Controllers\konsumenController@show');
// Route::get('/customer/show/{id}', 'App\Http\Controllers\konsumenController@show');
// Route::post('/customer/edit', 'App\Http\Controllers\konsumenController@edit');
// Route::post('/customer/update', 'App\Http\Controllers\konsumenController@update');
// Route::post('/customer/delete', 'App\Http\Controllers\konsumenController@delete');
// Route::post('/customer/store', 'App\Http\Controllers\konsumenController@store');
// route pages customer with eloquent model
Route::get('/customer', 'App\Http\Controllers\eloCustController@index');
Route::get('/customer/input', 'App\Http\Controllers\konsumenController@create');
//Route::get('/customer/show', 'App\Http\Controllers\konsumenController@show');
Route::get('/customer/show/{id}', 'App\Http\Controllers\konsumenController@show');
Route::post('/customer/edit', 'App\Http\Controllers\konsumenController@edit');
Route::post('/customer/update', 'App\Http\Controllers\konsumenController@update');
Route::post('/customer/delete', 'App\Http\Controllers\konsumenController@delete');
Route::post('/customer/store', 'App\Http\Controllers\konsumenController@store');