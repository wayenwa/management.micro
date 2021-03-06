<?php

use Illuminate\Http\Request;

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

/**
 * 
 * PUBLIC ROUTES
 */
Route::get('merchant_data/{merchantName}', 'API\InitialMerchantsController@merchants_data');
Route::get('index_merchants', 'API\MerchantsController@index');
Route::post('category_items', 'API\CategoriesController@category_items');

/**
 * 
 * AUTHENTICATED ROUTES
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

Route::middleware('auth:api')->group( function () {

    /*  LOCATIONS */
    Route::resource('locations', 'API\LocationsController');

    /*  COMMUNITIES */
    Route::resource('communities', 'API\CommunitiesController');
    Route::put('update_communities', 'API\CommunitiesController@update');
    
    /* SCHEDULE TIMINGS */
    Route::resource('schedule_timing', 'API\ScheduleTimingsController');
    Route::put('update_schedule_timing', 'API\ScheduleTimingsController@update');

    /*  MERCHANTS    */
    Route::resource('merchants', 'API\MerchantsController');
    Route::get('initial_new_merchant', 'API\InitialMerchantsController@dataReference');
    
    /*  CATEGORIES    */
    
    Route::resource('categories', 'API\CategoriesController');
    Route::post('category', 'API\CategoriesController@category');
    Route::put('update_categories', 'API\CategoriesController@update');
    
     /*  ITEMS    */
     Route::put('items', 'API\ItemsController@update');
     Route::resource('items', 'API\ItemsController');
    
});


