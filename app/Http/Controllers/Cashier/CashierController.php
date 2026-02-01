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
        return view('cashier.dashboard', [
            'user' => Auth::user(),
            'cash_drawer' => $cashDrawer ?? null,
            'total_sales' => $totalSales ?? 0,
            'total_transactions' => $totalTransactions ?? 0,
            'total_items' => $totalItems ?? 0,
            'recent_transactions' => $recentTransactions ?? collect(),
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

    public function activity()
    {
        return view('cashier.activity', [
            'user' => Auth::user(),
        ]);
    }

}
