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

Route::group(['middleware' => ['jwt.auth']], function() {
    Route::get('logout', 'AuthController@logout');
    Route::get('jobseeker', 'App\Http\Controllers\API\jobseekerController@index');
    Route::post('jobseeker/store', 'App\Http\Controllers\API\jobseekerController@store');
    Route::post('jobseeker/update/{id}', 'App\Http\Controllers\API\jobseekerController@update');
    Route::get('jobseeker/show/{id}', 'App\Http\Controllers\API\jobseekerController@show');
    Route::get('jobseeker/delete/{id}', 'App\Http\Controllers\API\jobseekerController@destroy');

    Route::get('gallery', 'App\Http\Controllers\API\GalleryController@index');
    Route::post('gallery/store', 'App\Http\Controllers\API\GalleryController@store');
    Route::post('gallery/update/{id}', 'App\Http\Controllers\API\GalleryController@update');
    Route::get('gallery/show/{id}', 'App\Http\Controllers\API\GalleryController@show');
    Route::get('gallery/delete/{id}', 'App\Http\Controllers\API\GalleryController@destroy');

});
Route::post('register', 'App\Http\Controllers\AuthController@register');
Route::post('login', 'App\Http\Controllers\AuthController@login');
Route::post('recover', 'App\Http\Controllers\AuthController@recover');
