<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use App\Models\CashDrawer;
use App\Models\CashDrawerLog;


class CashDrawerController extends Controller
{
    public function index(Request $request)
    {
        // =============================
        // Pagination
        // =============================
        $perPage        = $request->get('per_page', 10);
        $salesPerPage   = $request->get('sales_per_page', 10);
        $historyPerPage = $request->get('history_per_page', 5);

        // =============================
        // Today (WIB)
        // =============================
        $todayStart = Carbon::today('Asia/Jakarta');
        $todayEnd   = Carbon::tomorrow('Asia/Jakarta');

        // =============================
        // Active drawer
        // =============================
        $currentDrawer = CashDrawer::where('status', 'open')->latest()->first();

        // =============================
        // Cash logs today
        // =============================
        $todayLogs = CashDrawerLog::with(['user', 'cashDrawer'])
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->orderByDesc('created_at')
            ->paginate($perPage);

        $totalCashFlow = CashDrawerLog::whereBetween('created_at', [$todayStart, $todayEnd])
            ->sum('amount');

        // =============================
        // Sales today
        // =============================
        $todaySales = Transaction::with('user')
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->orderByDesc('created_at')
            ->paginate($salesPerPage, ['*'], 'sales_page');


        $totalSalesToday = Transaction::whereBetween('created_at', [$todayStart, $todayEnd])
            ->sum('total_amount');

        $totalSubtotalToday = Transaction::whereBetween('created_at', [$todayStart, $todayEnd])
            ->sum('subtotal');

        $totalItemsToday = Transaction::whereBetween('created_at', [$todayStart, $todayEnd])
            ->sum('total_items');


        // =============================
        // Drawer history
        // =============================
        $drawerHistory = CashDrawer::with('cashier')
            ->orderByDesc('opened_at')
            ->paginate($historyPerPage, ['*'], 'history_page');

        // =============================
        // Cashiers
        // =============================
        $cashiers = User::where('role', 'cashier')->get();

        // =============================
        // SAFE DEFAULTS (ANTI ERROR)
        // =============================
        $expected_cash = $currentDrawer
            ? $currentDrawer->opening_balance + $totalCashFlow
            : 0;

        $soldItems = collect(); // sementara

        return view('admin.cashdrawer.index', compact(
            'currentDrawer',
            'todayLogs',
            'totalCashFlow',
            'todaySales',
            'totalSalesToday',
            'totalSubtotalToday',
            'totalItemsToday',
            'drawerHistory',
            'cashiers',
            'expected_cash',
            'soldItems'
        ));
    }
}
