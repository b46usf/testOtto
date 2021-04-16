<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\PegawaiController;

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
// route machine
Route::get('login', [AuthController::class, 'showFormLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showFormRegister'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::group(['middleware' => 'auth'], function () {
    Route::get('cuti/index', [CutiController::class, 'index'])->name('cuti');
    Route::get('pegawai/index', [PegawaiController::class, 'index'])->name('pegawai');
    Route::get('pegawai/trash', [PegawaiController::class, 'index'])->name('trashed');
    Route::post('pegawai/restore', [PegawaiController::class, 'restore']);
    Route::post('pegawai/truedelete', [PegawaiController::class, 'truedelete']);
    Route::resource('pegawai', PegawaiController::class);
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});