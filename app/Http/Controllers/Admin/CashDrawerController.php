<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use App\Models\CashDrawer;
use App\Models\CashDrawerLog;


class CashDrawerController extends Controller
{
    public function index(Request $request)
    {
        $perPage        = $request->get('per_page', 10);
        $salesPerPage   = $request->get('sales_per_page', 10);
        $historyPerPage = $request->get('history_per_page', 5);

        $todayStart = Carbon::today('Asia/Jakarta');
        $todayEnd   = Carbon::tomorrow('Asia/Jakarta');

        // =============================
        // Active drawer
        // =============================
        $currentDrawer = CashDrawer::where('status', 'open')
            ->orderBy('opened_at', 'desc')
            ->first();

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

        // =============================
        // ✅ TOTAL SUBTOTAL (BENAR)
        // =============================
        $totalSubtotalToday = DB::table('transaction_items as ti')
            ->join('transactions as t', 't.id', '=', 'ti.transaction_id')
            ->whereBetween('t.created_at', [$todayStart, $todayEnd])
            ->sum('ti.subtotal');

        // =============================
        // ✅ TOTAL ITEMS (BENAR)
        // =============================
        $totalItemsToday = DB::table('transaction_items as ti')
            ->join('transactions as t', 't.id', '=', 'ti.transaction_id')
            ->whereBetween('t.created_at', [$todayStart, $todayEnd])
            ->sum('ti.quantity');

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
        // Expected cash (AMAN)
        // =============================
        $expected_cash = $currentDrawer
            ? $currentDrawer->opening_balance + $totalCashFlow
            : 0;

        $soldItems = collect();

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
