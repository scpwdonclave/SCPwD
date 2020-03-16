<?php

use Illuminate\Support\Facades\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/', function () { return redirect('admin'); });

Route::get('/', 'Controller@index')->name('index');

/* Admin Routes */
Route::group(['prefix' => 'admin'], function () {
  Route::get('/', function () { return redirect('admin/login'); });
  Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'AdminAuth\LoginController@login');
  Route::post('/logout', 'AdminAuth\LoginController@logout')->name('admin.logout');
  
  Route::get('/password', function () { return redirect('admin/password/reset'); });
  Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
  Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
  Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset');
  Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm')->name('admin.password.reset');

});
/* End Admin Routes */ 

/* Partner Routes */
Route::group(['prefix' => 'partner'], function () {
  Route::get('/', function () { return redirect('partner/login'); });
  Route::get('/login', 'PartnerAuth\LoginController@showLoginForm')->name('partner.login');
  Route::post('/login', 'PartnerAuth\LoginController@login');
  Route::post('/logout', 'PartnerAuth\LoginController@logout')->name('partner.logout');

  Route::get('/register', 'PartnerAuth\RegisterController@showRegistrationForm')->name('partner.register');
  Route::post('/register', 'PartnerAuth\RegisterController@register');

  Route::get('/password', function () { return redirect('partner/password/reset'); });
  Route::post('/password/email', 'PartnerAuth\ForgotPasswordController@sendResetLinkEmail')->name('partner.password.email');
  Route::get('/password/reset', 'PartnerAuth\ForgotPasswordController@showLinkRequestForm')->name('partner.password.request');
  Route::post('/password/reset', 'PartnerAuth\ResetPasswordController@reset');
  Route::get('/password/reset/{token}', 'PartnerAuth\ResetPasswordController@showResetForm')->name('partner.password.reset');
});
/* End Partner Routes */

/* Center Routes */
Route::group(['prefix' => 'center'], function () {
  Route::get('/', function () { return redirect('center/login'); });
  Route::get('/login', 'CenterAuth\LoginController@showLoginForm')->name('center.login');
  Route::post('/login', 'CenterAuth\LoginController@login');
  Route::post('/logout', 'CenterAuth\LoginController@logout')->name('center.logout');

  Route::get('/password', function () { return redirect('center/password/reset'); });
  Route::post('/password/email', 'CenterAuth\ForgotPasswordController@sendResetLinkEmail')->name('center.password.email');
  Route::get('/password/reset', 'CenterAuth\ForgotPasswordController@showLinkRequestForm')->name('center.password.request');
  Route::post('/password/reset', 'CenterAuth\ResetPasswordController@reset');
  Route::get('/password/reset/{token}', 'CenterAuth\ResetPasswordController@showResetForm')->name('center.password.reset');
});
/* End Center Routes */

/* Agency Routes */
Route::group(['prefix' => 'agency'], function () {
  Route::get('/', function () { return redirect('agency/login'); });
  Route::get('/login', 'AgencyAuth\LoginController@showLoginForm')->name('agency.login');
  Route::post('/login', 'AgencyAuth\LoginController@login');
  Route::post('/logout', 'AgencyAuth\LoginController@logout')->name('agency.logout');

  Route::get('/password', function () { return redirect('agency/password/reset'); });
  Route::post('/password/email', 'AgencyAuth\ForgotPasswordController@sendResetLinkEmail')->name('agency.password.email');
  Route::get('/password/reset', 'AgencyAuth\ForgotPasswordController@showLinkRequestForm')->name('agency.password.request');
  Route::post('/password/reset', 'AgencyAuth\ResetPasswordController@reset');
  Route::get('/password/reset/{token}', 'AgencyAuth\ResetPasswordController@showResetForm')->name('agency.password.reset');
});
/* End Agency Routes */

/* Assessor Routes */
Route::group(['prefix' => 'assessor'], function () {
  Route::get('/', function () { return redirect('assessor/login'); });
  Route::get('/login', 'AssessorAuth\LoginController@showLoginForm')->name('assessor.login');
  Route::post('/login', 'AssessorAuth\LoginController@login');
  Route::post('/logout', 'AssessorAuth\LoginController@logout')->name('assessor.logout');

  Route::get('/password', function () { return redirect('assessor/password/reset'); });
  Route::post('/password/email', 'AssessorAuth\ForgotPasswordController@sendResetLinkEmail')->name('assessor.password.email');
  Route::get('/password/reset', 'AssessorAuth\ForgotPasswordController@showLinkRequestForm')->name('assessor.password.request');
  Route::post('/password/reset', 'AssessorAuth\ResetPasswordController@reset');
  Route::get('/password/reset/{token}', 'AssessorAuth\ResetPasswordController@showResetForm')->name('assessor.password.reset');
});
/* End Assessor Routes */

/* File Access */
Route::get('admin/scheme/{logo}', 'AdminAuth\FileController@schemeFiles')->name('admin.scheme');
Route::get('partner/requirements', 'PartnerAuth\FileController@partnerRequirement')->name('partner.requirements');
Route::get('partner/files/{action}/{filename}', 'PartnerAuth\FileController@partnerFiles')->where('action', 'view|download')->name('partner.files.partner-file');
Route::get('trainer/files/{id}/{action}/{filename}', 'PartnerAuth\FileController@trainerFiles')->where('action', 'view|download')->name('trainer.files.trainer-file');
Route::get('center/files/{action}/{id}/{filename}', 'CenterAuth\FileController@centerFiles')->where('action', 'view|download')->name('center.files.center-file');
Route::get('candidate/files/{action}/{id}/{file}', 'FileController@candidateFiles')->where('action', 'view|download')->where('file', 'doc|cert')->name('center.files.candidate-file');
Route::get('assessor/files/{id}/{action}/{column}', 'FileController@assessorFiles')->where('action', 'view|download')->name('agency.files.assessor-file');
Route::get('assessor/assessment-files/{id}/{action}/{column}', 'FileController@assessmentFiles')->where('action', 'view|download')->name('agency.files.assessment-file');
Route::get('admin/complain-files/{id}/{action}/{column}', 'FileController@supportFiles')->where('action', 'view|download')->name('admin.support.complain-file');
Route::get('partner/complain-files/{id}/{action}/{column}', 'FileController@supportFiles')->where('action', 'view|download')->name('partner.support.complain-file');
Route::get('center/complain-files/{id}/{action}/{column}', 'FileController@supportFiles')->where('action', 'view|download')->name('center.support.complain-file');
Route::get('agency/complain-files/{id}/{action}/{column}', 'FileController@supportFiles')->where('action', 'view|download')->name('agency.support.complain-file');
Route::get('assessor/complain-files/{id}/{action}/{column}', 'FileController@supportFiles')->where('action', 'view|download')->name('assessor.support.complain-file');


/* QR Data For Assessment */
Route::get('assessment/digital-certificate/{id}', 'QrController@qrData')->name('assessment-qrdata');



