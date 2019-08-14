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
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('/', 'HomeController@index')->name('home');
Route::get('/rates/list', 'RatesController@index')->name('rates.list');
Route::get('/payments/list', 'PaymentsController@index')->name('payments.list');
Route::get('/payments/new', 'PaymentsController@create')->name('payments.new');
Route::post('/payments/new', 'PaymentsController@processCreate');
Route::get('/payments/edit', 'PaymentsController@edit')->name('payments.edit');
Route::post('/payments/edit', 'PaymentsController@processEdit');
