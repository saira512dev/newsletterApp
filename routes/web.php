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

Route::get('/', function () {
    return view('pages/home');
})->name('home');
Route::post('/subscribe','UserController@store')->name('add.subscriber');
Route::get('/getByUser', function () {
    return view('pages/getEmail');
})->name('get.userEmail');
Route::post('/newsletters','NewsletterController@getByEmail');

