<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

// Models
use App\Models\Sale;
use App\Models\CashDrawer;
use App\Models\CashDrawerLog;
use App\Models\User;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        // =========================
        // Default date range (7 hari)
        // =========================
        $startDate = $request->start_date
            ? Carbon::parse($request->start_date)
            : Carbon::now()->subDays(6)->startOfDay();

        $endDate = $request->end_date
            ? Carbon::parse($request->end_date)->endOfDay()
            : Carbon::now()->endOfDay();

        // =========================
        // SALES STATS
        // =========================
        $totalSales = Sale::whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_amount');

        $totalTransactions = Sale::whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // =========================
        // CASH FLOW
        // =========================
        $cashIn = CashDrawerLog::where('transaction_type', 'cash_in')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('amount');

        $cashOut = CashDrawerLog::where('transaction_type', 'cash_out')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('amount');

        $netCash = $cashIn - abs($cashOut);

        // =========================
        // CASHIER PERFORMANCE
        // =========================
        $cashierStats = Sale::selectRaw('cashier_id,
                COUNT(*) as total_transactions,
                SUM(total_amount) as total_sales')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('cashier_id')
            ->with('cashier:id,username')
            ->orderByDesc('total_sales')
            ->get()
            ->map(function ($row) {
                return (object)[
                    'username' => optional($row->cashier)->username,
                    'total_transactions' => $row->total_transactions,
                    'total_sales' => $row->total_sales
                ];
            });

        // =========================
        // RECENT DRAWERS
        // =========================
        $recentDrawers = CashDrawer::with('cashier')
            ->orderByDesc('opened_at')
            ->limit(10)
            ->get();

        // =========================
        // CHART DATA (HARIAN)
        // =========================
        $chartLabels = [];
        $chartRevenue = [];
        $chartCashIn = [];
        $chartCashOut = [];

        $period = Carbon::parse($startDate);

        while ($period <= $endDate) {
            $chartLabels[] = $period->format('d M');

            $chartRevenue[] = Sale::whereDate('created_at', $period)->sum('total_amount');
            $chartCashIn[] = CashDrawerLog::where('transaction_type', 'cash_in')
                ->whereDate('created_at', $period)->sum('amount');

            $chartCashOut[] = abs(
                CashDrawerLog::where('transaction_type', 'cash_out')
                    ->whereDate('created_at', $period)->sum('amount')
            );

            $period->addDay();
        }

        return view('admin.analytics', [
            'start_date'          => $startDate->toDateString(),
            'end_date'            => $endDate->toDateString(),

            'total_sales'         => $totalSales,
            'total_transactions'  => $totalTransactions,
            'cash_in'             => $cashIn,
            'cash_out'            => $cashOut,
            'net_cash'            => $netCash,

            'cashier_stats'       => $cashierStats,
            'recent_drawers'      => $recentDrawers,

            'chart_labels'        => $chartLabels,
            'chart_revenue_data'  => $chartRevenue,
            'chart_cash_in'       => $chartCashIn,
            'chart_cash_out'      => $chartCashOut,
        ]);
    }
}
