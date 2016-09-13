<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/','HomeController@index')->name('home');

Route::get('/post/{id}/excellent','PostController@toExcellent')->name('toExcellent');
Route::resource('/post','PostController');

Route::get('/category/{id}','CategoryController@posts')->name('category');

Route::resource('/comment','CommentController');

Route::get('/user/{id}/posts','UserController@posts')->name('userPosts');
Route::get('/user/{id}/comments','UserController@comments')->name('userComments');
Route::get('/user/{id}/votePost','UserController@votePost')->name('userVotePosts');
Route::resource('/user','UserController');

Route::get('/vote/post/{id}','VoteController@votePost')->name('votePost');
Route::get('/vote/comment/{id}','VoteController@voteComment')->name('voteComment');

Auth::routes();
