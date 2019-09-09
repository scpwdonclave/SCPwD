<?php

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


Route::get('/', function () { return redirect('admin'); });

/* Dashboard */
Route::get('dashboard', function () { return redirect('dashboard/dashboard'); });
Route::get('dashboard/dashboard', 'DashboardController@dashboard')->name('dashboard.dashboard');
Route::get('dashboard/dashboard2', 'DashboardController@dashboard2')->name('dashboard.dashboard2');
Route::get('dashboard/dashboard3', 'DashboardController@dashboard3')->name('dashboard.dashboard3');

/* Layout Format */
Route::get('layoutformat', function () { return redirect('layoutformat/rtl'); });
Route::get('layoutformat/rtl', 'layoutformatController@rtl')->name('layoutformat.rtl');
Route::get('layoutformat/horizontal', 'layoutformatController@horizontal')->name('layoutformat.horizontal');
Route::get('layoutformat/smallmenu', 'layoutformatController@smallmenu')->name('layoutformat.smallmenu');

/* App */
Route::get('app', function () { return redirect('app/mail-inbox'); });
Route::get('app/mail-inbox', 'AppController@mailInbox')->name('app.mail-inbox');
Route::get('app/mail-single', 'AppController@mailSingle')->name('app.mail-single');
Route::get('app/mail-compose', 'AppController@mailCompose')->name('app.mail-compose');
Route::get('app/chat', 'AppController@chat')->name('app.chat');
Route::get('app/calendar', 'AppController@calendar')->name('app.calendar');
Route::get('app/contact-list', 'AppController@contactList')->name('app.contact-list');
Route::get('app/taskboard', 'AppController@taskboard')->name('app.taskboard');

/* File Manager */
Route::get('file-manager', function () { return redirect('file-manager/dashboard'); });
Route::get('file-manager/dashboard', 'FileManagerController@dashboard')->name('file-manager.dashboard');
Route::get('file-manager/documents', 'FileManagerController@documents')->name('file-manager.documents');
Route::get('file-manager/media', 'FileManagerController@media')->name('file-manager.media');
Route::get('file-manager/image', 'FileManagerController@image')->name('file-manager.image');

/* Blog */
Route::get('blog', function () { return redirect('blog/dashboard'); });
Route::get('blog/dashboard', 'BlogController@dashboard')->name('blog.dashboard');
Route::get('blog/blog-post', 'BlogController@blogPost')->name('blog.blog-post');
Route::get('blog/blog-list', 'BlogController@blogList')->name('blog.blog-list');
Route::get('blog/blog-grid', 'BlogController@blogGrid')->name('blog.blog-grid');
Route::get('blog/blog-detail', 'BlogController@blogDetail')->name('blog.blog-detail');

/* UI Elements */
Route::get('ui-elements', function () { return redirect('ui-elements/ui-kit'); });
Route::get('ui-elements/ui-kit', 'UiElementsController@uiKit')->name('ui-elements.ui-kit');
Route::get('ui-elements/alerts', 'UiElementsController@alerts')->name('ui-elements.alerts');
Route::get('ui-elements/collapse', 'UiElementsController@collapse')->name('ui-elements.collapse');
Route::get('ui-elements/colors', 'UiElementsController@colors')->name('ui-elements.colors');
Route::get('ui-elements/dialogs', 'UiElementsController@dialogs')->name('ui-elements.dialogs');
Route::get('ui-elements/icons', 'UiElementsController@icons')->name('ui-elements.icons');
Route::get('ui-elements/list-group', 'UiElementsController@listGroup')->name('ui-elements.list-group');
Route::get('ui-elements/media-object', 'UiElementsController@mediaObject')->name('ui-elements.media-object');
Route::get('ui-elements/modals', 'UiElementsController@modals')->name('ui-elements.modals');
Route::get('ui-elements/notifications', 'UiElementsController@notifications')->name('ui-elements.notifications');
Route::get('ui-elements/progress-bars', 'UiElementsController@progressBars')->name('ui-elements.progress-bars');
Route::get('ui-elements/range-sliders', 'UiElementsController@rangeSliders')->name('ui-elements.range-sliders');
Route::get('ui-elements/nestable', 'UiElementsController@nestable')->name('ui-elements.nestable');
Route::get('ui-elements/tabs', 'UiElementsController@tabs')->name('ui-elements.tabs');
Route::get('ui-elements/waves', 'UiElementsController@waves')->name('ui-elements.waves');

/* Widgets */
Route::get('widgets', function () { return redirect('widgets/app'); });
Route::get('widgets/app', 'WidgetsController@app')->name('widgets.app');
Route::get('widgets/data', 'WidgetsController@data')->name('widgets.data');

/* eCommerce */
Route::get('ecommerce', function () { return redirect('ecommerce/dashboard'); });
Route::get('ecommerce/dashboard', 'EcommerceController@dashboard')->name('ecommerce.dashboard');
Route::get('ecommerce/product', 'EcommerceController@product')->name('ecommerce.product');
Route::get('ecommerce/product-list', 'EcommerceController@productList')->name('ecommerce.product-list');
Route::get('ecommerce/product-detail', 'EcommerceController@productDetail')->name('ecommerce.product-detail');
Route::get('ecommerce/orders', 'EcommerceController@orders')->name('ecommerce.orders');
Route::get('ecommerce/cart', 'EcommerceController@cart')->name('ecommerce.cart');
Route::get('ecommerce/checkout', 'EcommerceController@checkout')->name('ecommerce.checkout');

/* Forms */
Route::get('forms', function () { return redirect('forms/advance-elements'); });
Route::get('forms/basic-elements', 'FormsController@basicElements')->name('forms.basic-elements');
Route::get('forms/advance-elements', 'FormsController@advanceElements')->name('forms.advance-elements');
Route::get('forms/examples', 'FormsController@examples')->name('forms.examples');
Route::get('forms/validation', 'FormsController@validation')->name('forms.validation');
Route::get('forms/wizard', 'FormsController@wizard')->name('forms.wizard');
Route::get('forms/editors', 'FormsController@editors')->name('forms.editors');
Route::get('forms/dragdrop', 'FormsController@dragdrop')->name('forms.dragdrop');

/* Table */
Route::get('table', function () { return redirect('table/basic'); });
Route::get('table/basic', 'TableController@basic')->name('table.basic');
Route::get('table/normal', 'TableController@normal')->name('table.normal');
Route::get('table/jquery-datatable', 'TableController@jqueryDatatable')->name('table.jquery-datatable');
Route::get('table/editable', 'TableController@editable')->name('table.editable');
Route::get('table/color', 'TableController@color')->name('table.color');
Route::get('table/filter', 'TableController@filter')->name('table.filter');
Route::get('table/dragger', 'TableController@dragger')->name('table.dragger');

/* Charts */
Route::get('charts', function () { return redirect('charts/morris'); });
Route::get('charts/morris', 'ChartsController@morris')->name('charts.morris');
Route::get('charts/flot', 'ChartsController@flot')->name('charts.flot');
Route::get('charts/chartjs', 'ChartsController@chartjs')->name('charts.chartjs');
Route::get('charts/sparkline', 'ChartsController@sparkline')->name('charts.sparkline');
Route::get('charts/jquery-knob', 'ChartsController@jqueryKnob')->name('charts.jquery-knob');
Route::get('charts/c3', 'ChartsController@c3')->name('charts.c3');
Route::get('charts/echart', 'ChartsController@echart')->name('charts.echart');

/* Maps */
Route::get('map', function () { return redirect('map/yandex'); });
Route::get('map/yandex', 'MapController@yandex')->name('map.yandex');
Route::get('map/jvector', 'MapController@jvector')->name('map.jvector');

/* Authentication */
Route::get('authentication', function () { return redirect('authentication/login'); });
Route::get('authentication/login', 'AuthenticationController@login')->name('authentication.login');
Route::get('authentication/register', 'AuthenticationController@register')->name('authentication.register');
Route::get('authentication/forgot-password', 'AuthenticationController@forgotPassword')->name('authentication.forgot-password');
Route::get('authentication/page404', 'AuthenticationController@page404')->name('authentication.page404');
Route::get('authentication/page500', 'AuthenticationController@page500')->name('authentication.page500');
Route::get('authentication/offline', 'AuthenticationController@offline')->name('authentication.offline');
Route::get('authentication/lockscreen', 'AuthenticationController@lockscreen')->name('authentication.lockscreen');

/* Pages */
Route::get('pages', function () { return redirect('pages/blank-page'); });
Route::get('pages/blank-page', 'PagesController@blankPage')->name('pages.blank-page');
Route::get('pages/profile', 'PagesController@profile')->name('pages.profile');
Route::get('pages/image-gallery', 'PagesController@imageGallery')->name('pages.image-gallery');
Route::get('pages/timeline', 'PagesController@timeline')->name('pages.timeline');
Route::get('pages/pricing', 'PagesController@pricing')->name('pages.pricing');
Route::get('pages/invoices', 'PagesController@invoices')->name('pages.invoices');
Route::get('pages/search-results', 'PagesController@searchResults')->name('pages.search-results');
Route::get('pages/faq', 'PagesController@faq')->name('pages.faq');

/* Admin Routes */
Route::group(['prefix' => 'admin'], function () {
  Route::get('/', function () { return redirect('admin/login'); });
  Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'AdminAuth\LoginController@login');
  Route::post('/logout', 'AdminAuth\LoginController@logout')->name('admin.logout');
  
  Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('admin.register');
  Route::post('/register', 'AdminAuth\RegisterController@register');
  
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

/* File Access */
Route::get('partner/files/{action}/{filename}', 'PartnerAuth\FileController@partnerFiles')->where('action', 'view|download')->name('partner.files.partner-file');
