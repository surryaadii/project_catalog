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
    Route::post('logout', 'Api\\Admin\\AuthController@logout')->name('logout');
    Route::middleware('jwt.auth')->group(function () {
        Route::apiResource('users', 'Api\\Admin\\UserController');
        Route::apiResource('roles', 'Api\\Admin\\RoleController'); 
        Route::apiResource('categories', 'Api\\Admin\\CategoryController'); 
        Route::apiResource('products', 'Api\\Admin\\ProductController'); 
        // Route::apiResource('sub-categories', 'Api\\Admin\\SubCategoryController'); 
        Route::apiResource('banner', 'Api\\Admin\\BannerController'); 
        Route::apiResource('pages', 'Api\\Admin\\PageController'); 
        Route::post('/banner/{id}/store-assets', 'Api\\Admin\\BannerController@addAssets')->name('banner.store_assets');
        Route::get('/banner/{id}/assets', 'Api\\Admin\\BannerController@indexBannerAssets')->name('banner.assets.index');
        Route::delete('/banner/{id}/assets/{asset_id}', 'Api\\Admin\\BannerController@deleteAssetBanner')->name('banner.assets.delete');
        Route::post('/products/{id}/store-assets', 'Api\\Admin\\ProductController@addAssets')->name('products.store_assets');
        Route::get('/products/{id}/assets', 'Api\\Admin\\ProductController@indexProductAssets')->name('products.assets.index');
        Route::delete('/products/{id}/assets/{asset_id}', 'Api\\Admin\\ProductController@deleteAssetProduct')->name('products.assets.delete');
        Route::post('/pages/{id}/store-assets', 'Api\\Admin\\PageController@addAssets')->name('pages.store_assets');
        Route::get('/pages/{id}/assets', 'Api\\Admin\\PageController@indexPageAssets')->name('pages.assets.index');
        Route::delete('/pages/{id}/assets/{asset_id}', 'Api\\Admin\\PageController@deleteAssetPage')->name('pages.assets.delete');
        Route::post('/asset/download', 'Api\\Admin\\AssetController@downloadAsset')->name('asset.download');
    });
});

/* Frontend Api */

Route::group(['as'=>'api.', 'prefix' => 'v1', 'middleware' => ['localization']], function(){
    Route::post('/get-banner', 'Api\\Frontend\\BannerController@getBanner');
    Route::post('/get-page', 'Api\\Frontend\\PageController@getPage');
    Route::get('/products', 'Api\\Frontend\\ProductController@index');
    Route::get('/product/{slug}', 'Api\\Frontend\\ProductController@show');
    Route::get('/categories', 'Api\\Frontend\\CategoryController@index');
    Route::post('/send-email', 'Api\\Frontend\\ContactController@sendEmail');
});
