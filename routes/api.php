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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

\Laravel\Passport\Passport::routes(function(\Laravel\Passport\RouteRegistrar $router) {
    $router->forAccessTokens();
},['prefix' => 'api/oauth']);

Route::middleware('api')->prefix('v1')->group(function (){
    Route::get('/music','MusicController@getMusicList');
    Route::get('/blog','BlogController@blog');
//    Route::get('/notify','');
    Route::post('/login','UserController@login');
    Route::prefix('upload')->group(function (){
        Route::post('/music','MusicController@uploadMusic');
        Route::post('/image','FileController@uploadImage');
    });
    Route::prefix('add')->group(function (){
        Route::post('/music','MusicController@addMusic');
        Route::post('/addBlog','BlogController@addBlog');
        Route::post('/user','UserController@register');
    });
    Route::prefix('del')->group(function (){
        Route::delete('/music/{id}','MusicController@delMusic');
        Route::delete('/music/{id}','BlogController@delBlog');
    });
    Route::prefix('edit')->group(function (){
        Route::put('/editBlog','BlogController@editBlog');
        Route::put('/userToken','UserController@userTokenEdit');
    });
});
