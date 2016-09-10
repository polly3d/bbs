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

Route::resource('/post','PostController');

Route::resource('/comment','CommentController');

Route::resource('/user','UserController');

Route::resource('/vote','VoteController');

Auth::routes();
