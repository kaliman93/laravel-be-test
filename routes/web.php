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

Route::get('customers', 'CustomersController@index')->name('customers');
Route::get('customers/{customer}/edit', 'CustomersController@edit')->name('customers.edit');
Route::get('customers/add', 'CustomersController@add')->name('customers.add');
Route::post('customers/store', 'CustomersController@store')->name('customers.store');