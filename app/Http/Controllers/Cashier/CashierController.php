<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CashierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        // Flask: cashier/activity.html
        return view('cashier.activity', [
            'user' => Auth::user()
        ]);
    }

    public function inventory()
    {
        // Flask: cashier/inventory.html
        return view('cashier.inventory');
    }

    public function payment()
    {
        // Flask: cashier/payment.html
        return view('cashier.payment');
    }

    public function products()
    {
        // Flask: cashier/position1.html
        return view('cashier.position1');
    }
}
