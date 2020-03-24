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

Route::get('/sendslack', 'SendRemindsController@send_remind')->name('sendslack');

Route::group(['prefix' => 'admin', 'name' => 'Admin'], function (){
    Route::get('/reminds', 'Admin\RemindDataController@show_reminds')->name('reminds');
    Route::get('/reminds/adds', function (){
        return view('adds');
    })->name('adds');
    Route::post('/reminds/adds/confirm', 'Admin\RemindDataController@add_confirm')->name('add.confirm');
    Route::post('/reminds/adds/back', 'Admin\RemindDataController@back_to_add_page')->name('add.back');
    Route::post('/reminds/adds/complete', 'Admin\RemindDataController@add_complete')->name('add.complete');

    Route::group(['prefix' => 'edit'], function (){
       Route::get('/detail/{id}', 'Admin\RemindDataController@show_edit_reminds')->name('edit');
       Route::post('/confirm/{id}', 'Admin\RemindDataController@edit_confirm_reminds')->name('edit.confirm');
       Route::post('/complete/{id}', 'Admin\RemindDataController@edit_complete')->name('edit.complete');
    });
    Route::get('/delete/{id}','Admin\RemindDataController@delete_reminds')->name('delete');
}

);

