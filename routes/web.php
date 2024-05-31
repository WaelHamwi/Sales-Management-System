<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;

Route::domain('semiramis.dv')->group(function () {

  Route::middleware(['auth'])->group(function () {
    Route::get('/trigger-500', function () {
      abort(500);
  });
    //*******************routes for the dashboard starts*********************//
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    //*******************routes for the dashboard ends*********************//

    //*******************routes for the profile starts*********************//
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/validate-password', [ProfileController::class, 'validatePassword'])->name('profile.validate-password');
    Route::post('/profile_upload_image', [ProfileController::class, 'profile_upload_image'])->name('profile.upload');
    //*******************routes for the profile endss*********************//

    //*******************routes for the companies starts*********************//
    Route::get('companies', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('companies/create', [CompanyController::class, 'create'])->name('companies.create');
    Route::post('companies/store', [CompanyController::class, 'store'])->name('companies.store');
    Route::get('/companies/json', [CompanyController::class, 'getAllCompanies'])->name('companies.json');
    Route::get('companies/{id}', [CompanyController::class, 'show'])->name('companies.show');
    Route::get('companies/{id}/edit', [CompanyController::class, 'edit'])->name('companies.edit');
    Route::put('companies/{id}/update', [CompanyController::class, 'update'])->name('companies.update');
    Route::delete('/companies/{id}', [CompanyController::class, 'destroy'])->name('companies.destroy');
    Route::post('/image_company', [CompanyController::class, 'company_upload_image'])->name('companies.upload');
    Route::post('/check-company-unique', [CompanyController::class, 'checkUnique'])->name('companies.unique');
    //*******************routes for the companies ends*********************//
    //*******************routes for the categories starts*********************//
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/json', [CategoryController::class, 'getAllCategories'])->name('categories.json');
    Route::get('categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{id}/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('/image_category', [CategoryController::class, 'category_upload_image'])->name('categories.upload');

    //*******************routes for the cotegories ends*********************//

    //*******************routes for the branches starts*********************//
    Route::get('branches', [BranchController::class, 'index'])->name('branches.index');
    Route::get('branches/create', [BranchController::class, 'create'])->name('branches.create');
    Route::post('branches/store', [BranchController::class, 'store'])->name('branches.store');
    Route::get('/branches/json', [BranchController::class, 'getAllBranches'])->name('branches.json');
    Route::get('branches/{id}', [BranchController::class, 'show'])->name('branches.show');
    Route::get('branches/{id}/edit', [BranchController::class, 'edit'])->name('branches.edit');
    Route::put('branches/{id}/update', [BranchController::class, 'update'])->name('branches.update');
    Route::delete('/branches/{id}', [BranchController::class, 'destroy'])->name('branches.destroy');
    Route::post('/image_branch', [BranchController::class, 'branch_upload_image'])->name('branches.upload');
    Route::post('/check-branch-unique', [BranchController::class, 'checkUnique'])->name('branches.unique');
    //*******************routes for the branches ends*********************//

    //*******************routes for the products starts*********************//
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/json', [ProductController::class, 'getAllProducts'])->name('products.json');
    Route::get('products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{id}/update', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/image_product', [ProductController::class, 'product_upload_image'])->name('products.upload');
    //*******************routes for the products ends*********************//

    //*******************routes for the stocks starts*********************//
    Route::get('stocks', [StockController::class, 'index'])->name('stocks.index');
    Route::get('stocks/create', [StockController::class, 'create'])->name('stocks.create');
    Route::post('stocks/store', [StockController::class, 'store'])->name('stocks.store');
    Route::get('/stocks/json', [StockController::class, 'getAllStocks'])->name('stocks.json');
    Route::get('stocks/{id}/edit', [StockController::class, 'edit'])->name('stocks.edit');
    Route::put('stocks/{id}/update', [StockController::class, 'update'])->name('stocks.update');
    Route::put('stocks/{id}/update/all', [StockController::class, 'updateAll'])->name('stocks.updateAll');
    Route::delete('/stocks/{id}', [StockController::class, 'destroy'])->name('stocks.destroy');
    Route::post('/stocks/check-products-exist', [StockController::class, 'checkProductsExist']);
    Route::get('/stocks/details', [StockController::class, 'getStockDetails']);
    Route::get('stocks/product/{id}', [StockController::class, 'showProduct'])->name('stocks.showProduct');
    Route::get('/get-products-for-a-company/{companyId}', [StockController::class, 'getCompanyProductsDetails']);
    Route::get('/get-products-for-a-branch/{branchId}', [StockController::class, 'getBranchProductsDetails']);
    Route::get('/get-all-companies-products', [StockController::class, 'getAllCompanyProductsDetails']);
    Route::get('/get-numOfProducts-for-a-company/{companyId}', [StockController::class, 'getNumOfProductsForCompany']);
    Route::get('/get-numOfProducts-for-all-companies', [StockController::class, 'getNumOfProductsForAllCompanies']);
    Route::get('/get-numOfProducts-for-a-branch/{branchId}', [StockController::class, 'getNumOfProductsForBranch']);
    Route::get('/get-count-of-company-products-daterange/{companyId}', [StockController::class, 'countOfCompanyProductsInDaterange'])->name('getCountOfProductsInDaterange');
    Route::get('/get-count-of-branch-products-daterange/{branchId}', [StockController::class, 'countOfBranchProductsInDaterange'])->name('getCountOfProductsInDaterange');
    Route::get('/ get-count-of-products-daterange-AllCompanies', [StockController::class, 'countOfAllCompaniesProductsInDaterange'])->name('getCountOfAllCompaniesProductsInDaterange');
    

    //*******************routes for the stocks ends*********************//

    //*******************routes for the Orders starts*********************//
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('orders/store', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/json', [OrderController::class, 'getAllOrders'])->name('orders.json');
    Route::get('/orderItems/json/{id}', [OrderController::class, 'showOrderDetails'])->name('orderItems.json');
    Route::get('order/show/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::get('orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('orders/{id}/update', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/get-branches', [OrderController::class, 'getAllBranches'])->name('get-allBranches');
    Route::get('/get-branches/{companyId}', [OrderController::class, 'getBranches'])->name('get-branches');
    Route::get('/get-products/{companyId}', [OrderController::class, 'getProducts'])->name('get-products');
    Route::get('/get-branch-products/{branchId}', [OrderController::class, 'getBranchProducts'])->name('get-branch-products');
    Route::get('/get-count-of-sales', [OrderController::class, 'countOfSuccessSales'])->name('getCountOfSales');
    Route::get('/get-count-of-branch-sales/{companyId}', [OrderController::class, 'countOfSuccessBranchSales'])->name('getCountOfBranchSales');
    Route::get('/get-count-of-company-sales-daterange/{companyId}', [OrderController::class, 'countOfSuccessSalesInDaterange'])->name('getCountOfSuccessSalesInDaterange');
    Route::get('/get-count-of-branch-sales-daterange/{branchId}', [OrderController::class, 'countOfSuccessSalesBranchInDaterange'])->name('getCountOfSuccessSalesBranchInDaterange');
    Route::get('/get-count-of-sales-daterange-AllCompanies', [OrderController::class, 'countOfSuccessSalesInDaterangeAllCompanies'])->name('getCountOfSuccessSalesInDaterangeAllCompanies');
    Route::get('/get-count-of-sales-for-a-branch/{branchId}', [OrderController::class, 'countOfSuccessSalesInBranch'])->name('getOfSuccessSalesInBranch');
    Route::get('/products-prices/{ids}', [OrderController::class, 'productsPrices'])->name('getProductsPrices');
    Route::post('/check-stock', [OrderController::class, 'checkStock'])->name('check.stock');

    //*******************routes for the Orders ends*********************//

    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
  });
});

require __DIR__ . '/auth.php';
