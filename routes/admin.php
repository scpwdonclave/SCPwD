<?php

Route::get('dashboard', function () { return redirect(route('admin.dashboard.dashboard')); });
Route::get('dashboard/dashboard', 'AdminAuth\AdminHomeController@dashboard')->name('dashboard.dashboard');
Route::get('dashboard/job_roles', 'AdminAuth\AdminHomeController@job_roles')->name('dashboard.jobroles');
Route::post('dashboard/job_roles', 'AdminAuth\AdminHomeController@job_roles_action')->name('dashboard.jobroles');
Route::get('dashboard/scheme', 'AdminAuth\AdminHomeController@scheme')->name('dashboard.scheme');
Route::get('dashboard/holiday', 'AdminAuth\AdminHomeController@holiday')->name('dashboard.holiday');
Route::post('dashboard/holiday-insert', 'AdminAuth\AdminHomeController@holidayInsert')->name('dashboard.holiday-insert');
Route::post('dashboard/holiday-delete', 'AdminAuth\AdminHomeController@holidayDelete')->name('dashboard.holiday-delete');
Route::post('dashboard/scheme', 'AdminAuth\AdminHomeController@scheme_action')->name('dashboard.scheme_action');
/* Admin Verify Partner */
Route::get('training_partners', function () { return redirect(route('admin.tp.partners')); });
Route::get('training_partners/partners', 'AdminAuth\AdminPartnerController@partners')->name('tp.partners');
Route::post('training_partners/partners/api', 'AdminAuth\AdminPartnerController@update_partner_api')->name('tp.partner.api');
Route::get('training_partners/pending-partners', 'AdminAuth\AdminPartnerController@pendingpartners')->name('tp.pp');
Route::get('training_partners/partners/{id}', 'AdminAuth\AdminPartnerController@partnerVerify')->name('training_partner.partner.verify');
Route::get('training_partners/partner-accept/{id}', 'AdminAuth\AdminPartnerController@partnerAccept')->name('training_partner.accept.partner');
Route::get('training_partners/partner-update/{id}', 'AdminAuth\AdminPartnerController@partnerUpdate')->name('training_partner.update.partner');
Route::post('partner-reject', 'AdminAuth\AdminPartnerController@partnerReject')->name('reject.partner');
Route::get('partner-accept/{id}/{tp_id}', 'AdminAuth\AdminPartnerController@partnerUpdateAccept')->name('accept.tp-updt-req');
Route::post('partnerupdate-reject', 'AdminAuth\AdminPartnerController@partnerUpdateReject')->name('reject.tp-updt-req');
Route::post('training_partners/partners-deactive', 'AdminAuth\AdminPartnerController@partnerDeactive')->name('training_partner.partner.deactive');
Route::get('training_partners/partners-active/{id}', 'AdminAuth\AdminPartnerController@partnerActive')->name('training_partner.partner.active');
Route::post('training_partners/partners-comp-details-update', 'AdminAuth\AdminPartnerController@partnerDetailsUpdate')->name('training_partner.comp-details-update');
Route::get('training_partners/partner-target/{id}', 'AdminAuth\AdminPartnerController@partnerTarget')->name('training_partner.partner.target');
Route::post('training_partners/fetch-jobrole', 'AdminAuth\AdminPartnerController@fetchJobrole')->name('tp.fetch-jobrole');
Route::post('training_partners/fetch-prvdata', 'AdminAuth\AdminPartnerController@fetchPrvData')->name('tp.fetch-prvdata');
Route::post('training_partners/partner-jobtarget', 'AdminAuth\AdminPartnerController@jobTarget')->name('tp.partner.jobtarget');
Route::post('training_partners/partner-jobtarget-update', 'AdminAuth\AdminPartnerController@jobTargetUpdate')->name('tp.partner.jobtarget.update');
Route::post('training_partners/partner-jobrole-Deactive', 'AdminAuth\AdminPartnerController@jobroleDeactive')->name('tp.partner.jobrole.deactive');
Route::get('training_partners/partner-jobrole-Active/{id}', 'AdminAuth\AdminPartnerController@jobroleActive')->name('tp.partner.jobrole.active');
// Route::get('training_partners/partner-scheme/{id}', 'AdminAuth\AdminPartnerController@partnerScheme')->name('training_partner.partner.scheme');
Route::post('training_partners/partner-scheme-deactive', 'AdminAuth\AdminPartnerController@partnerSchemeDeactive')->name('tp.partner.scheme.deactive');
Route::get('training_partners/partner-scheme-active/{id}/{pid}', 'AdminAuth\AdminPartnerController@partnerSchemeActive')->name('tp.partner.scheme.active');

Route::get('training_centers', function () { return redirect(route('admin.tc.centers')); });
Route::get('training_centers/centers', 'AdminAuth\AdminCenterController@centers')->name('tc.centers');
Route::get('training_centers/pending-centers', 'AdminAuth\AdminCenterController@pendingCenters')->name('tc.pending-centers');
Route::get('training_centers/centers/{id}', 'AdminAuth\AdminCenterController@centerView')->name('tc.center.view');
Route::get('training_centers/center-verify/{id}', 'AdminAuth\AdminCenterController@centerAccept')->name('tc.center.verify');
Route::post('training_centers/center-reject', 'AdminAuth\AdminCenterController@centerReject')->name('tc.reject.center');
Route::get('training_centers/center-edit/{id}', 'AdminAuth\AdminCenterController@centerEdit')->name('tc.edit.center');
Route::post('training_centers/center-update', 'AdminAuth\AdminCenterController@centerDetailsUpdate')->name('tc.update.center');
Route::post('training_centers/center-deactive', 'AdminAuth\AdminCenterController@centerDeactive')->name('tc.center.deactive');
Route::get('training_centers/center-active/{id}', 'AdminAuth\AdminCenterController@centerActive')->name('tc.center.active');
Route::post('training_centers/center-api', 'AdminAuth\AdminCenterController@centerApi')->name('tc.center.api');

Route::get('training_centers/candidates', 'AdminAuth\AdminCenterController@candidates')->name('tc.candidates');
Route::get('training_centers/candidates/{id}', 'AdminAuth\AdminCenterController@view_candidate')->name('tc.candidate.view');
Route::get('training_centers/candidate-active/{id}', 'AdminAuth\AdminCenterController@candidateActive')->name('tc.candidate.active');
Route::post('training_centers/candidate-deactive', 'AdminAuth\AdminCenterController@candidateDeactive')->name('tc.candidate.deactive');
Route::get('training_centers/candidate-edit/{id}', 'AdminAuth\AdminCenterController@candidateEdit')->name('tc.edit.candidate');
Route::post('training_centers/candidate-update', 'AdminAuth\AdminCenterController@candidateUpdate')->name('tc.update.candidate');


Route::get('trainer/trainers', 'AdminAuth\AdminTrainerController@trainers')->name('tc.trainers');
Route::get('trainer/pending-trainers', 'AdminAuth\AdminTrainerController@pendingTrainers')->name('tc.pending-trainers');
Route::get('trainer/trainers/{id}', 'AdminAuth\AdminTrainerController@trainerView')->name('tc.trainer.view');
Route::get('trainer/dlink-trainers/{id}', 'AdminAuth\AdminTrainerController@dlinkTrainerView')->name('tc.dlink.trainer.view');
Route::get('trainer/trainer-verify/{id}', 'AdminAuth\AdminTrainerController@trainerAccept')->name('tr.trainer.verify');
Route::post('trainer/trainer-reject', 'AdminAuth\AdminTrainerController@trainerReject')->name('tr.reject.trainer');
Route::post('trainer/trainer-dlink', 'AdminAuth\AdminTrainerController@trainerDlink')->name('tr.trainer.dlink');
Route::post('trainer/trainer-deactive', 'AdminAuth\AdminTrainerController@trainerDeactive')->name('tr.trainer.deactive');
Route::get('trainer/trainer-deactive/{id}', 'AdminAuth\AdminTrainerController@trainerActive')->name('tr.trainer.active');
Route::post('trainer/dlink-trainer-deactive', 'AdminAuth\AdminTrainerController@dlinkTrainerDeactive')->name('tr.dlink.trainer.deactive');
Route::get('trainer/dlink-trainer-active/{id}', 'AdminAuth\AdminTrainerController@dlinkTrainerActive')->name('tr.dlink.trainer.active');
Route::get('trainer/trainer-edit/{id}', 'AdminAuth\AdminTrainerController@trainerEdit')->name('tr.edit.trainer');
Route::post('trainer/trainer-update', 'AdminAuth\AdminTrainerController@trainerUpdate')->name('tr.update.trainer');
Route::post('trainer/trainer-api', 'AdminAuth\AdminTrainerController@trainerApi')->name('tr.trainer.api');

/* Batches */
Route::get('batches/batches', 'AdminAuth\AdminBatchController@batches')->name('batch.batches');
Route::get('batches/pending-batches', 'AdminAuth\AdminBatchController@pendingBatches')->name('batch.pb');
Route::get('batches/batch-view/{id}', 'AdminAuth\AdminBatchController@viewBatch')->name('bt.batch.view');
Route::get('batches/batch-verify/{id}', 'AdminAuth\AdminBatchController@batchAccept')->name('bt.batch.verify');
Route::post('batches/batch-reject', 'AdminAuth\AdminBatchController@batchReject')->name('bt.reject.batch');

/* Agencies */
Route::get('agency/agencies', 'AdminAuth\AdminAgencyController@agencies')->name('agency.agencies');