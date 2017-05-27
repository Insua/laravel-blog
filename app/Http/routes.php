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
    return redirect('admin/post');
});

Route::group(['namespace' => 'Admin','middleware'=> 'auth','prefix' => 'admin'],function (){
    Route::resource('post','PostController');
    Route::resource('tag','TagController',['except'=>'show']);
    Route::get('upload','UploadController@index')->name('admin.upload');

    Route::post('upload/file','UploadController@uploadFile');
    Route::delete('upload/file','UploadController@deleteFile');
    Route::post('upload/folder','UploadController@createFolder');
    Route::delete('upload/folder','UploadController@deleteFolder');
});

//logging in and out
Route::get('auth/login','Auth\AuthController@getLogin')->name('login');
Route::post('auth/login','Auth\AuthController@postLogin')->name('login');
Route::get('auth/logout','Auth\AuthController@getLogout')->name('logout');
