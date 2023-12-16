<?php


use App\Http\Controllers\Admin\CKEditorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FormController;
use App\Http\Controllers\Admin\FormValueController;
use App\Http\Controllers\Admin\Header1Controller;
use App\Http\Controllers\Admin\Header2Controller;
use App\Http\Controllers\Admin\MarketController;
use App\Http\Controllers\Admin\MessagesController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\Home\IndexController;
use App\Http\Controllers\Home\MarketHomeController;
use App\Http\Controllers\Home\ProfileController;
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

});

Route::resource('role', '\App\Http\Controllers\Admin\RoleController');
Route::post('/role-permission/{id}', [
    'as' => 'roles_permit',
    'uses' => '\App\Http\Controllers\Admin\RoleController@assignPermission',
]);

Route::get('form-detail/id', [HomeController::class, 'form_details'])->name('form.details');

/////////////////////////////////web
Route::get('/', [IndexController::class, 'index'])->name('home.index');
Route::get('/redirect-user', [IndexController::class, 'redirectUser'])->name('home');
Route::get('/bid/{market}', [MarketHomeController::class, 'bid'])->name('home.bid');
Route::post('/bid_market/', [MarketHomeController::class, 'bid_market'])->name('home.bid_market');
Route::post('/refreshMarketTable', [MarketHomeController::class, 'refreshMarketTable'])->name('home.refreshMarketTable');
Route::post('/refreshMarket', [MarketHomeController::class, 'refreshMarket'])->name('home.refreshMarket');
Route::post('/refreshBidTable', [MarketHomeController::class, 'refreshBidTable'])->name('home.refreshBidTable');
Route::name('admin.')->prefix('/admin-panel/management/')->group(function () {
    //dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::middleware('permission:header-setting')->group(function () {
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
    });
    //header1

    //Config
    Route::middleware('permission:user')->group(function () {
        //users
        Route::get('users/{type}/index', [UserController::class, 'index'])->name('users.index');
        Route::post('users/remove', [UserController::class, 'remove'])->name('user.remove');
        Route::get('users/{type}/{user}/mails', [UserController::class, 'mails'])->name('user.mails');
        Route::get('users/{type}/{user}/mail/{mail}', [UserController::class, 'mail'])->name('user.mail');
        Route::post('users/sendMessage/mail/{user}', [UserController::class, 'sendMessage'])->name('user.sendMessage');
        Route::post('users/update_role/{user}', [UserController::class, 'update_role'])->name('user.update_role');
        //permission
        Route::resource('permission', '\App\Http\Controllers\Admin\PermissionController');
        Route::delete('permission', [PermissionController::class, 'delete'])->name('permission.delete');
        //roles
        Route::resource('roles', '\App\Http\Controllers\Admin\RoleController');
        Route::delete('role', [RoleController::class, 'delete'])->name('role.delete');
        //wallet
        Route::get('/wallet/{user}/index', [WalletController::class, 'index'])->name('user.wallet');
        Route::post('/wallet_change', [WalletController::class, 'wallet_change'])->name('user.wallet.change');
    });
    Route::post('users/reset_password/{user}', [UserController::class, 'reset_password'])->middleware('permission:user|user-edit')->name('user.reset_password');
    Route::get('users/{type}/{user}', [UserController::class, 'edit'])->middleware('permission:user|user-edit')->name('user.edit');
    Route::put('users/{type}/{user}', [UserController::class, 'update'])->middleware(['permission:user|user-edit'])->name('user.update');
    Route::middleware('permission:form')->group(function () {
        //form
        Route::resource('forms', FormController::class);
        Route::get('design/{id}', [FormController::class, 'design'])->name('forms.design');
        Route::put('/forms/design/{id}', [FormController::class, 'designUpdate'])->name('forms.design.update');
        Route::get('/forms/survey/{id}', [FormController::class, 'publicFill'])->name('forms.survey');
        Route::get('/forms/qr/{id}', [FormController::class, 'qrCode'])->name('forms.survey.qr');
        Route::post('/form-duplicate', [FormController::class, 'duplicate'])->name('forms.duplicate')->middleware('permission:form-duplicate');
        Route::post('ckeditors/upload', [FormController::class, 'ckupload'])->name('ckeditors.upload');
        Route::post('dropzone/upload/{id}', [FormController::class, 'dropzone'])->name('dropzone.upload');
        Route::post('ckeditor/upload', [FormController::class, 'upload'])->name('ckeditor.upload');
        Route::get('form-status/{id}', [FormController::class, 'formStatus'])->name('form.status');
        Route::post('forms/destroy/{form}', [FormController::class, 'destroy'])->name('forms.destroy')->middleware('permission:form-delete');
    });
    Route::put('/forms/fill/{id}', [FormController::class, 'fillStore'])->name('forms.fill.store');
    Route::get('/forms/fill/{id}', [FormController::class, 'fill'])->name('forms.fill')->middleware('permission:form-fill');
    //FormValues
    Route::middleware('permission:commodity')->group(function () {
        Route::get('/form-values/{id}/download/pdf', [FormValueController::class, 'download_pdf'])->name('download.form.values.pdf');
        Route::get('/form-values/{id}/edit', [FormValueController::class, 'edit'])->name('edit.form.values');
        Route::get('/form-values/{status}/view', [FormValueController::class, 'showSubmitedForms'])->name('form.values');
        Route::post('submit/Forms', [FormValueController::class, 'submit_form'])->name('submit.form')->middleware('permission:commodity-submit-preview');
        Route::post('copy/Forms', [FormValueController::class, 'copy_form'])->name('copy.form')->middleware('permission:commodity-duplicate');
        Route::post('formvalues/changeStatus', [FormValueController::class, 'changeStatus'])->name('formValue.changeStatus')->middleware('permission:commodity-change-status');
        //Route::get('/form-values/{id}/view', ['as' => 'view.form.values', 'uses' => '\App\Http\Controllers\Admin\FormValueController@showSubmitedForms'])->middleware(['auth', 'xss']);
        Route::resource('formvalues', FormValueController::class);
        Route::get('/form-values/{id}/download/csv2', [FormValueController::class, 'download_csv_2'])->name('download.form.values.csv2');
        Route::post('/mass/export/xlsx', [FormValueController::class, 'export_xlsx'])->name('mass.export.xlsx');
        Route::post('/mass/export/csv', [FormValueController::class, 'export'])->name('mass.export.csv');
        Route::post('filter-chart/{id}', [FormValueController::class, 'getGraphData'])->name('filter_chart');
    });
    //messages
    Route::middleware('permission:message')->group(function () {
        Route::get('messages/emails/index', [MessagesController::class, 'emails'])->name('emails.index');
        Route::get('messages/emails/{id}/edit', [MessagesController::class, 'email_edit'])->name('email.edit');
        Route::put('messages/emails/{mail}/update', [MessagesController::class, 'email_update'])->name('email.update');
        Route::get('messages/alerts/index', [MessagesController::class, 'alerts'])->name('alerts.index');
        Route::get('messages/alerts/{alert}/edit', [MessagesController::class, 'alert_edit'])->name('alert.edit');
        Route::put('messages/alerts/{alert}/update', [MessagesController::class, 'alert_update'])->name('alert.update');
    });


    //Markets
    Route::middleware('permission:markets')->group(function () {
        Route::get('markets', [MarketController::class, 'index'])->name('markets.index');
        Route::get('market/{market}/edit', [MarketController::class, 'edit'])->name('market.edit');
        Route::get('market/{market}/bids', [MarketController::class, 'bids'])->name('market.bids');
        Route::post('market/remove', [MarketController::class, 'remove'])->name('market.remove');
        Route::put('market/{market}/update', [MarketController::class, 'update'])->name('market.update');
        Route::get('market/setting/index_setting', [MarketController::class, 'setting_index'])->name('market.setting.index');
        Route::put('market/setting/update_setting', [MarketController::class, 'setting_update'])->name('market.setting.update_setting');
        Route::get('market/form_edit/{market}', [MarketController::class, 'form_edit'])->name('market.form_edit');
        Route::put('market/form_update/{market}', [MarketController::class, 'form_update'])->name('market.form.update');
    });
    //SaleForm
    Route::get('/sale_form/{page_type?}/{item?}',[FormController::class,'sales_form'])->name('sale_form');
    Route::post('/sales_form/update_or_store/{item?}',[FormController::class,'sales_form_update_or_store'])->name('sale_form.update_or_store');
    Route::get('/sales_form/index/{status}',[FormController::class,'sales_form_index'])->name('sales_form.index');
});
Route::name('profile.')->prefix('/profile/')->group(function () {
    Route::get('index', [ProfileController::class, 'index'])->name('index');
});
Route::post('ckeditor/image_upload', [CKEditorController::class, 'upload'])->name('upload');

