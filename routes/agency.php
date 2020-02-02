<?php

Route::get('dashboard', function () { return redirect(route('agency.dashboard.dashboard')); });
Route::get('dashboard/dashboard', 'AgencyAuth\AgencyHomeController@index')->name('dashboard.dashboard');

/* Custom URLs */
Route::get('profile', 'AgencyAuth\AgencyHomeController@profile')->name('profile');
Route::post('profile', 'AgencyAuth\AgencyHomeController@profile_update')->name('profile'); 


Route::get('assessors', 'AgencyAuth\AgencyAssessorController@assessor')->name('assessors'); 
Route::get('assessors/add-assessor', 'AgencyAuth\AgencyAssessorController@addAssessor')->name('add-assessor'); 
Route::post('assessors/fetch-jobrole', 'AgencyAuth\AgencyAssessorController@fetchJobrole')->name('aa.fetch-jobrole'); 
Route::post('assessors/assessor-insert', 'AgencyAuth\AgencyAssessorController@assessorInsert')->name('as.assessor.insert'); 
Route::get('assessors/assessor-view/{id}', 'AgencyAuth\AgencyAssessorController@assessorView')->name('as.assessor.view'); 
Route::get('assessors/assessor-batch/{id}', 'AgencyAuth\AgencyAssessorController@assessorBatch')->name('as.assessor.batch'); 
Route::post('assessors/assessor-fetch-batch', 'AgencyAuth\AgencyAssessorController@assessorFetchBatch')->name('as.fetch-batch'); 
Route::post('assessors/assessor-batch-insert', 'AgencyAuth\AgencyAssessorController@assessorBatchInsert')->name('assessor.batch-insert'); 
Route::get('assessors/view-batch/{id}', 'AgencyAuth\AgencyAssessorController@viewBatch')->name('bt.batch.view'); 
Route::post('assessors/assessor-batch-remove', 'AgencyAuth\AgencyAssessorController@removeBatch')->name('as.batch-remove'); 
Route::post('assessors/assessor-api', 'AgencyAuth\AgencyAssessorController@assessorApi')->name('as.assessor.api'); 

Route::get('batches', 'AgencyAuth\AgencyAssessmentController@myBatch')->name('batch'); 
Route::get('batches/view-batch/{id}', 'AgencyAuth\AgencyAssessorController@viewBatch')->name('bt.batch.view-dtl'); 

Route::get('batches/pending', 'AgencyAuth\AgencyAssessmentController@myPendingBatch')->name('pending-batch');
Route::get('batches/pending/{id}/{action}/{reason?}', 'AgencyAuth\AgencyAssessmentController@batchAction')->where('action', 'accept|reject')->name('aa.batch.action');
// Route::get('batches/pending/{id}', 'AgencyAuth\AgencyAssessmentController@pendingBatchApproved')->name('aa.accept.batch'); 
// Route::post('batches/pending-reject', 'AgencyAuth\AgencyAssessmentController@pendingBatchReject')->name('aa.reject.batch'); 
// For Assessment
Route::get('assessment/pending-assessment', 'AgencyAuth\AgencyAssessmentController@pendingAssessment')->name('assessment.pending-assessment'); 
Route::get('assessment/all-assessment', 'AgencyAuth\AgencyAssessmentController@allAssessment')->name('assessment.all-assessment'); 
Route::get('assessment/assessment-view/{id}', 'AgencyAuth\AgencyAssessmentController@viewAssessment')->name('assessment.view'); 
Route::get('assessment/assessment-verify/{id}', 'AgencyAuth\AgencyAssessmentController@assessmentAccept')->name('assessment.verify'); 
Route::post('assessment/assessment-reject', 'AgencyAuth\AgencyAssessmentController@assessmentReject')->name('assessment.reject');
// End For Assessment

// For ReAssessment
Route::get('reassessment/pending-reassessment', 'AgencyAuth\AgencyReAssessmentController@pendingReAssessment')->name('reassessment.pending-reassessment'); 
Route::get('reassessment/all-reassessment', 'AgencyAuth\AgencyReAssessmentController@allReAssessment')->name('reassessment.all-reassessment'); 
Route::get('reassessment/reassessment-view/{id}', 'AgencyAuth\AgencyReAssessmentController@viewReAssessment')->name('reassessment.view'); 
Route::get('reassessment/reassessment-verify/{id}', 'AgencyAuth\AgencyReAssessmentController@reassessmentAccept')->name('reassessment.verify'); 
Route::post('reassessment/reassessment-reject', 'AgencyAuth\AgencyReAssessmentController@reassessmentReject')->name('reassessment.reject'); 
// End For ReAssessment


Route::get('support/complain', 'AgencyAuth\AgencySupportController@registerComplain')->name('support.complain'); 
Route::post('support/complain-register', 'AgencyAuth\AgencySupportController@insertRegisterComplain')->name('support.register-complain'); 
Route::get('support/my-complain', 'AgencyAuth\AgencySupportController@myComplain')->name('support.my-complain'); 
Route::get('support/view-complain/{id}', 'AgencyAuth\AgencySupportController@viewComplain')->name('support.complain-view');




