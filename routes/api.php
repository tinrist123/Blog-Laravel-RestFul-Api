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

Route::group(['prefix' => 'v1'], function () {
    Route::resource('user', 'api\UserController')->only('index');


    Route::group(['prefix' => 'comments'], function () {
        Route::post('', 'api\CommentController@store');

        Route::get('post/reply/{idPost}/{idUser}', 'api\CommentController@getReply');


        Route::delete('{idCmt}', 'api\CommentController@destroy')->middleware('auth:api');;
    });


    Route::group(['prefix' => 'tags'], function () {
        Route::get('', 'api\TagController@index');
        Route::post('', 'api\TagController@store');

        Route::get('post/{id}', 'api\TagController@getPost');
        Route::get('post/{id}/page={page}', 'api\TagController@getPostsPerPage');

        Route::get('post/total/{id}', 'api\TagController@getTotalPostsOnTag');
    });


    Route::group(['prefix' => 'post'], function () {


        Route::get('total', 'api\PostController@countAllPosts');
        Route::get('new/page/{page}', 'api\PostController@getNewPosts');
        Route::get('{id}', 'api\PostController@show');
        Route::get('blogger/{id}', 'api\PostController@showBlogger');
        Route::get('comment/{id}', 'api\PostController@showComment');
        Route::get('category/{id}', 'api\PostController@showCate');
        Route::get('tag/{id}', 'api\PostController@showTag');
        Route::get('related/{id}', 'api\PostController@relatedPosts');
        Route::get('category/image/{id}', 'api\PostController@catePosts');
        Route::get('tags/{id}', 'api\PostController@tagsPost');


        Route::post('', 'api\PostController@store')->middleware('auth:api');
        Route::put('{idBlog}', 'api\PostController@update')->middleware('auth:api');;
    });


    Route::group(['prefix' => 'category'], function () {

        Route::get('new', 'api\CategoryController@newCate');

        Route::get('all', 'api\CategoryController@allCate');
        Route::get('', 'api\CategoryController@index');
        Route::post('', 'api\CategoryController@store')->middleware('auth:api');;

        Route::get('post/{id}', 'api\CategoryController@getPostsonCate');
        Route::get('post/{id}/page={page}', 'api\CategoryController@getPostsonPage');

        Route::get('post/total/{id}', 'api\CategoryController@getTotalPostsonCate');
    });

    Route::group(['prefix' => 'blogger'], function () {

        Route::get('', 'api\BloggerController@index');
        Route::get('{id}', 'api\BloggerController@show');
        Route::get('post/{idBlogger}/page={page}', 'api\BloggerController@getOwnPost');
        Route::get('post/total/{idBlogger}', 'api\BloggerController@getTotalOwnPost');

        Route::post('login', 'api\BloggerController@login');
        Route::post('', 'api\BloggerController@store')->middleware('auth:api');;


        Route::put('{idBlogger}', 'api\BloggerController@update')->middleware('auth:api');;
    });
});
