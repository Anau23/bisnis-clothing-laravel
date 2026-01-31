<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function items()
    {
        return view('admin.items');
    }

    public function categories()
    {
        return view('admin.categories');
    }

    public function purchase()
    {
        return view('admin.purchase');
    }

    public function report()
    {
        return view('admin.report');
    }

    public function summary()
    {
        return view('admin.summary');
    }
}
