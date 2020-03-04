<?php

Route::get('dashboard', function () { return redirect(route('assessor.dashboard.dashboard')); });
Route::get('dashboard/dashboard', 'AssessorAuth\AssessorHomeController@index')->name('dashboard.dashboard');

/* Custom URLs */
Route::get('profile', 'AssessorAuth\AssessorHomeController@profile')->name('profile');
Route::post('profile', 'AssessorAuth\AssessorHomeController@profile_update')->name('profile');
Route::get('notifications', 'AssessorAuth\AssessorHomeController@notifications')->name('notifications');
Route::post('notification-dismiss', 'AssessorAuth\AssessorHomeController@clearNotifications')->name('notifications.clear');
Route::get('notification/{id}', 'AssessorAuth\AssessorHomeController@clickNotification')->name('notification.click');

Route::get('batches', 'AssessorAuth\AssessorBatchController@batches')->name('batch'); 
Route::get('batches/batch-view/{id}', 'AssessorAuth\AssessorBatchController@viewAssessmentBatch')->name('batch.view'); 
Route::get('batches/assessments', 'AssessorAuth\AssessorBatchController@assessmentStatus')->name('pending.approval'); 
Route::get('batches/candidate-marks/{id}', 'AssessorAuth\AssessorBatchController@candidateMarks')->name('as.batch.candidate-mark'); 
Route::post('batches/candidate-marks-insert', 'AssessorAuth\AssessorBatchController@candidateMarksInsert')->name('as.batch.candidate-mark-insert'); 
Route::post('batches/candidate-marks-update', 'AssessorAuth\AssessorBatchController@candidateMarksUpdate')->name('as.batch.candidate-mark-update'); 
Route::get('batches/assessment-view/{id}', 'AssessorAuth\AssessorBatchController@viewAssessment')->name('assessment.view'); 
Route::get('batches/assessment-edit/{id}', 'AssessorAuth\AssessorBatchController@editAssessment')->name('assessment.edit'); 

Route::get('batches/reassessments', 'AssessorAuth\AssessorBatchController@reAssessments')->name('reassessments'); 
Route::get('batches/reassessments/{id}', 'AssessorAuth\AssessorBatchController@viewReAssessment')->name('reassessment.view'); 
Route::get('batches/reassessments-edit/{id}', 'AssessorAuth\AssessorBatchController@editReAssessment')->name('reassessment.edit'); 
Route::get('batches/candidate-re-marks/{id}', 'AssessorAuth\AssessorBatchController@candidateReMarks')->name('as.batch.candidate-re-mark'); 
Route::post('batches/candidate-re-marks-insert', 'AssessorAuth\AssessorBatchController@candidateReMarksInsert')->name('as.batch.candidate-re-mark-insert'); 
Route::post('batches/candidate-re-marks-update', 'AssessorAuth\AssessorBatchController@candidateReMarksUpdate')->name('as.batch.candidate-re-mark-update'); 
// Route::get('batches/assessment-view/{id}', 'AssessorAuth\AssessorBatchController@viewAssessment')->name('assessment.view'); 
// Route::get('batches/assessment-edit/{id}', 'AssessorAuth\AssessorBatchController@editAssessment')->name('assessment.edit'); 

Route::get('support/complain', 'AssessorAuth\AssessorSupportController@registerComplain')->name('support.complain'); 
Route::post('support/complain-register', 'AssessorAuth\AssessorSupportController@insertRegisterComplain')->name('support.register-complain'); 
Route::get('support/my-complain', 'AssessorAuth\AssessorSupportController@myComplain')->name('support.my-complain'); 
Route::get('support/view-complain/{id}', 'AssessorAuth\AssessorSupportController@viewComplain')->name('support.complain-view');
