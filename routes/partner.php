<?php

Route::group(['namespace' => 'Partner'], function() {
    Route::get('/', 'HomeController@index')->name('partner.dashboard');

    // Login
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('partner.login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('partner.logout');

    // Register
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('partner.register');
    Route::post('register', 'Auth\RegisterController@register');

    // Passwords
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('partner.password.email');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('partner.password.request');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('partner.password.reset');

    // Must verify email
    Route::get('email/resend','Auth\VerificationController@resend')->name('partner.verification.resend');
    Route::get('email/verify','Auth\VerificationController@show')->name('partner.verification.notice');
    Route::get('email/verify/{id}','Auth\VerificationController@verify')->name('partner.verification.verify');

});