<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

\Laravel\Passport\Passport::routes(function(\Laravel\Passport\RouteRegistrar $router) {
    $router->forAccessTokens();
},['prefix' => 'api/oauth']);

Route::middleware('api')->prefix('v1')->group(function (){
    Route::get('/music','MusicController@getMusicList');
    Route::get('/blog/{id}','BlogController@blog');
    Route::get('/blog/{id}/comment','BlogController@comment');
    Route::get('/chatRoom/{id}','ChatController@chatRoom');

    Route::post('/blog','BlogController@all');
    Route::post('/login','UserController@login');

    Route::prefix('upload')->group(function (){
        Route::post('/music','MusicController@uploadMusic');
        Route::post('/image','FileController@uploadImage');
    });

    Route::prefix('add')->group(function (){
        Route::post('/music','MusicController@addMusic');
        Route::post('/addBlog','BlogController@addBlog');
        Route::post('/user','UserController@register');
        Route::post('/comment','BlogController@addComment');
        Route::post('/room','ChatController@addChatRoom');
        Route::post('/joinRoom','ChatController@joinRoom');
    });

    Route::prefix('del')->group(function (){
        Route::delete('/music/{id}','MusicController@delMusic');
        Route::delete('/music/{id}','BlogController@delBlog');
    });

    Route::prefix('edit')->group(function (){
        Route::put('/editBlog','BlogController@editBlog');
        Route::put('/userToken','UserController@userTokenEdit');
        Route::patch('/chatRoom','ChatController@editRoom');
    });

//    Route::prefix('chat')->group(function (){
//
//    });
});




















Route::middleware('api')->prefix('v2')->group(function (){
    Route::post('login','ShirleyController@login');
    Route::post('register','ShirleyController@register');
    Route::post('editUser','ShirleyController@editUser');
    Route::post('editUserPassword','ShirleyController@editUserPassword');
    Route::post('uploadImg','ShirleyController@uploadImg');
    Route::get('user/{id}','ShirleyController@user');
    Route::get('special','ShirleyController@special');
    Route::post('addSpecial','ShirleyController@addSpecial');
    Route::get('menupol','ShirleyController@getSpecialByCommentNum');
    Route::get('userSpecial','ShirleyController@getSpecialUser');
    Route::get('message/{id}','ShirleyController@getMessage');
    Route::post('getComment','ShirleyController@getComment');
    Route::post('addComment','ShirleyController@addComment');
    Route::post('addReply','ShirleyController@addReply');
    Route::post('getSpecialByTitle','ShirleyController@getSpecialByTitle');
    Route::post('isLove','ShirleyController@isLove');
    Route::post('addLove','ShirleyController@addLove');
    Route::post('getSpecialById','ShirleyController@getSpecialById');
});
