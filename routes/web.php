<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ACCOUNT SETTING
use App\Livewire\AccountSetting\Account;
use App\Livewire\AccountSetting\ChangePassword;

// DASHBOARD
use App\Livewire\Dashboard\Dashboard;

// CUSTOMER
use App\Livewire\Customer\CreateCustomer;
use App\Livewire\Customer\EditCustomer;
use App\Livewire\Customer\IndexCustomer;

// DIVISI
use App\Livewire\Divisi\CreateDivisi;
use App\Livewire\Divisi\EditDivisi;
use App\Livewire\Divisi\IndexDivisi;

// ESTIMATE
use App\Livewire\Estimate\CreateEstimate;
use App\Livewire\Estimate\EditEstimate;
use App\Livewire\Estimate\IndexEstimate;
use App\Livewire\Estimate\DetailEstimate;

// ITEM
use App\Livewire\Item\CreateItem;
use App\Livewire\Item\EditItem;
use App\Livewire\Item\IndexItem;

// OTENTIKASI
use App\Livewire\Otentikasi\Login;
use App\Livewire\Otentikasi\AccessDenied;
use App\Livewire\Otentikasi\Logout;

// ROLE
use App\Livewire\Role\CreateRole;
use App\Livewire\Role\EditRole;
use App\Livewire\Role\IndexRole;

// SALES
use App\Livewire\Sales\CreateSales;
use App\Livewire\Sales\EditSales;
use App\Livewire\Sales\IndexSales;

// UNIT
use App\Livewire\Unit\CreateUnit;
use App\Livewire\Unit\EditUnit;
use App\Livewire\Unit\IndexUnit;

// USER
use App\Livewire\User\CreateUser;
use App\Livewire\User\EditUser;
use App\Livewire\User\IndexUser;

use App\Http\Controllers\EstimateController;


Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    } else {
        return redirect('/login');
    }
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', Login::class)->name('login');
});

Route::middleware(['web', 'auth'])->group(function () {
    // ROUTE DASHBOARD
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // ROUTE ACCOUNT SETTING
    Route::get('/account-setting/account', Account::class)->name('account');
    Route::get('/account-setting/change-password', ChangePassword::class)->name('change-password');

    // ROUTE CUSTOOMER
    Route::get('/customer/create-customer', CreateCustomer::class)->name('create.customer');
    Route::get('/customer/{id}/edit-customer', EditCustomer::class)->name('edit.customer');
    Route::get('/customer/list-customer', IndexCustomer::class)->name('index.customer');

    // ROUTE DIVISI
    Route::get('/divisi/create-divisi', CreateDivisi::class)->name('create.divisi');
    Route::get('/divisi/{id}/edit-divisi', EditDivisi::class)->name('edit.divisi');
    Route::get('/divisi/list-divisi', IndexDivisi::class)->name('index.divisi');

    // ROUTE ESTIMATE
    Route::get('/estimate/create-estimate', CreateEstimate::class)->name('create.estimate');
    Route::get('/estimate/{id}/edit-estimate', EditEstimate::class)->name('edit.estimate');
    Route::get('/estimate/list-estimate', IndexEstimate::class)->name('index.estimate');
    Route::get('/estimate/{estimateId}/detail', DetailEstimate::class)->name('detail.estimate');
    Route::post('/ckeditor/upload/create-estimate', [CreateEstimate::class, 'uploadImageCKEditorCreateEstimate'])->name('ckeditor.upload.create.estimate');
    Route::post('/ckeditor/upload/edit-estimate', [EditEstimate::class, 'uploadImageCKEditorEditEstimate'])->name('ckeditor.upload.edit.estimate');

    Route::get('/estimate/{id}/print', [EstimateController::class, 'printPDF'])->name('print.estimate');

    // ROUTE ITEM
    Route::get('/item/create-item', CreateItem::class)->name('create.item');
    Route::get('/item/{id}/edit-item', EditItem::class)->name('edit.item');
    Route::get('/item/list-item', IndexItem::class)->name('index.item');
    Route::post('/ckeditor/upload/create-item', [CreateItem::class, 'uploadImageCKEditorCreateItem'])->name('ckeditor.upload.create.item');
    Route::post('/ckeditor/upload/edit-item', [EditItem::class, 'uploadImageCKEditorEditItem'])->name('ckeditor.upload.edit.item');

    // ROUTE ROLE
    Route::get('/role/create-role', CreateRole::class)->name('create.role');
    Route::get('/role/{id}/edit-role', EditRole::class)->name('edit.role');
    Route::get('/role/list-role', IndexRole::class)->name('index.role');

    // ROUTE ROLE
    Route::get('/unit/create-unit', CreateUnit::class)->name('create.unit');
    Route::get('/unit/{id}/edit-unit', EditUnit::class)->name('edit.unit');
    Route::get('/unit/list-unit', IndexUnit::class)->name('index.unit');

    // ROUTE SALES
    Route::get('/sales/create-sales', CreateSales::class)->name('create.sales');
    Route::get('/sales/{id}/edit-sales', EditSales::class)->name('edit.sales');
    Route::get('/sales/list-sales', IndexSales::class)->name('index.sales');

    // ROUTE USER
    Route::get('/user/create-user', CreateUser::class)->name('create.user');
    Route::get('/user/{id}/edit-user', EditUser::class)->name('edit.user');
    Route::get('/user/list-user', IndexUser::class)->name('index.user');

    // REPORT TRANSACTION
    // Route::get('report', Reportindex::class)->name('report');
    // Route::get('report/generateReport/{start_date}/{end_date}/{type_transaction}', [ApiController::class, 'generateReport'])->name('report.generatereport');

    // ROUTE ACCESS DENIED
    Route::get('/access-denied', AccessDenied::class)->name('access-denied');

    // ROUTE LOGOUT
    Route::get('/logout', [Logout::class, 'logout'])->name('logout');
});
