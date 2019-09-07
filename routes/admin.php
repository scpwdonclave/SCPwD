<?php

Route::get('dashboard', function () { return redirect(route('admin.dashboard.dashboard')); });
Route::get('dashboard/dashboard', 'AdminAuth\AdminHomeController@dashboard')->name('dashboard.dashboard');
Route::GET('/partners', 'AdminAuth\AdminHomeController@partners')->name('partners');
/* Admin Verify Partner */
Route::get('training_partner', function () { return redirect(route('admin.partners')); });
Route::get('training_partner/partners', function () { return redirect(route('admin.partners')); });
Route::get('training_partner/partners/{id}', 'AdminAuth\AdminHomeController@partnerVerify')->name('training_partner.partner.verify');
Route::get('training_partner/partner-accept/{id}', 'AdminAuth\AdminHomeController@partnerAccept')->name('training_partner.accept.partner');
Route::post('partner-reject', 'AdminAuth\AdminHomeController@partnerReject')->name('reject.partner');
Route::get('partner-accept/{id}/{tp_id}', 'AdminAuth\AdminHomeController@partnerUpdateAccept')->name('accept.tp-updt-req');
Route::post('partnerupdate-reject', 'AdminAuth\AdminHomeController@partnerUpdateReject')->name('reject.tp-updt-req');