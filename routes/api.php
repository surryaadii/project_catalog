<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* Admin Api */
Route::group(['as'=>'api.admin.', 'prefix' => 'v1/admin'], function(){
    Route::post('/login', 'Api\\Admin\\AuthController@login')->name('login');
    Route::middleware('jwt.auth')->group(function () {
        Route::get('/users-index', 'Api\\Admin\\UserController@datatablesIndex')->name('users.index');
        Route::get('/roles-index', 'Api\\Admin\\RoleController@datatablesIndex')->name('roles.index');
    });
});
