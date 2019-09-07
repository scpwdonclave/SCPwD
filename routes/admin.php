<?php

Route::get('dashboard', function () { return redirect(route('admin.dashboard.dashboard')); });
Route::get('dashboard/dashboard', 'AdminAuth\AdminHomeController@dashboard')->name('dashboard.dashboard');
/* Admin Verify Partner */
Route::get('training_partners', function () { return redirect(route('admin.tp.partners')); });
Route::get('training_partners/partners', 'AdminAuth\AdminHomeController@partners')->name('tp.partners');
// Route::GET('/partners', 'AdminAuth\AdminHomeController@partners')->name('partners');
Route::get('training_partners/partners/{id}', 'AdminAuth\AdminHomeController@partnerVerify')->name('training_partner.partner.verify');
Route::get('training_partners/partner-accept/{id}', 'AdminAuth\AdminHomeController@partnerAccept')->name('training_partner.accept.partner');
Route::post('partner-reject', 'AdminAuth\AdminHomeController@partnerReject')->name('reject.partner');
Route::get('partner-accept/{id}/{tp_id}', 'AdminAuth\AdminHomeController@partnerUpdateAccept')->name('accept.tp-updt-req');
Route::post('partnerupdate-reject', 'AdminAuth\AdminHomeController@partnerUpdateReject')->name('reject.tp-updt-req');