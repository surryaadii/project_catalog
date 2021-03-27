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
        Route::apiResource('users', 'Api\\Admin\\UserController');
        Route::apiResource('roles', 'Api\\Admin\\RoleController'); 
        Route::apiResource('categories', 'Api\\Admin\\CategoryController'); 
        Route::apiResource('products', 'Api\\Admin\\ProductController'); 
        // Route::apiResource('sub-categories', 'Api\\Admin\\SubCategoryController'); 
        Route::apiResource('banner', 'Api\\Admin\\BannerController'); 
        Route::post('/banner/{id}/store-assets', 'Api\\Admin\\BannerController@addAssets')->name('banner.store_assets');
        Route::get('/banner/{id}/assets', 'Api\\Admin\\BannerController@indexBannerAssets')->name('banner.assets.index');
        Route::delete('/banner/{id}/assets/{asset_id}', 'Api\\Admin\\BannerController@deleteAssetBanner')->name('banner.assets.delete');
        Route::post('/products/{id}/store-assets', 'Api\\Admin\\ProductController@addAssets')->name('products.store_assets');
        Route::get('/products/{id}/assets', 'Api\\Admin\\ProductController@indexProductAssets')->name('products.assets.index');
        Route::delete('/products/{id}/assets/{asset_id}', 'Api\\Admin\\ProductController@deleteAssetProduct')->name('products.assets.delete');
        Route::post('/asset/download', 'Api\\Admin\\AssetController@downloadAsset')->name('asset.download');
    });
});
