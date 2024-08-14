<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;

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

//ログイン前でないと表示されない
Route::middleware(['guest'])->group(function () {
    //ログインフォーム表示
    Route::get('/',  'App\Http\Controllers\Auth\AuthController@showLogin')->name('login.show');

    //ログイン処理
    Route::post('/login',  'App\Http\Controllers\Auth\AuthController@login')->name('login');
});

//ログイン後でないと表示されない
Route::middleware(['auth'])->group(function () {
    //ホーム画面
    Route::get('/home', function(){
        return view('home');
    })->name('home');

    //ログアウト
    Route::post('/logout',[AuthController::class,'logout'])->name('logout');
});