<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cashier\DashboardController;
use App\Http\Controllers\Cashier\ShiftController;
use App\Http\Controllers\Cashier\PosController;
use App\Http\Controllers\Cashier\ApiController;

Route::middleware(['auth','role:cashier'])
    ->prefix('cashier')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index']);
        Route::get('/pos', [PosController::class, 'index']);

        Route::get('/shift', [ShiftController::class, 'index']);
        Route::post('/shift/open', [ShiftController::class, 'open']);
        Route::post('/shift/close', [ShiftController::class, 'close']);

        /* ===== API ===== */
        Route::get('/api/products', [ApiController::class, 'products']);
        Route::get('/api/products/{id}/variants', [ApiController::class, 'variants']);
        Route::get('/api/products/{id}/stock', [ApiController::class, 'stock']);
        Route::get('/api/scan-barcode', [ApiController::class, 'scanBarcode']);
    });
