<?php

Route::get('/dashboard', 'PartnerAuth\PartnerHomeController@index')->name('dashboard');

/* File Access */
Route::get('files/{action}/{filename}', 'PartnerAuth\FileController@partnerFiles')->where('action', 'view|download')->name('files.partner-file');

Route::get('/complete_registration', 'PartnerAuth\PartnerHomeController@showCompleteRegistrationForm')->name('comp-register');
Route::post('/complete_registration', 'PartnerAuth\PartnerHomeController@submitCompleteRegistrationForm')->name('comp-register');

/* Custom URLs */
Route::get('profile', 'PartnerAuth\PartnerHomeController@profile')->name('profile');
Route::post('profile', 'PartnerAuth\PartnerHomeController@profile_update')->name('profile');

    