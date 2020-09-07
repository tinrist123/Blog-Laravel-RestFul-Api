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


Route::group(['prefix' => 'v1'], function () {
    Route::resource('user', 'api\UserController')->only('index');

    Route::apiResource('comments', 'api\CommentController');

    Route::group(['prefix' => 'tags'], function () {
        Route::get('', 'api\TagController@index');
        Route::post('', 'api\TagController@store');

        Route::get('post/{id}', 'api\TagController@getPost');
        Route::get('post/{id}/page={page}', 'api\TagController@getPostsPerPage');

        Route::get('post/total/{id}', 'api\TagController@getTotalPostsOnTag');
    });


    Route::group(['prefix' => 'post'], function () {
        Route::post('', 'api\PostController@store');

        Route::get('new/page/{page}', 'api\PostController@getNewPosts');
        Route::get('total', 'api\PostController@countAllPosts');

        Route::get('{id}', 'api\PostController@show');
        Route::get('user/{id}', 'api\PostController@showUser');
        Route::get('comment/{id}', 'api\PostController@showComment');
        Route::get('category/{id}', 'api\PostController@showCate');
        Route::get('tag/{id}', 'api\PostController@showTag');

        Route::get('related/{id}', 'api\PostController@relatedPosts');

        Route::get('category/image/{id}', 'api\PostController@catePosts');

        Route::get('tags/{id}', 'api\PostController@tagsPost');
    });


    Route::group(['prefix' => 'category'], function () {
        Route::get('all', 'api\CategoryController@allCate');
        Route::get('', 'api\CategoryController@index');
        Route::post('', 'api\CategoryController@store');

        Route::get('post/{id}', 'api\CategoryController@getPostsonCate');
        Route::get('post/{id}/page={page}', 'api\CategoryController@getPostsonPage');

        Route::get('post/total/{id}', 'api\CategoryController@getTotalPostsonCate');

        Route::get('test', 'api\CategoryController@test');
    });
});
