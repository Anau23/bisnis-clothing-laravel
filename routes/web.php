<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Cashier\CashierController;
use App\Http\Controllers\Admin\CashDrawerController;

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// //Route::get('/logout', function () {
//     Auth::logout();
//     request()->session()->invalidate();
//     request()->session()->regenerateToken();

//     return redirect('/login');
// });
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');



/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
| Role: admin
| Middleware: auth + admin
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/items', [AdminController::class, 'items'])
            ->name('items');

        Route::get('/categories', [AdminController::class, 'categories'])
            ->name('categories');

        Route::get('/inventory/purchase', [AdminController::class, 'purchase'])
        ->name('inventory.purchase.index');

        Route::get('/inventory/summary', [AdminController::class, 'summary'])
            ->name('inventory.summary');

        // sementara dummy
        Route::get('/inventory/supplier', fn () => view('admin.inventory.supplier.index'))
            ->name('inventory.supplier');

        Route::get('/cashdrawer', [CashDrawerController::class, 'index'])
        ->name('cashdrawer');

        Route::get('/users', fn () => view('admin.users.index'))
            ->name('users');
    });



/*
|--------------------------------------------------------------------------
| CASHIER ROUTES
|--------------------------------------------------------------------------
| Role: cashier
| Middleware: auth
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
        Route::get('/cashier/activity', [CashierController::class, 'cashier.dashboard'])
            ->name('cashier.activity');

    });
