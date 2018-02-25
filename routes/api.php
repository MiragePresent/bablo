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
Route::get('checks/{check}', 'CheckController@info')
    ->name('checks.info')
    ->middleware('can:view,check');
Route::patch('checks/{check}', 'CheckController@update')
    ->name('checks.update')
    ->middleware('can:update,check');
Route::delete('checks/{check}', function (\Check $check) {
        $check->delete();
        return response('', 204);
    })
    ->name('checks.delete')
    ->middleware('can:delete,check');

Route::post('quotients', 'QuotientController@create')->name('quotients.create');
Route::get('quotients/{quotient}', 'QuotientController@info')->name('quotients.info');
Route::patch('quotients/{quotient}', 'QuotientController@update')->name('quotients.update');
Route::delete('quotients/{quotient}', 'QuotientController@delete')->name('quotients.delete');

// Payments
Route::patch('{quotient}/payments/{payment}', 'PaymentController@approve')->name('payments.approve');
Route::apiResource('{quotient}/payments', 'PaymentController');