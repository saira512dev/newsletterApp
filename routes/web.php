<?php

use Illuminate\Support\Facades\Route;

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
//subscribers
Route::get('/', function () {
    return view('pages/subscriber/home');
})->name('home');
Route::post('/subscribe','UserController@store')->name('add.subscriber');
Route::get('/getByUser', function () {
    return view('pages/subscriber/getEmail');
})->name('get.userEmail');
Route::post('/newsletters','NewsletterController@getByEmail');

//admin
Route::get('/admin','AdminController@index')->name('admin.home');
Route::post('/admin/subscriber/create','AdminController@store')->name('admin.add.subscriber');
Route::delete('/admin/user/delete/{id}','UserController@destroy')->name('admin.user.delete');
Route::put('/admin/user/edit/{id}','UserController@update')->name('admin.user.edit');
