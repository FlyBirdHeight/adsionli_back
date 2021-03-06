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
    Route::get('/user/info/{id}','UserController@findUser');

    Route::post('/blog','BlogController@all');
    Route::post('/login','UserController@login');

    Route::prefix('upload')->group(function (){
        Route::post('/music','MusicController@uploadMusic');
        Route::post('/image','FileController@uploadImage');
        Route::post('/picture','FileController@uploadPicture');
        Route::post('/short','FileController@shortUploadPicture');
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

    Route::prefix('room')->group(function (){
        Route::get('/info/{id}','ChatController@roomInfo');
        Route::patch('/nickName','ChatController@changeNickName');
        Route::patch('/notify','ChatController@uploadNotify');
    });

    Route::prefix('friend')->group(function (){
        Route::get('/friendList/{id}','FirendController@get_all_friend');
        Route::get('/addList/{id}','FirendController@get_all_add');
        Route::get('/allowList/{id}','FirendController@get_all_allow');
        Route::delete('/del/friend','FirendController@del_friend');
        Route::delete('/del/add','FirendController@del_add');
        Route::delete('/del/allow','FirendController@del_allow');
        Route::post('/add/friend','FirendController@addFriend');
        Route::patch('/agree/friend','FirendController@agreeFriend');
    });

    Route::prefix('admin')->group(function (){
        Route::get('/users','AdminController@get_all_user');
        Route::get('/musics','AdminController@get_all_music');
        Route::get('/article','AdminController@get_all_article');
        Route::get('/index','AdminController@index');
    });
});
