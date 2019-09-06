<?php

Route::get('/dashboard', 'AdminAuth\AdminHomeController@dashboard')->name('dashboard');
Route::GET('/partners', 'AdminAuth\AdminHomeController@partners')->name('partners');
/* Admin Verify Partner */
Route::get('/partner-verify/{id}', 'AdminAuth\AdminHomeController@partnerVerify')->name('partner.verify');
Route::get('partner-accept/{id}', 'AdminAuth\AdminHomeController@partnerAccept')->name('accept.partner');
Route::post('partner-reject', 'AdminAuth\AdminHomeController@partnerReject')->name('reject.partner');
Route::get('partnerupdate-accept/{id}/{tp_id}', 'AdminAuth\AdminHomeController@partnerUpdateAccept')->name('accept.tp-updt-req');
Route::post('partnerupdate-reject', 'AdminAuth\AdminHomeController@partnerUpdateReject')->name('reject.tp-updt-req');