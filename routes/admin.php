<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::group(['as'=>'admin.', 'prefix'=>'admin'],function(){
    Route::get('login', 'Auth\\Admin\\AuthController@index')->name('login')->middleware('admin.auth');
    Route::get('/', 'Admin\\DashboardController@index')->name('dashboard');
    Route::resource('users', 'Admin\\UserController')->only(['index', 'create', 'edit']);
    Route::resource('roles', 'Admin\\RoleController')->only(['index', 'create', 'edit']);
    Route::resource('banners', 'Admin\\BannerController')->only(['index', 'create', 'edit']);
    Route::resource('categories', 'Admin\\CategoryController')->only(['index', 'create', 'edit']);
    Route::resource('products', 'Admin\\ProductController')->only(['index', 'create', 'edit']);
    Route::resource('pages', 'Admin\\PageController')->only(['index', 'create', 'edit']);
});