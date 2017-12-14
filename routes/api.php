<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users', function () {
   return \User::all()
       ->toArray();
});

Route::get('users/{user}/checks', 'UserController@checks')->name('user.checks');

Route::post('checks', 'CheckController@create')->name('checks.create');
Route::get('checks/{check}', 'CheckController@info')->name('checks.info');
Route::patch('checks/{check}', 'CheckController@update')->name('checks.update');
Route::delete('checks/{check}', 'CheckController@delete')->name('checks.delete');

Route::post('quotients', 'QuotientController@create')->name('quotients.create');
Route::get('quotients/{quotient}', 'QuotientController@info')->name('quotients.info');
Route::patch('quotients/{quotient}', 'QuotientController@update')->name('quotients.update');
Route::delete('quotients/{quotient}', 'QuotientController@delete')->name('quotients.delete');


Route::post('payments', 'PaymentController@create')->name('payments.create');
Route::get('payments/{payment}', 'PaymentController@info')->name('payments.info');
Route::patch('payments/{payment}', 'PaymentController@update')->name('payments.update');
Route::delete('payments/{payment}', 'PaymentController@approve')->name('payments.approve');
Route::delete('payments/{payment}', 'PaymentController@delete')->name('payments.delete');