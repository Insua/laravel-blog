<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return redirect('/blog');
});

Route::get('blog','BlogController@index')->name('blog.index');
Route::get('blog/{slug}','BlogController@showPost')->name('blog.showPost');

//Admin area
Route::get('admin',function(){
    return redirect();
});

Route::group(['namespace' => 'Admin','middleware'=> 'auth'],function (){
    Route::resource('admin/post','PostController');
    Route::resource('admin/tag','TagController');
    Route::get('admin/upload','UploadController@index');
});

//logging in and out
Route::get('auth/login','Auth\AuthController@getLogin')->name('login');
Route::post('auth/login','Auth\AuthController@postLogin')->name('login');
Route::get('auth/logout','Auth\AuthController@getLogout')->name('logout');