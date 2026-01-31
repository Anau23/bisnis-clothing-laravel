<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardApiController;

Route::get('/admin/dashboard/filter', [DashboardApiController::class, 'filter']);
