<?php

Route::get('dashboard', function () { return redirect(route('assessor.dashboard.dashboard')); });
Route::get('dashboard/dashboard', 'AssessorAuth\AssessorHomeController@index')->name('dashboard.dashboard');

/* Custom URLs */
Route::get('profile', 'AssessorAuth\AssessorHomeController@profile')->name('profile');
Route::post('profile', 'AssessorAuth\AssessorHomeController@profile_update')->name('profile'); 

Route::get('batches', 'AssessorAuth\AssessorBatchController@batches')->name('batch'); 
Route::get('batches/assessment', 'AssessorAuth\AssessorBatchController@pendingApproval')->name('pending.approval'); 
Route::get('batches/candidate-marks/{id}', 'AssessorAuth\AssessorBatchController@candidateMarks')->name('as.batch.candidate-mark'); 
Route::post('batches/candidate-marks-insert', 'AssessorAuth\AssessorBatchController@candidateMarksInsert')->name('as.batch.candidate-mark-insert'); 
Route::post('batches/candidate-marks-update', 'AssessorAuth\AssessorBatchController@candidateMarksUpdate')->name('as.batch.candidate-mark-update'); 
Route::get('batches/assessment-view/{id}', 'AssessorAuth\AssessorBatchController@viewAssessment')->name('assessment.view'); 
Route::get('batches/assessment-edit/{id}', 'AssessorAuth\AssessorBatchController@editAssessment')->name('assessment.edit'); 

Route::get('support/complain', 'AssessorAuth\AssessorSupportController@registerComplain')->name('support.complain'); 
Route::post('support/complain-register', 'AssessorAuth\AssessorSupportController@insertRegisterComplain')->name('support.register-complain'); 
Route::get('support/my-complain', 'AssessorAuth\AssessorSupportController@myComplain')->name('support.my-complain'); 
Route::get('support/view-complain/{id}', 'AssessorAuth\AssessorSupportController@viewComplain')->name('support.complain-view');
