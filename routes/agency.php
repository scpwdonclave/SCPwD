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
Route::post('assessors/assessor-api', 'AssessorApiController@assessorApi')->name('as.assessor.api'); 