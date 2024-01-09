<?php


use App\Http\Controllers\Admin\CKEditorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FormController;
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
use App\Http\Controllers\Seller\SellerController;
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

/////////////////////////////////web
Route::get('/', [IndexController::class, 'index'])->name('home.index');
Route::get('/redirect-user', [IndexController::class, 'redirectUser'])->name('home');
Route::post('/startBroadCast', [IndexController::class, 'startBroadCast'])->name('startBroadCast');
Route::post('/MarketTableIndex', [IndexController::class, 'MarketTableIndex'])->name('home.MarketTableIndex');
Route::post('/GetMarket', [MarketHomeController::class, 'GetMarket'])->name('home.GetMarket');
Route::get('/bid/{market}', [MarketHomeController::class, 'bid'])->name('home.bid')->middleware('auth');
Route::post('/bid_market/', [MarketHomeController::class, 'bid_market'])->name('home.bid_market');
Route::post('/remove_bid/', [MarketHomeController::class, 'remove_bid'])->name('home.remove_bid');
Route::post('/refreshMarketTable', [MarketHomeController::class, 'refreshMarketTable'])->name('home.refreshMarketTable');
Route::post('/refreshMarket', [MarketHomeController::class, 'refreshMarket'])->name('home.refreshMarket');
Route::post('/refreshBidTable', [MarketHomeController::class, 'refreshBidTable'])->name('home.refreshBidTable');
Route::post('/refreshSellerTable', [MarketHomeController::class, 'refreshSellerTable'])->name('home.refreshSellerTable');
Route::post('/change_market_status', [MarketHomeController::class, 'change_market_status'])->name('home.change_market_status');
Route::post('/seller_change_offer', [MarketHomeController::class, 'seller_change_offer'])->name('home.seller_change_offer');
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
        Route::get('markets', [MarketController::class, 'index'])->name('markets.index');
        Route::get('market/create', [MarketController::class, 'create'])->name('market.create');
        Route::post('market/store', [MarketController::class, 'store'])->name('market.store');
        Route::get('market/{market}/edit', [MarketController::class, 'edit'])->name('market.edit');
        Route::post('market/remove', [MarketController::class, 'remove'])->name('market.remove');
        Route::put('market/{market}/update', [MarketController::class, 'update'])->name('market.update');
        Route::put('market/form_update/{market}', [MarketController::class, 'form_update'])->name('market.form.update');
        Route::get('market/sale_form/{page_type?}/{item?}',[MarketController::class,'sales_form'])->name('market.sale_form');
        Route::get('market/settings',[MarketController::class,'settings'])->name('markets.settings');
        Route::post('market/settings/update',[MarketController::class,'settings_update'])->name('markets.settings.update');
        Route::post('market/sales_form/update_or_store/{item?}',[MarketController::class,'sales_form_update_or_store'])->name('market.sale_form.update_or_store');
        Route::post('market/getMarket',[MarketController::class,'getMarket'])->name('getMarket');
        Route::post('check_market_status_for_continue',[MarketController::class,'check_market_status_for_continue'])->name('check_market_status_for_continue');
    Route::get('/sales_form/index/{status}',[FormController::class,'sales_form_index'])->name('sales_form.index');
    Route::post('/sales_form/remove',[FormController::class,'sales_form_remove'])->name('sales_form.remove');
    Route::post('/Final_Submit',[FormController::class,'Final_Submit'])->name('Final_Submit');
});

//SaleForm
Route::get('/sale_form/{page_type?}/{item?}',[FormController::class,'sales_form'])->name('sale_form');
Route::post('/sales_form/update_or_store/{item?}',[FormController::class,'sales_form_update_or_store'])->name('sale_form.update_or_store');
Route::post('/sales_form_change_status/',[FormController::class,'change_status'])->name('sale_form.change_status');
Route::get('sales_offer/show/{id}', [FormController::class, 'sales_form_show'])->name('sale_form.show');
//seller
Route::name('seller.')->prefix('/seller/')->group(function () {
    Route::get('dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
    Route::get('profile', [SellerController::class, 'profile'])->name('profile');
    Route::get('requests', [SellerController::class, 'requests'])->name('requests');

});
Route::name('profile.')->prefix('/profile/')->group(function () {
    Route::get('index', [ProfileController::class, 'index'])->name('index');
});
Route::post('ckeditor/image_upload', [CKEditorController::class, 'upload'])->name('upload');

