<?php

Route::get('dashboard', function () { return redirect(route('center.dashboard.dashboard')); });
Route::get('dashboard/dashboard', 'CenterAuth\CenterHomeController@index')->name('dashboard.dashboard');
Route::get('dashboard/job_roles', 'CenterAuth\CenterHomeController@jobroles')->name('dashboard.jobroles');

/* Custom URLs */
Route::get('profile', 'CenterAuth\CenterHomeController@profile')->name('profile');
Route::post('profile', 'CenterAuth\CenterHomeController@profile_update')->name('profile');

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

Route::get('support/complain', 'CenterAuth\CenterSupportController@registerComplain')->name('support.complain'); 
Route::post('support/complain-register', 'CenterAuth\CenterSupportController@insertRegisterComplain')->name('support.register-complain'); 
Route::get('support/my-complain', 'CenterAuth\CenterSupportController@myComplain')->name('support.my-complain');
Route::get('support/view-complain/{id}', 'CenterAuth\CenterSupportController@viewComplain')->name('support.complain-view');

