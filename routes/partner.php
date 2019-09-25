<?php
Route::get('dashboard', function () { return redirect(route('partner.dashboard.dashboard')); });
Route::get('dashboard/dashboard', 'PartnerAuth\PartnerHomeController@index')->name('dashboard.dashboard');
Route::get('dashboard/job_roles', 'PartnerAuth\PartnerHomeController@jobroles')->name('dashboard.jobroles');
Route::get('dashboard/job_roles/{id}', 'PartnerAuth\PartnerHomeController@viewjobrole')->name('dashboard.jobroles.view');

Route::get('/complete_registration', 'PartnerAuth\PartnerHomeController@showCompleteRegistrationForm')->name('comp-register');
Route::post('/complete_registration', 'PartnerAuth\PartnerHomeController@submitCompleteRegistrationForm')->name('comp-register');

/* Custom URLs */
Route::get('profile', 'PartnerAuth\PartnerHomeController@profile')->name('profile');
Route::post('profile', 'PartnerAuth\PartnerHomeController@profile_update')->name('profile');

Route::get('training_centers', function () { return redirect(route('partner.tc.centers')); });
Route::get('training_centers/centers', 'PartnerAuth\PartnerCenterController@centers')->name('tc.centers');
Route::get('training_centers/centers/{id}', 'PartnerAuth\PartnerCenterController@viewcenter')->name('tc.center.view');
Route::get('training_centers/trainers', 'PartnerAuth\PartnerCenterController@trainers')->name('tc.trainers');
Route::get('training_centers/add-center', 'PartnerAuth\PartnerCenterController@view_addcenter_form')->name('tc.addcenter');
Route::post('training_centers/add-center', 'PartnerAuth\PartnerCenterController@submit_addcenter_form')->name('tc.addcenter');
Route::post('training_centers/add-center-api', 'PartnerAuth\PartnerCenterController@addcenter_api')->name('tc.addcenter.api');

    