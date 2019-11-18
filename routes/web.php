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
    return view('welcome_new');
});
Route::get('/agb', function () {
    return view('subpages/agb');
});
Route::get('/contact', function () {
    return view('subpages/contact');
});

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/challenges','ChallengeController@index')->name('challenges.index');
Route::get('/classroom', 'ClassroomController@index')->name('classroom.index');

Route::get('challenges/create', 'ChallengeController@create')->name('challenges.create');
Route::post('challenges', 'ChallengeController@store')->name('challenges.store');
Route::get('challenges/{challenge}','ChallengeController@show')->name('challenges.show');

Route::get('challenges/edit/{challenge}','ChallengeController@edit')->name('challenges.edit');
Route::patch('challenges/update/{challenge}','ChallengeController@update')->name('challenges.update');
Route::delete('challenges/delete/{challenge}','ChallengeController@destroy')->name('challenges.destroy');
Route::get('challenges/deactivate/{challenge}','ChallengeController@deactivate')->name('challenges.deactivate');

// User Management Routes
Route::get('/manage/users', 'ManageUserController@index')->name('manageuser.index');
Route::patch('/manage/users/update/{user}', 'ManageUserController@update')->name('manageuser.update');
Route::get('classroom/create', 'ClassroomController@create')->name('classroom.create');
Route::post('classroom', 'ClassroomController@store')->name('classroom.store');