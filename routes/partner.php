<?php
Route::get('dashboard', function () { return redirect(route('partner.dashboard.dashboard')); });
Route::get('dashboard/dashboard', 'PartnerAuth\PartnerHomeController@index')->name('dashboard.dashboard');
Route::get('dashboard/job_roles', 'PartnerAuth\PartnerHomeController@jobroles')->name('dashboard.jobroles');
Route::get('dashboard/job_roles/{id}', 'PartnerAuth\PartnerHomeController@viewjobrole')->name('dashboard.jobroles.view');

Route::get('/complete_registration', 'PartnerAuth\PartnerHomeController@showCompleteRegistrationForm')->name('comp-register');
Route::post('/complete_registration', 'PartnerAuth\PartnerHomeController@submitCompleteRegistrationForm')->name('comp-register');
Route::post('/complete_registration/api_partner', 'PartnerAuth\PartnerHomeController@api_partner')->name('tc.api.partner');

/* Custom URLs */
Route::get('profile', 'PartnerAuth\PartnerHomeController@profile')->name('profile');
Route::post('profile', 'PartnerAuth\PartnerHomeController@profile_update')->name('profile');

Route::get('training_centers', function () { return redirect(route('partner.tc.centers')); });
Route::get('training_centers/centers', 'PartnerAuth\PartnerCenterController@centers')->name('tc.centers');
Route::post('training_centers/centers', 'PartnerAuth\PartnerCenterController@updatecenter')->name('tc.center.update');
Route::get('training_centers/centers/{id}', 'PartnerAuth\PartnerCenterController@viewcenter')->name('tc.center.view');
Route::get('training_centers/add-center', 'PartnerAuth\PartnerCenterController@view_addcenter_form')->name('tc.addcenter');
Route::post('training_centers/add-center', 'PartnerAuth\PartnerCenterController@submit_addcenter_form')->name('tc.addcenter');
Route::post('training_centers/add-center-api', 'PartnerAuth\PartnerCenterController@addcenter_api')->name('tc.addcenter.api');

Route::get('training_centers/candidates', 'PartnerAuth\PartnerCenterController@candidates')->name('tc.candidates');
Route::get('training_centers/candidates/{id}', 'PartnerAuth\PartnerCenterController@view_candidate')->name('tc.candidate.view');

/* Trainers */
Route::get('trainers', 'PartnerAuth\PartnerTrainerController@trainers')->name('trainers');
Route::get('trainers/{id}', 'PartnerAuth\PartnerTrainerController@viewtrainer')->name('trainer.view');
Route::get('add-trainer', 'PartnerAuth\PartnerTrainerController@addtrainer')->name('addtrainer');
Route::post('add-trainer', 'PartnerAuth\PartnerTrainerController@submittrainer')->name('submittrainer');
Route::post('add-trainer-api', 'PartnerAuth\PartnerTrainerController@addtrainer_api')->name('addtrainer.api');

/* Batches */
Route::get('batches', 'PartnerAuth\PartnerBatchController@batches')->name('batches');
Route::get('add-batch', 'PartnerAuth\PartnerBatchController@addbatch')->name('addbatch');
Route::post('add-batch', 'PartnerAuth\PartnerBatchController@submitbatch')->name('submitbatch');
Route::post('add-batch/api', 'PartnerAuth\PartnerBatchController@addbatch_api')->name('addbatch.api');
Route::get('batches/batch-view/{id}', 'PartnerAuth\PartnerBatchController@viewBatch')->name('bt.batch.view');
Route::get('batches/batch-edit/{id}', 'PartnerAuth\PartnerBatchController@editBatch')->name('bt.batch.edit');
