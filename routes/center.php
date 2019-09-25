<?php

Route::get('dashboard', function () { return redirect(route('center.dashboard.dashboard')); });
Route::get('dashboard/dashboard', 'CenterAuth\CenterHomeController@index')->name('dashboard.dashboard');
Route::get('dashboard/job_roles', 'CenterAuth\CenterHomeController@jobroles')->name('dashboard.jobroles');
// Route::get('dashboard/job_roles/{id}', 'CenterAuth\CenterHomeController@viewjobrole')->name('dashboard.jobroles.view');

/* Custom URLs */
Route::get('profile', 'CenterAuth\CenterHomeController@profile')->name('profile');
Route::post('profile', 'CenterAuth\CenterHomeController@profile_update')->name('profile');
