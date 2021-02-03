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
    return view('welcome');
});

Route::get('/target', function () {
    return view('target');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('links', 'LinkController')->middleware('auth');
Route::get('{code}', 'LinkController@redirect')->name('links.short');
Route::post('links/click', 'LinkController@click')->name('links.click');