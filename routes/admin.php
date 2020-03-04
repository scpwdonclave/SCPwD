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

Route::get('dashboard/department', 'AdminAuth\AdminHomeController@department')->name('dashboard.department');
Route::get('dashboard/logins', 'AdminAuth\AdminHomeController@logins')->name('dashboard.logins');
Route::post('dashboard/department-insert', 'AdminAuth\AdminHomeController@departmentInsert')->name('dashboard.department-insert');
Route::post('dashboard/department-delete', 'AdminAuth\AdminHomeController@departmentDelete')->name('dashboard.department-delete');

Route::get('profile', 'AdminAuth\AdminHomeController@profile')->name('profile');
Route::post('profile', 'AdminAuth\AdminHomeController@profile_update')->name('profile');
Route::get('notifications', 'AdminAuth\AdminHomeController@notifications')->name('notifications');
Route::post('notification-dismiss', 'AdminAuth\AdminHomeController@clearNotifications')->name('notifications.clear');
Route::get('notification/{id}', 'AdminAuth\AdminHomeController@clickNotification')->name('notification.click');

/* Admin Mis Section */
Route::get('mis', function () { return redirect(route('admin.mis.quick_view')); });
Route::get('mis/quick_view', 'AdminAuth\AdminMisController@mis')->name('mis.quick_view');
Route::get('mis/summary', 'AdminAuth\AdminMisController@summary')->name('mis.summary');
Route::get('mis/summary/tp-tc-Wise', 'AdminAuth\AdminMisController@pageTpTcWise')->name('mis.tp-tc_wise_block');
Route::get('mis/summary/candidate-wise', 'AdminAuth\AdminMisController@pageCandidateWise')->name('mis.candidate_wise_block');
Route::get('mis/summary/job-disability-wise', 'AdminAuth\AdminMisController@pageJobDisabilityWise')->name('mis.job_dsbl_wise_block');
Route::get('mis/summary/agency-wise', 'AdminAuth\AdminMisController@pageAgencyWise')->name('mis.agency_wise_block');
Route::get('mis/summary/placement-wise', 'AdminAuth\AdminMisController@pagePlacementWise')->name('mis.placement_wise_block');

Route::post('mis/summary/tp-tc-wise', 'AdminAuth\AdminMisController@tpTcWiseSummary')->name('mis.tp-tc_wise_enrolled');
Route::post('mis/summary/candidate-wise', 'AdminAuth\AdminMisController@candidateWiseSummary')->name('mis.candidate_wise_enrolled');
Route::post('mis/summary/job-disability-wise', 'AdminAuth\AdminMisController@jobDisabilityWiseSummary')->name('mis.job_disability_wise_enrolled');
Route::post('mis/summary/agency-wise', 'AdminAuth\AdminMisController@agencyWiseSummary')->name('mis.agency_wise_enrolled');
Route::post('mis/summary/candidate-wise-placement', 'AdminAuth\AdminMisController@candidateWisePlacementSummary')->name('mis.candidate_wise_placement');


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
// Route::get('training_centers/center-verify/{id}', 'AdminAuth\AdminCenterController@centerAccept')->name('tc.center.verify');
// Route::post('training_centers/center-reject', 'AdminAuth\AdminCenterController@centerReject')->name('tc.reject.center');
Route::get('training_centers/center-action/{id}/{action}/{reason?}', 'AdminAuth\AdminCenterController@centerAction')->name('tc.center.action');
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
Route::post('candidates/candidate-api', 'AdminAuth\AdminCenterController@candidateApi')->name('candidate.api'); 


Route::get('trainer/trainers', 'AdminAuth\AdminTrainerController@trainers')->name('tc.trainers');
Route::get('trainer/pending-trainers', 'AdminAuth\AdminTrainerController@pendingTrainers')->name('tc.pending-trainers');
Route::get('trainer/trainers/{id}', 'AdminAuth\AdminTrainerController@trainerView')->name('tc.trainer.view'); 
Route::get('trainer/dlink-trainers/{id}', 'AdminAuth\AdminTrainerController@dlinkTrainerView')->name('tc.dlink.trainer.view');
Route::get('trainer/trainer-action/{id}/{reason?}', 'AdminAuth\AdminTrainerController@trainerAction')->name('tp.trainer.action');
// Route::get('trainer/trainer-verify/{id}', 'AdminAuth\AdminTrainerController@trainerAccept')->name('tr.trainer.verify');
// Route::post('trainer/trainer-reject', 'AdminAuth\AdminTrainerController@trainerReject')->name('tr.reject.trainer');

Route::post('trainer/trainers/status-action', 'AdminAuth\AdminTrainerController@trainerStatusAction')->name('trainer.status-action');


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
Route::post('agency/agency-action', 'AdminAuth\AdminAgencyController@agencyStatusAction')->name('tp.agency.status-action');
// Route::post('agency/agency-deactive', 'AdminAuth\AdminAgencyController@agencyDeactive')->name('aa.agency.deactive');
// Route::get('agency/agency-active/{id}', 'AdminAuth\AdminAgencyController@agencyActive')->name('aa.agency.active');
Route::get('agency/agency-view/{id}', 'AdminAuth\AdminAgencyController@agencyView')->name('aa.agency.view');
Route::get('agency/agency-batch/{id}', 'AdminAuth\AdminAgencyController@agencyBatch')->name('aa.agency.batch');
Route::get('agency/agency-edit/{id}', 'AdminAuth\AdminAgencyController@agencyEdit')->name('aa.edit.agency');
Route::post('agency/agency-update', 'AdminAuth\AdminAgencyController@agencyUpdate')->name('aa.update.agency');
Route::post('agency/agency-batch', 'AdminAuth\AdminAgencyController@agencyFetchBatch')->name('aa.fetch-batch');
Route::post('agency/agency-batch-insert', 'AdminAuth\AdminAgencyController@agencyBatchInsert')->name('agency.batch-insert');
Route::post('agency/agency-api', 'AdminAuth\AdminAgencyController@agencyApi')->name('aa.agency.api');
Route::post('agency/agency-batch-delete', 'AdminAuth\AdminAgencyController@agencyBatchDelete')->name('agency.batch-delete');

/* Assessors */
Route::get('assessor/assessors', 'AdminAuth\AdminAssessorController@assessor')->name('as.assessors');
Route::get('assessor/pending-assessors', 'AdminAuth\AdminAssessorController@pendingAssessors')->name('as.pending-assessors');




Route::get('assessor/assessor-view/{id}', 'AdminAuth\AdminAssessorController@assessorView')->name('as.assessor.view');

Route::post('assessor/assessors/', 'AdminAuth\AdminAssessorController@assessorStatusAction')->name('as.assessor.status-action');
Route::get('assessor/assessor-action/{id}/{reason?}', 'AdminAuth\AdminAssessorController@assessorAction')->name('as.assessor.action');
Route::post('assessors/fetch-jobrole', 'AdminAuth\AdminAssessorController@fetchJobrole')->name('aa.fetch-jobrole'); 
Route::get('assessor/assessor-edit/{id}', 'AdminAuth\AdminAssessorController@assessorEdit')->name('as.edit.assessor');
Route::post('assessor/assessor-update', 'AdminAuth\AdminAssessorController@assessorUpdate')->name('as.update.assessor');
Route::post('assessors/assessor-api', 'AdminAuth\AdminAssessorController@assessorApi')->name('as.assessor.api'); 

/* Assessment */
Route::get('assessment/all-assessment', 'AdminAuth\AdminAssessmentController@allAssessment')->name('assessment.all-assessment');
Route::get('assessment/pending-assessment', 'AdminAuth\AdminAssessmentController@pendingAssessment')->name('assessment.pending-assessment');
Route::get('assessment/assessment-view/{id}', 'AdminAuth\AdminAssessmentController@viewAssessment')->name('assessment.view');
Route::get('assessment/approve-reject/{id}/{action}/{reason?}', 'AdminAuth\AdminAssessmentController@assessmentApproveReject')->where('action','accept|reject')->name('assessment.approve.reject'); 
Route::get('assessment/certificate-release/approve-reject/{id}/{action}/{reason?}', 'AdminAuth\AdminAssessmentController@certificateReleaseApproveReject')->where('action','accept|reject|release-request')->name('certificate.release.approve.reject');
Route::get('assessment/assessment-certificate-print/{id}', 'AdminAuth\AdminAssessmentController@certificatePrint')->name('assessment.certificate.print');


// For ReAssessment
Route::get('reassessment/reassessments', 'AdminAuth\AdminReAssessmentController@reassessments')->name('reassessment.reassessments');
Route::get('reassessment/reassessments/{id}', 'AdminAuth\AdminReAssessmentController@viewReAssessment')->name('reassessment.view');
Route::get('reassessment/agency-rejected', 'AdminAuth\AdminReAssessmentController@agencyRejected')->name('reassessment.agencyrejected');
Route::get('reassessment/reassessment-status', 'AdminAuth\AdminReAssessmentController@reassessmentStatus')->name('reassessment.reassessment-status'); 
Route::get('reassessment/reassessment-status/{id}', 'AdminAuth\AdminReAssessmentController@reassessmentStatusView')->name('reassessment.reassessment-status.view'); 
Route::post('reassessment/reassessments', 'AdminAuth\AdminReAssessmentController@AcceptRejectReAssessment')->name('reassessment.accept-reject');
Route::post('reassessment/reassessments/api', 'AdminAuth\AdminReAssessmentController@fetchAgency')->name('reassessment.fetch.agency');
Route::post('reassessment/reassign', 'AdminAuth\AdminReAssessmentController@reassignAgency')->name('reassessment.reassign.submit');

// End For ReAssessment

// For Placements
Route::get('placements', 'AdminAuth\AdminHomeController@placements')->name('placements');
Route::get('placements/view/{id}', 'AdminAuth\AdminHomeController@viewPlacement')->name('placement.view');
Route::get('placements/files/{id}/{file}', 'AdminAuth\FileController@placementFile')->name('placement.file');

//Payment Order
Route::get('paymentorder/pending-request', 'AdminAuth\AdminPaymentOrderController@pendingPayOrderRequest')->name('paymentorder.pending-request');
Route::get('paymentorder/closed-request', 'AdminAuth\AdminPaymentOrderController@closedPayOrderRequest')->name('paymentorder.closed-request');
Route::get('paymentorder/view-pending-payorder/{id}', 'AdminAuth\AdminPaymentOrderController@viewPayOrder')->name('aa.payorder');
Route::get('paymentorder/batch/candidates/{id}', 'AdminAuth\AdminPaymentOrderController@viewBatch')->name('batch.bt-candidate'); 
Route::get('paymentorder/batch/reassessment-candidates/{id}', 'AdminAuth\AdminPaymentOrderController@viewBatchReassessment')->name('batch.reass-bt-candidate'); 
Route::get('paymentorder/reject/{id}/{reason}', 'AdminAuth\AdminPaymentOrderController@paymentOrderReject')->name('paymentorder.reject'); 
Route::post('paymentorder/accept', 'AdminAuth\AdminPaymentOrderController@paymentOrderAccept')->name('paymentorder.accept'); 

//End Payment Order
//Support
Route::get('support/pending-request', 'AdminAuth\AdminSupportController@pendingRequest')->name('support.pending-request');
Route::get('support/pending-request/{id}', 'AdminAuth\AdminSupportController@assignRequestToOnclave')->name('support.assign-to-onclave');
Route::get('support/closed-request', 'AdminAuth\AdminSupportController@closedRequest')->name('support.closed-request');
Route::get('support/view-complain/{id}', 'AdminAuth\AdminSupportController@viewComplain')->name('support.complain-view');
Route::post('support/stage-define', 'AdminAuth\AdminSupportController@stageDefine')->name('support.stage-define');
