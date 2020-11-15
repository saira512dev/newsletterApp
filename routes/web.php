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
Route::get('/newsletters','NewsletterController@getByEmail');

//admin
Route::get('/admin','AdminController@index')->name('admin.home');
Route::post('/admin/subscriber/create','AdminController@store')->name('admin.add.subscriber');
Route::delete('/admin/user/delete/{id}','UserController@destroy')->name('admin.user.delete');
Route::put('/admin/user/edit/{id}','AdminController@update')->name('admin.user.edit');
Route::get('/admin/newsletter/create',function() {
    return view('pages/admin/newsletter');
})->name('admin.create.newsletter');
Route::post('/admin/newsletter/store','NewsletterController@store')->name('admin.publish.newsletter');
