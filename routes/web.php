<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CashDrawerController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Cashier\CashierController;

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
| Middleware: auth + admin
| URL: /admin/...
| Route name: admin.*
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        //Route::get('/dashboard/filter', [DashboardController::class, 'filter'])
        //    ->name('dashboard.filter');
        Route::get('/dashboard/filter', [DashboardController::class, 'filter']);

        // Items & Categories
        Route::get('/items', [AdminController::class, 'items'])
            ->name('items');

        Route::get('/categories', [AdminController::class, 'categories'])
            ->name('categories');

        // Inventory
        Route::get('/inventory/purchase', [AdminController::class, 'purchase'])
            ->name('inventory.purchase.index');


        Route::get('/inventory/summary', [AdminController::class, 'summary'])
            ->name('inventory.summary');

        Route::get('/inventory/supplier', [SupplierController::class, 'index'])
            ->name('inventory.supplier.index');

        Route::get('/inventory/supplier/create', [SupplierController::class, 'create'])
            ->name('inventory.supplier.create');

        // Reports
        Route::get('/reports/export-excel', function () {
            return response('Export Excel belum diimplementasikan', 200);
        })->name('reports.export');

        // Cash Drawer
        Route::get('/cashdrawer', [CashDrawerController::class, 'index'])
            ->name('cashdrawer');

        // Users
        Route::get('/users', [UserController::class, 'index'])
            ->name('users');

        Route::post('/users', [UserController::class, 'store'])
            ->name('users.store');
    });


/*
|--------------------------------------------------------------------------
| CASHIER ROUTES
|--------------------------------------------------------------------------
| Middleware: auth
| URL: /cashier/...
| Route name: cashier.*
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])
    ->prefix('cashier')
    ->name('cashier.')
    ->group(function () {

        Route::get('/dashboard', [CashierController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/inventory', [CashierController::class, 'inventory'])
            ->name('inventory');

        Route::get('/payment', [CashierController::class, 'payment'])
            ->name('payment');

        Route::get('/products', [CashierController::class, 'products'])
            ->name('products');

        Route::get('/activity', [CashierController::class, 'activity'])
            ->name('activity');
    });
