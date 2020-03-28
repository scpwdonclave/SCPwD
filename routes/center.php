<?php

Route::get('dashboard', function () { return redirect(route('center.dashboard.dashboard')); });
Route::get('dashboard/dashboard', 'CenterAuth\CenterHomeController@index')->name('dashboard.dashboard');
Route::get('dashboard/job_roles', 'CenterAuth\CenterHomeController@jobroles')->name('dashboard.jobroles');

/* Custom URLs */
Route::get('profile', 'CenterAuth\CenterHomeController@profile')->name('profile');
Route::post('profile', 'CenterAuth\CenterHomeController@profile_update')->name('profile');
Route::get('notifications', 'CenterAuth\CenterHomeController@notifications')->name('notifications');
Route::post('notification-dismiss', 'CenterAuth\CenterHomeController@clearNotifications')->name('notifications.clear');
Route::get('notification/{id}', 'CenterAuth\CenterHomeController@clickNotification')->name('notification.click');

Route::get('candidates', 'CenterAuth\CenterHomeController@candidates')->name('candidates');
Route::get('candidates/{id}', 'CenterAuth\CenterHomeController@view_candidate')->name('candidate.view');
Route::get('add-candidate', 'CenterAuth\CenterHomeController@addcandidate')->name('addcandidate');
Route::post('add-candidate', 'CenterAuth\CenterHomeController@submit_candidate')->name('submitcandidate');
Route::post('candidates', 'CenterAuth\CenterHomeController@dropout_candidate')->name('candidate.dropout');

Route::post('add-candidate-api', 'CenterAuth\CenterHomeController@candidate_api')->name('addcandidate.api');
Route::post('candidates/candidate-api', 'CenterAuth\CenterHomeController@candidateApi')->name('candidate.api'); 


/* Batches */
Route::get('batches', 'CenterAuth\CenterBatchController@batches')->name('batches');
Route::get('batches/batch-view/{id}', 'CenterAuth\CenterBatchController@viewBatch')->name('bt.batch.view');
Route::get('batches/reassessment/{id}', 'CenterAuth\CenterBatchController@reassessBatch')->name('bt.batch.reassess');
Route::post('batches/reassessment', 'CenterAuth\CenterBatchController@reassessBatchSubmit')->name('bt.batch.reassess.submit');

Route::get('/reassessments', 'CenterAuth\CenterBatchController@reassessments')->name('reassessments');
Route::get('/reassessments/{id}', 'CenterAuth\CenterBatchController@viewReAssessment')->name('reassessment.view');
Route::get('/reassessments/marks/{id}', 'CenterAuth\CenterBatchController@viewReAssessmentMarks')->name('reassessment.marks.view');


// For Placements
Route::get('placements', 'CenterAuth\CenterHomeController@placements')->name('placements');
Route::get('placements/view/{id}', 'CenterAuth\CenterHomeController@viewPlacement')->name('placement.view');
Route::get('placements/files/{id}/{file}', 'CenterAuth\FileController@placementFile')->name('placement.file');
Route::get('placements/add-placement', 'CenterAuth\CenterHomeController@addPlacement')->name('placement.add');
Route::post('placements/add-placement', 'CenterAuth\CenterHomeController@submitPlacement')->name('placement.submit');
Route::post('placements/update-placement', 'CenterAuth\CenterHomeController@updatePlacement')->name('placement.update');


Route::get('support/complain', 'CenterAuth\CenterSupportController@registerComplain')->name('support.complain'); 
Route::post('support/complain-register', 'CenterAuth\CenterSupportController@insertRegisterComplain')->name('support.register-complain'); 
Route::get('support/my-complain', 'CenterAuth\CenterSupportController@myComplain')->name('support.my-complain');
Route::get('support/view-complain/{id}', 'CenterAuth\CenterSupportController@viewComplain')->name('support.complain-view');

