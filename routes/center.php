<?php

Route::get('dashboard', function () { return redirect(route('center.dashboard.dashboard')); });
Route::get('dashboard/dashboard', 'CenterAuth\CenterHomeController@index')->name('dashboard.dashboard');
Route::get('dashboard/job_roles', 'CenterAuth\CenterHomeController@jobroles')->name('dashboard.jobroles');
// Route::get('dashboard/job_roles/{id}', 'CenterAuth\CenterHomeController@viewjobrole')->name('dashboard.jobroles.view');

/* Custom URLs */
Route::get('profile', 'CenterAuth\CenterHomeController@profile')->name('profile');
Route::post('profile', 'CenterAuth\CenterHomeController@profile_update')->name('profile');

Route::get('candidates', 'CenterAuth\CenterHomeController@candidates')->name('candidates');
Route::get('candidates/{id}', 'CenterAuth\CenterHomeController@view_candidate')->name('candidate.view');
Route::get('add-candidate', 'CenterAuth\CenterHomeController@addcandidate')->name('addcandidate');
Route::post('add-candidate', 'CenterAuth\CenterHomeController@submit_candidate')->name('submitcandidate');

Route::post('add-candidate-api', 'CenterAuth\CenterHomeController@candidate_api')->name('addcandidate.api');