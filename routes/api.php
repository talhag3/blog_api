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
/* Setup CORS */
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

Route::middleware(['authenticated'])->group(function () {
    Route::get('/me', function (Request $request) {
        return $request->me;
    });
    Route::get('/logout', 'ApiController@logout');

    //Blog Post Routes 
    Route::get('/posts','PostController@getPosts');
    Route::get('/posts/{post}','PostController@getPost');
    Route::get('/post/{id}','PostController@getPost2');
    Route::post('/posts/create','PostController@createPost');
    Route::post('/posts/edit/{post}', 'PostController@updatePost');
    Route::get('/posts/delete/{post}','PostController@deletePost');

    //Blog Post Like
    Route::post('/post_like/{post}', 'PostController@LikePost');
    Route::post('/post_unlike/{post}', 'PostController@unLikePost');
    Route::get('/post_like/{post}', 'PostController@postLikes');


    //Chat Controller 
    Route::post('/create-thread', 'ChatController@createThread');
    Route::get('/threads','ChatController@getThreads');
    Route::get('/thread/{thread}','ChatController@getThread');
    Route::get('/thread-messages','ChatController@getMessages');

    Route::post('/send-message','ChatController@saveMessage');

});

Route::post('/register','ApiController@register');
Route::post('/login','ApiController@login');