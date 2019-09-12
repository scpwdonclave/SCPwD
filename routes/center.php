<?php

Route::get('dashboard', function () { return redirect(route('center.dashboard.dashboard')); });
Route::get('dashboard/dashboard', 'CenterAuth\CenterHomeController@index')->name('dashboard.dashboard');

/* Custom URLs */
Route::get('profile', 'PartnerAuth\PartnerHomeController@profile')->name('profile');
Route::post('profile', 'PartnerAuth\PartnerHomeController@profile_update')->name('profile');
