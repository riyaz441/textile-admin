<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApplicationSettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailConfigController;
use App\Http\Controllers\InventoryStockController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WebsettingController;

use App\Http\Controllers\Master\ProductCategoryMasterController;
use App\Http\Controllers\Master\CompanyMasterController;
use App\Http\Controllers\Master\BranchMasterController;
use App\Http\Controllers\Master\LocationMasterController;
use App\Http\Controllers\Master\GemstoneMasterController;
use App\Http\Controllers\Master\SupplierMasterController;
use App\Http\Controllers\Master\LaborMasterController;
use App\Http\Controllers\Master\MeasurementMasterController;
use App\Http\Controllers\Master\MaterialMasterController;
use App\Http\Controllers\Master\ProductComponentTypeMasterController;


/* ---------------- Login Routes ---------------- */

Route::view('/', 'landing_page');
Route::view('/login', 'auth_login')->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::match(['get', 'post'], 'logout', [AuthController::class, 'logout']);


/* ---------------- Protected Routes ---------------- */

Route::middleware(['auth', 'auth.session'])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::match(['get', 'post'], 'profile', [DashboardController::class, 'profile'])->name('profile');


    /* Product Categories */
    Route::get('product-categories', [ProductCategoryMasterController::class, 'index'])->name('product-categories.index');
    Route::get('product-categories/form/{id?}', [ProductCategoryMasterController::class, 'form'])->name('product-categories.form');
    Route::post('product-categories/save/{id?}', [ProductCategoryMasterController::class, 'save'])->name('product-categories.save');
    Route::get('product-categories/{id}', [ProductCategoryMasterController::class, 'show'])->name('product-categories.show');
    Route::post('product-categories/delete/{id}', [ProductCategoryMasterController::class, 'destroy'])->name('product-categories.destroy');
    Route::match(['get', 'post'], 'change_category_status', [ProductCategoryMasterController::class, 'changeStatus']);


    /* Component Types */
    Route::get('component-types', [ProductComponentTypeMasterController::class, 'index'])->name('component-types.index');
    Route::get('component-types/form/{id?}', [ProductComponentTypeMasterController::class, 'form'])->name('component-types.form');
    Route::post('component-types/save/{id?}', [ProductComponentTypeMasterController::class, 'save'])->name('component-types.save');
    Route::get('component-types/{id}', [ProductComponentTypeMasterController::class, 'show'])->name('component-types.show');
    Route::post('component-types/delete/{id}', [ProductComponentTypeMasterController::class, 'destroy'])->name('component-types.destroy');
    Route::match(['get', 'post'], 'change_component_type_status', [ProductComponentTypeMasterController::class, 'changeStatus']);


    /* Materials */
    Route::get('materials', [MaterialMasterController::class, 'index'])->name('materials.index');
    Route::get('materials/form/{id?}', [MaterialMasterController::class, 'form'])->name('materials.form');
    Route::post('materials/save/{id?}', [MaterialMasterController::class, 'save'])->name('materials.save');
    Route::get('materials/{id}', [MaterialMasterController::class, 'show'])->name('materials.show');
    Route::post('materials/delete/{id}', [MaterialMasterController::class, 'destroy'])->name('materials.destroy');
    Route::match(['get', 'post'], 'change_material_status', [MaterialMasterController::class, 'changeStatus']);


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


    /* Locations */
    Route::get('locations', [LocationMasterController::class, 'index'])->name('locations.index');
    Route::get('locations/form/{id?}', [LocationMasterController::class, 'form'])->name('locations.form');
    Route::post('locations/save/{id?}', [LocationMasterController::class, 'save'])->name('locations.save');
    Route::get('locations/{id}', [LocationMasterController::class, 'show'])->name('locations.show');
    Route::post('locations/delete/{id}', [LocationMasterController::class, 'destroy'])->name('locations.destroy');
    Route::match(['get', 'post'], 'change_location_status', [LocationMasterController::class, 'changeStatus']);


    /* Gemstones */
    Route::get('gemstones', [GemstoneMasterController::class, 'index'])->name('gemstones.index');
    Route::get('gemstones/form/{id?}', [GemstoneMasterController::class, 'form'])->name('gemstones.form');
    Route::post('gemstones/save/{id?}', [GemstoneMasterController::class, 'save'])->name('gemstones.save');
    Route::get('gemstones/{id}', [GemstoneMasterController::class, 'show'])->name('gemstones.show');
    Route::post('gemstones/delete/{id}', [GemstoneMasterController::class, 'delete'])->name('gemstones.delete');
    Route::match(['get', 'post'], 'change_gemstone_status', [GemstoneMasterController::class, 'changeStatus']);


    /* Suppliers */
    Route::get('suppliers', [SupplierMasterController::class, 'index'])->name('suppliers.index');
    Route::get('suppliers/form/{id?}', [SupplierMasterController::class, 'form'])->name('suppliers.form');
    Route::post('suppliers/save/{id?}', [SupplierMasterController::class, 'save'])->name('suppliers.save');
    Route::get('suppliers/{id}', [SupplierMasterController::class, 'show'])->name('suppliers.show');
    Route::post('suppliers/delete/{id}', [SupplierMasterController::class, 'destroy'])->name('suppliers.delete');
    Route::match(['get', 'post'], 'change_supplier_status', [SupplierMasterController::class, 'changeStatus']);


    /* Measurements */
    Route::get('measurements', [MeasurementMasterController::class, 'index'])->name('measurements.index');
    Route::get('measurements/form/{id?}', [MeasurementMasterController::class, 'form'])->name('measurements.form');
    Route::post('measurements/save/{id?}', [MeasurementMasterController::class, 'save'])->name('measurements.save');
    Route::get('measurements/{id}', [MeasurementMasterController::class, 'show'])->name('measurements.show');
    Route::post('measurements/delete/{id}', [MeasurementMasterController::class, 'delete'])->name('measurements.delete');
    Route::match(['get', 'post'], 'change_measurement_status', [MeasurementMasterController::class, 'changeStatus']);


    /* Products */
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/form/{id?}', [ProductController::class, 'form'])->name('products.form');
    Route::post('products/save/{id?}', [ProductController::class, 'save'])->name('products.save');
    Route::get('products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::post('products/delete/{id}', [ProductController::class, 'destroy'])->name('products.delete');
    Route::match(['get', 'post'], 'change_product_status', [ProductController::class, 'changeStatus']);


    /* Labors */
    Route::get('labors', [LaborMasterController::class, 'index'])->name('labors.index');
    Route::get('labors/form/{id?}', [LaborMasterController::class, 'form'])->name('labors.form');
    Route::post('labors/save/{id?}', [LaborMasterController::class, 'save'])->name('labors.save');
    Route::get('labors/{id}', [LaborMasterController::class, 'show'])->name('labors.show');
    Route::post('labors/delete/{id}', [LaborMasterController::class, 'destroy'])->name('labors.delete');
    Route::match(['get', 'post'], 'change_labor_status', [LaborMasterController::class, 'changeStatus']);


    /* Inventory Stocks */
    Route::get('inventory-stocks', [InventoryStockController::class, 'index'])->name('inventory-stocks.index');
    Route::get('inventory-stocks/form/{id?}', [InventoryStockController::class, 'form'])->name('inventory-stocks.form');
    Route::post('inventory-stocks/save/{id?}', [InventoryStockController::class, 'save'])->name('inventory-stocks.save');
    Route::get('inventory-stocks/{id}', [InventoryStockController::class, 'show'])->name('inventory-stocks.show');
    Route::post('inventory-stocks/delete/{id}', [InventoryStockController::class, 'destroy'])->name('inventory-stocks.delete');
    Route::match(['get', 'post'], 'change_inventory_stock_status', [InventoryStockController::class, 'changeStatus']);


    /* Settings */
    Route::match(['get', 'post'], 'email_configuration', [EmailConfigController::class, 'email_config']);
    Route::match(['get', 'post'], 'payment_gateway_setting', [PaymentController::class, 'pay']);
    Route::match(['get', 'post'], 'web_setting', [WebsettingController::class, 'setting']);
    Route::match(['get', 'post'], 'admin_setting', [WebsettingController::class, 'admin']);


    /* Application Settings */
    Route::get('application-settings', [ApplicationSettingController::class, 'index'])->name('application-settings.index');
    Route::get('application-settings/form/{id?}', [ApplicationSettingController::class, 'form'])->name('application-settings.form');
    Route::post('application-settings/save/{id?}', [ApplicationSettingController::class, 'save'])->name('application-settings.save');
    Route::get('application-settings/{id}', [ApplicationSettingController::class, 'show'])->name('application-settings.show');
    Route::post('application-settings/delete/{id}', [ApplicationSettingController::class, 'destroy'])->name('application-settings.delete');

});
