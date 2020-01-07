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
Route::post('assessors/assessor-batch-delete', 'AgencyAuth\AgencyAssessorController@deleteBatch')->name('as.batch-delete'); 
Route::post('assessors/assessor-api', 'AgencyAuth\AgencyAssessorApiController@assessorApi')->name('as.assessor.api'); 
// Route::get('batches/view-batch/{id}', 'AgencyAuth\AgencyAssessorController@viewBatch')->name('aa.batch.view'); 

Route::get('batches', 'AgencyAuth\AgencyAssessmentController@myBatch')->name('batch'); 
Route::get('batches/pending', 'AgencyAuth\AgencyAssessmentController@myPendingBatch')->name('pending-batch'); 
Route::get('batches/pending/{id}', 'AgencyAuth\AgencyAssessmentController@pendingBatchApproved')->name('aa.accept.batch'); 
Route::post('batches/pending-reject', 'AgencyAuth\AgencyAssessmentController@pendingBatchReject')->name('aa.reject.batch'); 
Route::get('assessment/pending-approval', 'AgencyAuth\AgencyAssessmentController@pendingAssessmentApproval')->name('assessment.pending-approval'); 
Route::get('assessment/all-assessment', 'AgencyAuth\AgencyAssessmentController@allAssessment')->name('assessment.all-assessment'); 
Route::get('assessment/assessment-view/{id}', 'AgencyAuth\AgencyAssessmentController@assessmentView')->name('assessment.view'); 
Route::get('assessment/assessment-verify/{id}', 'AgencyAuth\AgencyAssessmentController@assessmentAccept')->name('assessment.verify'); 
Route::post('assessment/assessment-reject', 'AgencyAuth\AgencyAssessmentController@assessmentReject')->name('assessment.reject'); 


