<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailConfigController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WebsettingController;
use App\Http\Controllers\Master\CompanyMasterController;
use App\Http\Controllers\Master\BranchMasterController;
use App\Http\Controllers\Master\ProductController;



/* ---------------- Login Routes ---------------- */

Route::view('/', 'website/index')->name('index');
Route::view('/about', 'website/about')->name('about');
Route::view('/single_product', 'website/single-product')->name('single-product');
Route::view('/contact', 'website/contact')->name('contact');
Route::view('/products', 'website/products')->name('products');

Route::view('/login', 'auth_login')->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::match(['get', 'post'], 'logout', [AuthController::class, 'logout']);


/* ---------------- Protected Routes ---------------- */

Route::middleware(['auth', 'auth.session'])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::match(['get', 'post'], 'profile', [DashboardController::class, 'profile'])->name('profile');


    /* Companies */
    Route::get('companies', [CompanyMasterController::class, 'index'])->name('companies.index');
    Route::get('companies/form/{id?}', [CompanyMasterController::class, 'form'])->name('companies.form');
    Route::post('companies/save/{id?}', [CompanyMasterController::class, 'save'])->name('companies.save');
    Route::get('companies/{id}', [CompanyMasterController::class, 'show'])->name('companies.show');
    Route::post('companies/delete/{id}', [CompanyMasterController::class, 'destroy'])->name('companies.destroy');
    Route::match(['get', 'post'], 'change_company_status', [CompanyMasterController::class, 'changeStatus']);
    Route::post('set-company', [CompanyMasterController::class, 'setCompany'])->name('companies.set');


    /* Branches */
    Route::get('branches', [BranchMasterController::class, 'index'])->name('branches.index');
    Route::get('branches/form/{id?}', [BranchMasterController::class, 'form'])->name('branches.form');
    Route::post('branches/save/{id?}', [BranchMasterController::class, 'save'])->name('branches.save');
    Route::get('branches/{id}', [BranchMasterController::class, 'show'])->name('branches.show');
    Route::post('branches/delete/{id}', [BranchMasterController::class, 'destroy'])->name('branches.destroy');
    Route::match(['get', 'post'], 'change_branch_status', [BranchMasterController::class, 'changeStatus']);
    Route::match(['get', 'post'], 'get_branch_by_company', [BranchMasterController::class, 'getByCompany']);


    /* Products */
    Route::get('admin/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('admin/products/form/{id?}', [ProductController::class, 'form'])->name('products.form');
    Route::post('admin/products/save/{id?}', [ProductController::class, 'save'])->name('products.save');
    Route::get('admin/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::post('admin/products/delete/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::match(['get', 'post'], 'change_product_status', [ProductController::class, 'changeStatus']);


    /* Settings */
    Route::match(['get', 'post'], 'email_configuration', [EmailConfigController::class, 'email_config']);
    Route::match(['get', 'post'], 'payment_gateway_setting', [PaymentController::class, 'pay']);
    Route::match(['get', 'post'], 'web_setting', [WebsettingController::class, 'setting']);
    Route::match(['get', 'post'], 'admin_setting', [WebsettingController::class, 'admin']);
});
