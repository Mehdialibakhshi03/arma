<?php


use App\Http\Controllers\Admin\CKEditorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FormController;
use App\Http\Controllers\Admin\FormValueController;
use App\Http\Controllers\Admin\Header1Controller;
use App\Http\Controllers\Admin\Header2Controller;
use App\Http\Controllers\Admin\MarketController;
use App\Http\Controllers\Admin\MessagesController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CoingateController;
use App\Http\Controllers\DashboardWidgetController;
use App\Http\Controllers\FormCommentsReplyControllerController;
use App\Http\Controllers\Home\IndexController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Auth::routes();

// 'verified_phone'  middleware
Route::group(['middleware' => ['auth', 'xss', 'verified', '2fa']], function () {
    Route::resource('permission', '\App\Http\Controllers\Admin\PermissionController');
    Route::resource('roles', '\App\Http\Controllers\Admin\RoleController');
    Route::resource('formvalues', '\App\Http\Controllers\Admin\FormValueController');
    Route::resource('forms', '\App\Http\Controllers\Admin\FormController');
    Route::resource('poll', '\App\Http\Controllers\PollController');
});

Route::get('/form-values/{id}/download/pdf', ['as' => 'download.form.values.pdf', 'uses' => '\App\Http\Controllers\Admin\FormValueController@download_pdf']);
Route::get('design/{id}', [
    'as' => 'forms.design',
    'uses' => '\App\Http\Controllers\Admin\FormController@design'
])->middleware(['auth', 'xss']);
Route::put('/forms/design/{id}', ['as' => 'forms.design.update', 'uses' => '\App\Http\Controllers\Admin\FormController@designUpdate'])->middleware(['auth', 'xss']);





Route::get('/forms/fill/{id}', ['as' => 'forms.fill', 'uses' => '\App\Http\Controllers\Admin\FormController@fill']);
Route::get('/forms/survey/{id}', ['as' => 'forms.survey', 'uses' => '\App\Http\Controllers\Admin\FormController@publicFill']);
Route::get('/forms/qr/{id}', ['as' => 'forms.survey.qr', 'uses' => '\App\Http\Controllers\Admin\FormController@qrCode']);
Route::put('/forms/fill/{id}', ['as' => 'forms.fill.store', 'uses' => '\App\Http\Controllers\Admin\FormController@fillStore']);
Route::get('/form-values/{id}/edit', ['as' => 'edit.form.values', 'uses' => '\App\Http\Controllers\Admin\FormValueController@edit'])->middleware(['auth']);
//Route::get('/form-values/{id}/view', ['as' => 'view.form.values', 'uses' => '\App\Http\Controllers\Admin\FormValueController@showSubmitedForms'])->middleware(['auth', 'xss']);
Route::get('/form-values/{status}/view/{user?}', ['as' => 'view.form.values', 'uses' => '\App\Http\Controllers\Admin\FormValueController@showSubmitedForms'])->middleware(['auth', 'xss']);
Route::post('/form-duplicate', ['as' => 'forms.duplicate', 'uses' => '\App\Http\Controllers\Admin\FormController@duplicate'])->middleware(['auth', 'xss']);
Route::get('/form-values/{id}/download/csv2', ['as' => 'download.form.values.csv2', 'uses' => '\App\Http\Controllers\Admin\FormValueController@download_csv_2'])->middleware(['auth', 'xss']);
Route::post('/mass/export/xlsx', ['as' => 'mass.export.xlsx', 'uses' => '\App\Http\Controllers\Admin\FormValueController@export_xlsx'])->middleware(['auth', 'xss']);
Route::post('/mass/export/csv', ['as' => 'mass.export.csv', 'uses' => '\App\Http\Controllers\Admin\FormValueController@export'])->middleware(['auth', 'xss']);

Route::get('/settings',function (){
    dd('ok');
})->name('settings');


Route::post('filter-chart/{id}', [FormValueController::class, 'getGraphData'])->name('filter_chart');
Route::resource('role', '\App\Http\Controllers\Admin\RoleController');
Route::post('/role-permission/{id}', [
    'as' => 'roles_permit',
    'uses' => '\App\Http\Controllers\RoleController@assignPermission',
]);

Route::post('ckeditors/upload', [FormController::class, 'ckupload'])->name('ckeditors.upload')->middleware(['auth']);
Route::post('dropzone/upload/{id}', [FormController::class, 'dropzone'])->name('dropzone.upload')->middleware(['Setting']);
Route::post('ckeditor/upload', '\App\Http\Controllers\Admin\FormController@upload')->name('ckeditor.upload')->middleware(['auth']);
Route::get('form-status/{id}', [FormController::class, 'formStatus'])->name('form.status');
Route::get('form-detail/id', [HomeController::class, 'form_details'])->name('form.details');


/////////////////////////////////web
Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('/redirect-user', [IndexController::class, 'redirectUser'])->name('home');
Route::name('admin.')->prefix('/admin-panel/management/')->group(function () {
    //dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    //header1
    Route::get('setting/header1', [Header1Controller::class, 'index'])->name('header1.index');
    Route::get('setting/header1/create', [Header1Controller::class, 'create'])->name('header1.create');
    Route::post('setting/header1/store', [Header1Controller::class, 'store'])->name('header1.store');
    Route::get('setting/header1/edit/{id}', [Header1Controller::class, 'edit'])->name('header1.edit');
    Route::put('setting/header1/update/{item}', [Header1Controller::class, 'update'])->name('header1.update');
    Route::post('setting/header1/remove/{id}', [Header1Controller::class, 'remove'])->name('header1.remove');
    //header2
    Route::get('setting/header2', [Header2Controller::class, 'index'])->name('header2.index');
    Route::get('setting/header2/create', [Header2Controller::class, 'create'])->name('header2.create');
    Route::post('setting/header2/store', [Header2Controller::class, 'store'])->name('header2.store');
    Route::get('setting/header2/edit/{id}', [Header2Controller::class, 'edit'])->name('header2.edit');
    Route::put('setting/header2/update/{item}', [Header2Controller::class, 'update'])->name('header2.update');
    Route::post('setting/header2/remove/{id}', [Header2Controller::class, 'remove'])->name('header2.remove');
    //Config
    Route::get('setting/index', [SettingController::class, 'index'])->name('setting.index');
    Route::put('setting/update', [SettingController::class, 'update'])->name('setting.update');
    //users
    Route::get('users/{type}/index', [UserController::class, 'index'])->name('users.index');
    Route::post('users/remove', [UserController::class, 'remove'])->name('user.remove');
    Route::get('users/{type}/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::get('users/{type}/{user}/mails', [UserController::class, 'mails'])->name('user.mails');
    Route::get('users/{type}/{user}/mail/{mail}', [UserController::class, 'mail'])->name('user.mail');
    Route::put('users/{type}/{user}', [UserController::class, 'update'])->name('user.update');
    Route::post('users/reset_password/{user}', [UserController::class, 'reset_password'])->name('user.reset_password');
    Route::post('users/sendMessage/mail/{user}', [UserController::class, 'sendMessage'])->name('user.sendMessage');
    //messages
    Route::get('messages/emails/index', [MessagesController::class, 'emails'])->name('emails.index');
    Route::get('messages/emails/{id}/edit', [MessagesController::class, 'email_edit'])->name('email.edit');
    Route::put('messages/emails/{mail}/update', [MessagesController::class, 'email_update'])->name('email.update');
    Route::get('messages/alerts/index', [MessagesController::class, 'alerts'])->name('alerts.index');
    Route::get('messages/alerts/{alert}/edit', [MessagesController::class, 'alert_edit'])->name('alert.edit');
    Route::put('messages/alerts/{alert}/update', [MessagesController::class, 'alert_update'])->name('alert.update');
    Route::resource('form', \App\Http\Controllers\Admin\FormController::class);
    //FormValues
    Route::post('submit/Forms', [FormValueController::class, 'submit_form'])->name('submit.form');
    Route::post('copy/Forms', [FormValueController::class, 'copy_form'])->name('copy.form');
    Route::post('formvalues/changeStatus', [FormValueController::class, 'changeStatus'])->name('formValue.changeStatus');
    //Markets
    Route::get('markets/{status}', [MarketController::class, 'index'])->name('markets.index');
    Route::get('market/{status}/create', [MarketController::class, 'create'])->name('market.create');
    Route::post('market/{status}/store', [MarketController::class, 'store'])->name('market.store');
    Route::get('market/{status}/create/{market}', [MarketController::class, 'edit'])->name('market.edit');
    Route::put('market/{status}/update/{market}', [MarketController::class, 'update'])->name('market.update');
    Route::post('market/remove', [MarketController::class, 'remove'])->name('market.remove');
});
Route::post('ckeditor/image_upload', [CKEditorController::class, 'upload'])->name('upload');





