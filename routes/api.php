<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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





Route::group(['prefix' => 'v1'], function() {
        



Route::get('/movies', 'MovieController@index');

//Route::get('/addMovie', 'MovieController@create');

Route::post('/addMovie', 'MovieController@store');

Route::get('/view/{id}', 'MovieController@show');

Route::get('/editMovie/{id}', 'MovieController@edit');

Route::post('/updateMovie/{id}', 'MovieController@update');

Route::delete('/deleteMovie/{id}', 'MovieController@destroy');

Route::get('/search', 'MovieController@search');



     

   
});
