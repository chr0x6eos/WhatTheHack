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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/challenges','ChallengeController@index')->name('challenges.index');

Route::get('challenges/create', 'ChallengeController@create')->name('challenges.create');
Route::post('challenges', 'ChallengeController@store')->name('challenges.store');
Route::get('challenges/{challenge}','ChallengeController@show')->name('challenges.show');
