<?php

Route::get('dashboard', function () { return redirect(route('admin.dashboard.dashboard')); });
Route::get('dashboard/dashboard', 'AdminAuth\AdminHomeController@dashboard')->name('dashboard.dashboard');
Route::get('dashboard/job_roles', 'AdminAuth\AdminHomeController@job_roles')->name('dashboard.jobroles');
Route::post('dashboard/job_roles', 'AdminAuth\AdminHomeController@job_roles_action')->name('dashboard.jobroles');
Route::post('dashboard/job_roles/qualification', 'AdminAuth\AdminHomeController@jobroleQualification')->name('dashboard.jobroles.qualiication');
Route::post('dashboard/job_roles/add/qualification', 'AdminAuth\AdminHomeController@jobroleAddQualification')->name('dashboard.jobroles.qualiication.add');
Route::get('dashboard/scheme', 'AdminAuth\AdminHomeController@scheme')->name('dashboard.scheme');
Route::get('dashboard/holiday', 'AdminAuth\AdminHomeController@holiday')->name('dashboard.holiday');
Route::post('dashboard/holiday-insert', 'AdminAuth\AdminHomeController@holidayInsert')->name('dashboard.holiday-insert');
Route::post('dashboard/holiday-delete', 'AdminAuth\AdminHomeController@holidayDelete')->name('dashboard.holiday-delete');
Route::post('dashboard/scheme', 'AdminAuth\AdminHomeController@scheme_action')->name('dashboard.scheme_action');
/* Admin Verify Partner */
Route::get('training_partners', function () { return redirect(route('admin.tp.partners')); });
Route::get('training_partners/partners', 'AdminAuth\AdminPartnerController@partners')->name('tp.partners');
Route::post('training_partners/partners/api', 'AdminAuth\AdminPartnerController@update_partner_api')->name('tp.partner.api');
Route::get('training_partners/pending-partners', 'AdminAuth\AdminPartnerController@pendingPartners')->name('tp.pp');
Route::get('training_partners/partners/{id}', 'AdminAuth\AdminPartnerController@partnerView')->name('tp.partner.view');
Route::get('training_partners/partner-action/{id}/{reason?}', 'AdminAuth\AdminPartnerController@partnerAction')->name('tp.partner.action');
Route::get('training_partners/partner-update/{id}', 'AdminAuth\AdminPartnerController@partnerUpdate')->name('training_partner.update.partner');
// Route::post('partner-reject', 'AdminAuth\AdminPartnerController@partnerReject')->name('reject.partner');
// Route::get('partner-accept/{id}/{tp_id}', 'AdminAuth\AdminPartnerController@partnerUpdateAccept')->name('accept.tp-updt-req');
// Route::post('partnerupdate-reject', 'AdminAuth\AdminPartnerController@partnerUpdateReject')->name('reject.tp-updt-req');
Route::post('training_partners/partners/', 'AdminAuth\AdminPartnerController@partnerStatusAction')->name('tp.partner.status-action');
Route::post('training_partners/partners-comp-details-update', 'AdminAuth\AdminPartnerController@partnerDetailsUpdate')->name('training_partner.comp-details-update');
Route::get('training_partners/partner-target/{id}', 'AdminAuth\AdminPartnerController@partnerTargetView')->name('tp.target.view');
Route::post('training_partners/partner-target/', 'AdminAuth\AdminPartnerController@partnerTargetAction')->name('tp.target.action');
Route::post('training_partners/fetch-jobrole', 'AdminAuth\AdminPartnerController@fetchJobrole')->name('tp.fetch-jobrole');
Route::post('training_partners/fetch-prvdata', 'AdminAuth\AdminPartnerController@fetchData')->name('tp.fetch-data');
// Route::post('training_partners/partner-jobrole-Deactive', 'AdminAuth\AdminPartnerController@jobroleDeactive')->name('tp.partner.jobrole.deactive');
// Route::get('training_partners/partner-jobrole-Active/{id}', 'AdminAuth\AdminPartnerController@jobroleActive')->name('tp.partner.jobrole.active');
// Route::get('training_partners/partner-scheme/{id}', 'AdminAuth\AdminPartnerController@partnerScheme')->name('training_partner.partner.scheme');
Route::post('training_partners/partner-scheme-deactive', 'AdminAuth\AdminPartnerController@partnerSchemeAction')->name('tp.partner.scheme_action');
// Route::get('training_partners/partner-scheme-active/{id}/{pid}', 'AdminAuth\AdminPartnerController@partnerSchemeActive')->name('tp.partner.scheme.active');

Route::get('training_centers', function () { return redirect(route('admin.tc.centers')); });
Route::get('training_centers/centers', 'AdminAuth\AdminCenterController@centers')->name('tc.centers');
Route::get('training_centers/pending-centers', 'AdminAuth\AdminCenterController@pendingCenters')->name('tc.pending-centers');
Route::get('training_centers/centers/{id}', 'AdminAuth\AdminCenterController@centerView')->name('tc.center.view');
Route::get('training_centers/center-verify/{id}', 'AdminAuth\AdminCenterController@centerAccept')->name('tc.center.verify');
Route::post('training_centers/center-reject', 'AdminAuth\AdminCenterController@centerReject')->name('tc.reject.center');
Route::get('training_centers/center-edit/{id}', 'AdminAuth\AdminCenterController@centerEdit')->name('tc.edit.center');
Route::post('training_centers/center-update', 'AdminAuth\AdminCenterController@centerDetailsUpdate')->name('tc.update.center');

Route::post('training_centers/centers/', 'AdminAuth\AdminCenterController@centerStatusAction')->name('tp.center.status-action');
// Route::post('training_centers/center-deactive', 'AdminAuth\AdminCenterController@centerDeactive')->name('tc.center.deactive');
// Route::get('training_centers/center-active/{id}', 'AdminAuth\AdminCenterController@centerActive')->name('tc.center.active');
Route::post('training_centers/center-api', 'AdminAuth\AdminCenterController@centerApi')->name('tc.center.api');

Route::get('training_centers/candidates', 'AdminAuth\AdminCenterController@candidates')->name('tc.candidates');
Route::get('training_centers/candidates/{id}', 'AdminAuth\AdminCenterController@view_candidate')->name('tc.candidate.view');
Route::post('training_centers/candidates/', 'AdminAuth\AdminCenterController@candidateStatusAction')->name('tp.candidate.status-action');
// Route::get('training_centers/candidate-active/{id}', 'AdminAuth\AdminCenterController@candidateActive')->name('tc.candidate.active');
// Route::post('training_centers/candidate-deactive', 'AdminAuth\AdminCenterController@candidateDeactive')->name('tc.candidate.deactive');
Route::get('training_centers/candidate-edit/{id}', 'AdminAuth\AdminCenterController@candidateEdit')->name('tc.edit.candidate');
Route::post('training_centers/candidate-update', 'AdminAuth\AdminCenterController@candidateUpdate')->name('tc.update.candidate');


Route::get('trainer/trainers', 'AdminAuth\AdminTrainerController@trainers')->name('tc.trainers');
Route::get('trainer/pending-trainers', 'AdminAuth\AdminTrainerController@pendingTrainers')->name('tc.pending-trainers');
Route::get('trainer/trainers/{id}', 'AdminAuth\AdminTrainerController@trainerView')->name('tc.trainer.view');
Route::get('trainer/dlink-trainers/{id}', 'AdminAuth\AdminTrainerController@dlinkTrainerView')->name('tc.dlink.trainer.view');
Route::get('trainer/trainer-verify/{id}', 'AdminAuth\AdminTrainerController@trainerAccept')->name('tr.trainer.verify');
Route::post('trainer/trainer-reject', 'AdminAuth\AdminTrainerController@trainerReject')->name('tr.reject.trainer');

Route::post('trainer/trainers/status-action', 'AdminAuth\AdminTrainerController@trainerStatusAction')->name('trainer.status-action');

// Route::post('trainer/trainer-dlink', 'AdminAuth\AdminTrainerController@trainerDlink')->name('tr.trainer.dlink');
// Route::post('trainer/trainer-deactive', 'AdminAuth\AdminTrainerController@trainerDeactive')->name('tr.trainer.deactive');
// Route::get('trainer/trainer-active/{id}', 'AdminAuth\AdminTrainerController@trainerActive')->name('tr.trainer.active');
// Route::post('trainer/dlink-trainer-deactive', 'AdminAuth\AdminTrainerController@dlinkTrainerDeactive')->name('tr.dlink.trainer.deactive');
// Route::get('trainer/dlink-trainer-active/{id}', 'AdminAuth\AdminTrainerController@dlinkTrainerActive')->name('tr.dlink.trainer.active');
Route::get('trainer/trainer-edit/{id}', 'AdminAuth\AdminTrainerController@trainerEdit')->name('tr.edit.trainer');
Route::post('trainer/trainer-update', 'AdminAuth\AdminTrainerController@trainerUpdate')->name('tr.update.trainer');
Route::post('trainer/trainer-api', 'AdminAuth\AdminTrainerController@trainerApi')->name('tr.trainer.api');

/* Batches */
Route::get('batches/batches', 'AdminAuth\AdminBatchController@batches')->name('batch.batches');
Route::get('batches/pending-batches', 'AdminAuth\AdminBatchController@pendingBatches')->name('batch.pb');
Route::get('batches/batch-updates', 'AdminAuth\AdminBatchController@batchUpdates')->name('batch.bu');
Route::get('batches/batch-updates/{id}/{action}/{reason?}', 'AdminAuth\AdminBatchController@batchUpdateAction')->where('action', 'accept|reject')->name('batch.bu.submit');
Route::get('batches/batch-view/{id}', 'AdminAuth\AdminBatchController@viewBatch')->name('bt.batch.view');
Route::get('batches/batch-view/{id}/{action}/{reason?}', 'AdminAuth\AdminBatchController@batchAction')->where('action', 'accept|reject')->name('batch.action');

/* Agencies */
Route::get('agency/agencies', 'AdminAuth\AdminAgencyController@agencies')->name('agency.agencies');
Route::get('agency/add-agency', 'AdminAuth\AdminAgencyController@addAgency')->name('aa.add-agency');
Route::post('agency/add-agency', 'AdminAuth\AdminAgencyController@insertAgency')->name('aa.insert-agency');
Route::post('agency/agency-deactive', 'AdminAuth\AdminAgencyController@agencyDeactive')->name('aa.agency.deactive');
Route::get('agency/agency-active/{id}', 'AdminAuth\AdminAgencyController@agencyActive')->name('aa.agency.active');
Route::get('agency/agency-view/{id}', 'AdminAuth\AdminAgencyController@agencyView')->name('aa.agency.view');
Route::get('agency/agency-edit/{id}', 'AdminAuth\AdminAgencyController@agencyEdit')->name('aa.edit.agency');
Route::post('agency/agency-update', 'AdminAuth\AdminAgencyController@agencyUpdate')->name('aa.update.agency');
Route::post('agency/agency-api', 'AdminAuth\AdminAgencyController@agencyApi')->name('aa.agency.api');

/* Assessors */
Route::get('assessor/assessors', 'AdminAuth\AdminAssessorController@assessor')->name('assessor.assessors');
Route::get('assessor/pending-assessors', 'AdminAuth\AdminAssessorController@pendingAssessors')->name('as.pending-assessors');
Route::get('assessor/assessor-view/{id}', 'AdminAuth\AdminAssessorController@assessorView')->name('as.assessor.view');
Route::post('assessor/assessor-deactive', 'AdminAuth\AdminAssessorController@assessorDeactive')->name('as.assessor.deactive');
Route::get('assessor/assessor-active/{id}', 'AdminAuth\AdminAssessorController@assessorActive')->name('as.assessor.active');
Route::get('assessor/assessor-verify/{id}', 'AdminAuth\AdminAssessorController@assessorAccept')->name('as.assessor.verify');
Route::post('assessor/assessor-reject', 'AdminAuth\AdminAssessorController@assessorReject')->name('as.reject.assessor');
Route::post('assessors/fetch-jobrole', 'AdminAuth\AdminAssessorController@fetchJobrole')->name('aa.fetch-jobrole'); 
Route::get('assessor/assessor-edit/{id}', 'AdminAuth\AdminAssessorController@assessorEdit')->name('as.edit.assessor');
Route::post('assessor/assessor-update', 'AdminAuth\AdminAssessorController@assessorUpdate')->name('as.update.assessor');
Route::post('assessors/assessor-api', 'AssessorApiController@assessorApi')->name('as.assessor.api'); 
