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

//user-profile routes
Route::get('/profile', 'ProfileController@show')->name('profile.show');
Route::get('/profile/changePassword', 'ProfileController@showChangePWForm')->name('profile.showChangePWForm');
Route::post('/password/change', 'ProfileController@changePW')->name('password.change');
Route::delete('/profile/delete/{user}', 'ProfileController@deleteAccount')->name('profile.delete');


