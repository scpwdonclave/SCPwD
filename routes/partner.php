<?php
Route::get('dashboard', function () { return redirect(route('partner.dashboard.dashboard')); });
Route::get('dashboard/dashboard', 'PartnerAuth\PartnerHomeController@index')->name('dashboard.dashboard');

Route::get('/complete_registration', 'PartnerAuth\PartnerHomeController@showCompleteRegistrationForm')->name('comp-register');
Route::post('/complete_registration', 'PartnerAuth\PartnerHomeController@submitCompleteRegistrationForm')->name('comp-register');

/* Custom URLs */
Route::get('profile', 'PartnerAuth\PartnerHomeController@profile')->name('profile');
Route::post('profile', 'PartnerAuth\PartnerHomeController@profile_update')->name('profile');

Route::get('training_centers', function () { return redirect(route('partner.tc.centers')); });
Route::get('training_centers/centers', 'PartnerAuth\PartnerCenterController@centers')->name('tc.centers');
Route::get('training_centers/trainers', 'PartnerAuth\PartnerCenterController@trainers')->name('tc.trainers');
// Route::post('training_centers/add-center', function(Request $request){
//     if (Employee::where($request->section,$request->mail)->first()) {
//         return response()->json(['success' => false], 200);
//     } else {
//         return response()->json(['success' => true], 200);
//     }
// })->name('api.mail');
Route::get('training_centers/add-center', 'PartnerAuth\PartnerCenterController@view_addcenter_form')->name('tc.addcenter');
Route::post('training_centers/add-center', 'PartnerAuth\PartnerCenterController@submit_addcenter_form')->name('tc.addcenter');

    