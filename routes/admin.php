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

Route::get('/', 'Admin\\DashboardController@index')->name('admin.dashboard');

/* Ajax */
Route::group(['as'=>'admin.api.', 'prefix' => 'api'], function(){
    Route::get('/users-index', 'Admin\\UserController@datatablesIndex')->name('users.index');
    Route::get('/roles-index', 'Admin\\RoleController@datatablesIndex')->name('roles.index');
});

Route::group(['as'=>'admin.'],function(){
    Route::resource('users', 'Admin\\UserController');
    Route::resource('roles', 'Admin\\RoleController');
});