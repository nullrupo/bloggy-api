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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::match(['get','post'],'register', 'App\Http\Controllers\API\RegisterController@register');
Route::match(['get','post'],'login', 'App\Http\Controllers\API\RegisterController@login');
Route::resource('blogs', 'App\Http\Controllers\API\BlogController');
Route::resource('users', 'App\Http\Controllers\API\UserController');
