<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardApiController extends Controller
{
    public function filter(Request $request)
    {
        $period = $request->get('period', 'week');

        // =============================
        // DATE RANGE
        // =============================
        $start = Carbon::now();
        $end = Carbon::now();

        switch ($period) {
            case 'today':
                $start = Carbon::today();
                break;

            case 'week':
                $start = Carbon::now()->subDays(6);
                break;

            case 'month':
                $start = Carbon::now()->startOfMonth();
                break;

            case 'year':
                $start = Carbon::now()->startOfYear();
                break;

            case 'custom':
                $start = Carbon::parse($request->start_date);
                $end   = Carbon::parse($request->end_date)->endOfDay();
                break;
        }

        // =============================
        // STATS
        // =============================

        $revenue = DB::table('transactions')
            ->whereBetween('created_at', [$start, $end])
            ->where('status', 'completed')
            ->sum('total_amount');

        $purchaseCost = DB::table('purchase_orders')
            ->whereBetween('created_at', [$start, $end])
            ->sum('total_cost');

        $transactions = DB::table('transactions')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $profit = $revenue - $purchaseCost;

        // =============================
        // CHART DATA (GROUP BY DATE)
        // =============================

        $chartData = DB::table('transactions')
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
            ->whereBetween('created_at', [$start, $end])
            ->where('status', 'completed')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $revenueData = [];
        $profitData = [];

        foreach ($chartData as $row) {
            $labels[] = Carbon::parse($row->date)->format('d M');
            $revenueData[] = (float) $row->revenue;
            $profitData[] = (float) $row->revenue; // sementara (bisa dikurangi cost harian)
        }

        // =============================
        // TABLES
        // =============================

        // Recent Transactions
        $recentTransactions = DB::table('transactions')
            ->whereBetween('created_at', [$start, $end])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // Top Products
        $topProducts = DB::table('transaction_items')
            ->join('products', 'products.id', '=', 'transaction_items.product_id')
            ->selectRaw('
                products.name,
                products.sku,
                products.category,
                SUM(transaction_items.qty) as total_sold,
                SUM(transaction_items.subtotal) as total_revenue
            ')
            ->groupBy('products.id', 'products.name', 'products.sku', 'products.category')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Low Stock
        $lowStock = DB::table('products')
            ->whereColumn('stock', '<=', 'low_stock_alert')
            ->get();

        // =============================
        // RESPONSE (WAJIB SESUAI JS)
        // =============================

        return response()->json([
            'success' => true,

            'stats' => [
                'revenue' => (float) $revenue,
                'purchase_cost' => (float) $purchaseCost,
                'profit' => (float) $profit,
                'transactions' => (int) $transactions,
            ],

            'charts' => [
                'labels' => $labels,
                'revenue' => $revenueData,
                'profit' => $profitData,
                'purchase_cost' => [], // bisa ditambah nanti
            ],

            'tables' => [
                'recent_transactions' => $recentTransactions,
                'top_products' => $topProducts,
                'low_stock' => $lowStock,
            ],
        ]);
    }
}
