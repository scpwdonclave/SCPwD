<?php

Route::get('dashboard', function () { return redirect(route('assessor.dashboard.dashboard')); });
Route::get('dashboard/dashboard', 'AssessorAuth\AssessorHomeController@index')->name('dashboard.dashboard');

/* Custom URLs */
Route::get('profile', 'AssessorAuth\AssessorHomeController@profile')->name('profile');
Route::post('profile', 'AssessorAuth\AssessorHomeController@profile_update')->name('profile');