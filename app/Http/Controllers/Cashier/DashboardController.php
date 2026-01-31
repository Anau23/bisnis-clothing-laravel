<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('cashier.activity');
    }

    public function inventory()
    {
        return view('cashier.inventory');
    }

    public function payment()
    {
        return view('cashier.payment');
    }

    public function products()
    {
        return view('cashier.position1');
    }
}
