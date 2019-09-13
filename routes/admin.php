<?php

Route::get('dashboard', function () { return redirect(route('admin.dashboard.dashboard')); });
Route::get('dashboard/dashboard', 'AdminAuth\AdminHomeController@dashboard')->name('dashboard.dashboard');
Route::get('dashboard/job_roles', 'AdminAuth\AdminHomeController@job_roles')->name('dashboard.jobroles');
Route::post('dashboard/job_roles', 'AdminAuth\AdminHomeController@job_roles_action')->name('dashboard.jobroles');
/* Admin Verify Partner */
Route::get('training_partners', function () { return redirect(route('admin.tp.partners')); });
Route::get('training_partners/partners', 'AdminAuth\AdminHomeController@partners')->name('tp.partners');
Route::get('training_partners/partners/{id}', 'AdminAuth\AdminHomeController@partnerVerify')->name('training_partner.partner.verify');
Route::get('training_partners/partner-accept/{id}', 'AdminAuth\AdminHomeController@partnerAccept')->name('training_partner.accept.partner');
Route::get('training_partners/partner-update/{id}', 'AdminAuth\AdminHomeController@partnerUpdate')->name('training_partner.update.partner');
Route::post('partner-reject', 'AdminAuth\AdminHomeController@partnerReject')->name('reject.partner');
Route::get('partner-accept/{id}/{tp_id}', 'AdminAuth\AdminHomeController@partnerUpdateAccept')->name('accept.tp-updt-req');
Route::post('partnerupdate-reject', 'AdminAuth\AdminHomeController@partnerUpdateReject')->name('reject.tp-updt-req');
Route::get('training_partners/partners-deactive/{id}', 'AdminAuth\AdminHomeController@partnerDeactive')->name('training_partner.partner.deactive');
Route::get('training_partners/partners-active/{id}', 'AdminAuth\AdminHomeController@partnerActive')->name('training_partner.partner.active');

Route::get('training_centers', function () { return redirect(route('admin.tc.centers')); });
Route::get('training_centers/centers', 'AdminAuth\AdminCenterController@centers')->name('tc.centers');
