<?php

Route::get('dashboard', function () { return redirect(route('admin.dashboard.dashboard')); });
Route::get('dashboard/dashboard', 'AdminAuth\AdminHomeController@dashboard')->name('dashboard.dashboard');
Route::get('dashboard/job_roles', 'AdminAuth\AdminHomeController@job_roles')->name('dashboard.jobroles');
Route::post('dashboard/job_roles', 'AdminAuth\AdminHomeController@job_roles_action')->name('dashboard.jobroles');
Route::get('dashboard/scheme', 'AdminAuth\AdminHomeController@scheme')->name('dashboard.scheme');
Route::post('dashboard/scheme', 'AdminAuth\AdminHomeController@scheme_action')->name('dashboard.scheme_action');
/* Admin Verify Partner */
Route::get('training_partners', function () { return redirect(route('admin.tp.partners')); });
Route::get('training_partners/partners', 'AdminAuth\AdminPartnerController@partners')->name('tp.partners');
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

Route::get('training_centers', function () { return redirect(route('admin.tc.centers')); });
Route::get('training_centers/centers', 'AdminAuth\AdminCenterController@centers')->name('tc.centers');
Route::get('training_centers/centers/{id}', 'AdminAuth\AdminCenterController@centersverify')->name('tc.center.verify');
