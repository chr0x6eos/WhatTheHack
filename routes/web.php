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

Auth::routes(['verify' => true]);
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/challenges','ChallengeController@index')->name('challenges.index');
Route::get('/classroom', 'ClassroomController@index')->name('classroom.index');

// User Profile Routes
Route::get('/profile', 'ProfileController@show')->name('profile.show');
Route::get('/profile/changePassword', 'ProfileController@showChangePWForm')->name('profile.showChangePWForm');
Route::post('/profile/password/change', 'ProfileController@changePW')->name('password.change');
Route::get('/profile/changeEmail', 'ProfileController@showChangeEMForm')->name('profile.showChangeEMForm');
Route::post('/profile/email/change', 'ProfileController@changeEM')->name('email.change');
Route::delete('/profile/delete/{user}', 'ProfileController@deleteAccount')->name('profile.delete');
Route::get('/profile/email/change/{id}/{token}', 'ProfileController@changeEmail')->name('change.email');

// Challenge Routes
Route::get('challenges/create', 'ChallengeController@create')->name('challenges.create')->middleware('role:teacher');
Route::post('challenges', 'ChallengeController@store')->name('challenges.store')->middleware('role:teacher');
Route::get('challenges/edit/{challenge}','ChallengeController@edit')->name('challenges.edit')->middleware('role:teacher');
Route::patch('challenges/update/{challenge}','ChallengeController@update')->name('challenges.update')->middleware('role:teacher');
Route::delete('challenges/delete/{challenge}','ChallengeController@destroy')->name('challenges.destroy')->middleware('role:teacher');
Route::get('challenges/deactivate/{challenge}','ChallengeController@deactivate')->name('challenges.deactivate')->middleware('role:teacher');
Route::get('challenges/files/{challenge}','ChallengeController@files')->name('challenges.files')->middleware('role:teacher');
Route::post('challenges/upload/{challenge}','ChallengeController@upload')->name('challenges.upload')->middleware('role:teacher');

Route::get('challenges/{challenge}','ChallengeController@show')->name('challenges.show');
Route::get('challenges/download/{challenge}','ChallengeController@download')->name('challenges.download');
Route::post('challenges/flag/{challenge}','ChallengeController@flag')->name('challenges.flag');

// User Management Routes
Route::get('/manage/users', 'ManageUserController@index')->name('manageuser.index');
Route::patch('/manage/users/update/{user}', 'ManageUserController@update')->name('manageuser.update');

// Classroom Management Routes
Route::get('classrooms/myClassrooms', 'ClassroomController@myClassrooms')->name('classroom.myclassrooms');

Route::get('classroom/create', 'ClassroomController@create')->name('classroom.create')->middleware('role:teacher');
Route::post('classroom', 'ClassroomController@store')->name('classroom.store')->middleware('role:teacher');
Route::get('classroom/edit/{classroom}','ClassroomController@edit')->name('classroom.edit')->middleware('role:teacher');
Route::post('classroom/update/{classroom}', 'ClassroomController@update')->name('classroom.update')->middleware('role:teacher');
Route::get('classroom/editMembers/{classroom}', 'ClassroomController@editMembers')->name('classroom.editmembers')->middleware('role:teacher');
Route::get('classroom/editChallenges/{classroom}', 'ClassroomController@editChallenges')->name('classroom.editchallenges')->middleware('role:teacher');
Route::post('classroom/updateMembers/{classroom}', 'ClassroomController@updateMembers')->name('classroom.updatemembers')->middleware('role:teacher');
Route::patch('classroom/updateChallenges/{classroom}', 'ClassroomController@updateChallenges')->name('classroom.updatechallenges')->middleware('role:teacher');
Route::patch('classroom/deleteMembers/{classroom}', 'ClassroomController@deleteMembers')->name('classroom.deleteMembers')->middleware('role:teacher');
Route::post('classroom/{classroom}/attach','ClassroomController@attach')->name('classroom.attach')->middleware('role:teacher');
Route::delete('classroom/{classroom}/detach','ClassroomController@detach')->name('classroom.detach')->middleware('role:teacher');
Route::delete('classroom/{classroom}', 'ClassroomController@destroy')->name('classroom.destroy')->middleware('role:teacher');
Route::get('classroom/disabledClassrooms', 'ClassroomController@disabled')->name('classroom.disabled')->middleware('role:teacher');
Route::patch('classroom/restore/{classroom}', 'ClassroomController@restore')->name('classroom.restore')->middleware('role:teacher');
Route::get('classroom/showClassroom/{classroom}', 'ClassroomController@showChallenges')->name('classroom.showChallenges')->middleware('auth', 'verified');

// Support/Report Routes
Route::get('support/{challenge}', 'SupportRequestController@create')->name('support.create');
Route::post('submit/{challenge}', 'SupportRequestController@submit')->name('support.submit');
