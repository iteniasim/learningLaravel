<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/threads/{channel}/{thread}', 'ThreadController@show')->name('threads.show');
Route::delete('/threads/{channel}/{thread}', 'ThreadController@destroy')->name('threads.destroy');
Route::resource('/threads', 'ThreadController')->except(['show', 'destroy']);
Route::get('/threads/{channel}', 'ThreadController@index')->name('threads.ch.index');

Route::get('/threads/{channel}/{thread}/replies', 'ReplyController@index');
Route::post('/threads/{channel}/{thread}/replies', 'ReplyController@store')->name('replies.store');
Route::delete('replies/{reply}', 'ReplyController@destroy')->name('replies.destroy');
Route::patch('replies/{reply}', 'ReplyController@update')->name('replies.update');

Route::post('/replies/{reply}/favourites', 'FavouritesController@store');
Route::delete('/replies/{reply}/favourites', 'FavouritesController@destroy');

Route::get('/profiles/{user}', 'ProfileController@show')->name('profile.show');
