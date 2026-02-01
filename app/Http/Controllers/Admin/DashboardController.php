<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\PurchaseOrder;
use App\Models\Product;
use App\Models\Category;


class DashboardController extends Controller
{
    /**
     * Admin Dashboard (Flask-style server rendered)
     */
    
    public function index()
    {
        return view('admin.dashboard');
    }

    public function filter(Request $request)
    {
        // =====================================================
        // TIMEZONE TIMOR-LESTE
        // =====================================================
        $nowTl = Carbon::now('Asia/Dili');

        $period = $request->get('period', 'week');
        $startDateStr = $request->get('start_date');
        $endDateStr   = $request->get('end_date');

        // =====================================================
        // TENTUKAN RANGE TANGGAL (SAMA DENGAN FLASK)
        // =====================================================
        switch ($period) {
            case 'today':
                $startTl = $nowTl->copy()->startOfDay();
                $endTl   = $nowTl->copy()->endOfDay();
                break;

            case 'month':
                $startTl = $nowTl->copy()->subDays(29)->startOfDay();
                $endTl   = $nowTl->copy()->endOfDay();
                break;

            case 'year':
                $startTl = Carbon::create($nowTl->year, 1, 1, 0, 0, 0, 'Asia/Dili');
                $endTl   = $nowTl->copy()->endOfDay();
                break;

            case 'custom':
                if ($startDateStr && $endDateStr) {
                    $startTl = Carbon::parse($startDateStr, 'Asia/Dili')->startOfDay();
                    $endTl   = Carbon::parse($endDateStr, 'Asia/Dili')->endOfDay();
                    break;
                }

            default: // week
                $startTl = $nowTl->copy()->subDays(6)->startOfDay();
                $endTl   = $nowTl->copy()->endOfDay();
        }

        // Convert ke UTC untuk query DB (PENTING)
        $startUtc = $startTl->copy()->setTimezone('UTC');
        $endUtc   = $endTl->copy()->setTimezone('UTC');

        // =====================================================
        // 1. STATS (REVENUE, TRANSACTIONS, PURCHASE COST, PROFIT)
        // =====================================================
        $totalRevenue = Transaction::whereBetween('created_at', [$startUtc, $endUtc])
            ->where('status', 'completed')
            ->sum('total_amount');

        $transactionsCount = Transaction::whereBetween('created_at', [$startUtc, $endUtc])
            ->where('status', 'completed')
            ->count();

        $totalPurchaseCost = PurchaseOrder::whereBetween('created_at', [$startUtc, $endUtc])
            ->whereIn('status', ['approved', 'fulfilled'])
            ->sum('total_amount');

        $totalProfit = $totalRevenue - $totalPurchaseCost;

        // =====================================================
        // 2. CHART DATA (7 HARI TERAKHIR – TIMOR-LESTE)
        // =====================================================
        $chartLabels = [];
        $chartRevenue = [];
        $chartPurchaseCost = [];
        $chartProfit = [];

        for ($i = 0; $i < 7; $i++) {
            $dayTl = $nowTl->copy()->subDays(6 - $i);

            $chartLabels[] = $dayTl->format('l') . "\n" . $dayTl->format('d/m');

            $dayStartUtc = $dayTl->copy()->startOfDay()->setTimezone('UTC');
            $dayEndUtc   = $dayTl->copy()->endOfDay()->setTimezone('UTC');

            $dayRevenue = Transaction::whereBetween('created_at', [$dayStartUtc, $dayEndUtc])
                ->where('status', 'completed')
                ->sum('total_amount');

            $dayCost = PurchaseOrder::whereBetween('created_at', [$dayStartUtc, $dayEndUtc])
                ->whereIn('status', ['approved', 'fulfilled'])
                ->sum('total_amount');

            $chartRevenue[] = (float) $dayRevenue;
            $chartPurchaseCost[] = (float) $dayCost;
            $chartProfit[] = (float) ($dayRevenue - $dayCost);
        }

        // =====================================================
        // 3. TOP PRODUCTS (MIRIP FLASK, GROUP BY TRANSACTION ITEM)
        // =====================================================
        $topProducts = [];

        $topProductsQuery = DB::table('transaction_items')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.name',
                DB::raw("COALESCE(categories.name, 'Umum') as category"),
                DB::raw('SUM(transaction_items.quantity) as total_sold'),
                DB::raw('SUM(transaction_items.subtotal) as total_revenue'),
                'products.stock'
            )
            ->where('transactions.status', 'completed')
            ->whereBetween('transactions.created_at', [$startUtc, $endUtc])
            ->groupBy('products.id', 'products.name', 'categories.name', 'products.stock')
            ->havingRaw('SUM(transaction_items.quantity) > 0')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        foreach ($topProductsQuery as $p) {
            $topProducts[] = [
                'name' => $p->name,
                'sku' => '-', // sama seperti fallback Flask
                'category' => $p->category,
                'total_sold' => (int) $p->total_sold,
                'total_revenue' => (float) $p->total_revenue,
                'stock' => (int) ($p->stock ?? 0),
            ];
        }

        // =====================================================
        // 4. RECENT TRANSACTIONS (5 TERAKHIR)
        // =====================================================
        $recentTransactions = [];

        $recentTxQuery = Transaction::whereBetween('created_at', [$startUtc, $endUtc])
            ->where('status', 'completed')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        foreach ($recentTxQuery as $tx) {
            $txTimeTl = Carbon::parse($tx->created_at, 'UTC')->setTimezone('Asia/Dili');

            $recentTransactions[] = [
                'transaction_code' => $tx->transaction_code,
                'created_at' => $txTimeTl->toIso8601String(),
                'created_at_tl' => $txTimeTl->format('d/m/Y H:i'),
                'total_amount' => (float) $tx->total_amount,
                'status' => $tx->status,
            ];
        }

        // =====================================================
        // 5. LOW STOCK PRODUCTS
        // =====================================================
        $lowStockProducts = [];

        $lowStockQuery = Product::whereColumn('stock', '<=', 'low_stock_alert')
            ->where('stock', '>', 0)
            ->orderBy('stock')
            ->limit(5)
            ->get();

        foreach ($lowStockQuery as $product) {
            $lowStockProducts[] = [
                'name' => $product->name,
                'category' => $product->category->name ?? 'Umum',
                'stock' => (int) $product->stock,
                'low_stock_alert' => (int) ($product->low_stock_alert ?? 10),
            ];
        }

        // =====================================================
        // FINAL RESPONSE (IDENTIK FLASK)
        // =====================================================
        return response()->json([
            'success' => true,
            'stats' => [
                'revenue' => (float) $totalRevenue,
                'purchase_cost' => (float) $totalPurchaseCost,
                'profit' => (float) $totalProfit,
                'transactions' => (int) $transactionsCount,
                'revenue_change' => 0,
                'purchase_cost_change' => 0,
                'profit_change' => 0,
                'transactions_change' => 0,
            ],
            'charts' => [
                'labels' => $chartLabels,
                'revenue' => $chartRevenue,
                'purchase_cost' => $chartPurchaseCost,
                'profit' => $chartProfit,
            ],
            'tables' => [
                'top_products' => $topProducts,
                'recent_transactions' => $recentTransactions,
                'low_stock' => $lowStockProducts,
            ],
            'period_info' => [
                'period' => $period,
                'start_date' => $startTl->format('Y-m-d'),
                'end_date' => $endTl->format('Y-m-d'),
                'timezone' => 'Asia/Dili (Timor-Leste)',
                'current_tl_time' => $nowTl->format('d/m/Y H:i:s'),
            ],
        ]);
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
