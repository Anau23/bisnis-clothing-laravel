<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        return view('admin.dashboard', [
            'user' => Auth::user()
        ]);
    }

    public function dashboardData(Request $request)
    {
        $period = $request->get('period', 'week');
        [$start, $end] = $this->getDateRange($period, $request);

        /* ===================== STATS ===================== */

        $revenue = DB::table('transactions')
            ->whereBetween('created_at', [$start, $end])
            ->where('status', 'completed')
            ->sum('total_amount');

        $transactionsCount = DB::table('transactions')
            ->whereBetween('created_at', [$start, $end])
            ->where('status', 'completed')
            ->count();

        $purchaseCost = DB::table('purchase_orders')
            ->whereBetween('created_at', [$start, $end])
            ->whereIn('status', ['fulfilled', 'approved'])
            ->sum('total_amount');

        $profit = $revenue - $purchaseCost;

        /* ===================== CHART ===================== */

        $chartRows = DB::table('transactions')
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
            ->whereBetween('created_at', [$start, $end])
            ->where('status', 'completed')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $revenueData = [];
        $profitData = [];
        $purchaseCostData = [];

        foreach ($chartRows as $row) {
            $labels[] = $row->date;
            $revenueData[] = (float) $row->revenue;
            $profitData[] = (float) $row->revenue; // sementara = revenue (aman utk chart)
            $purchaseCostData[] = 0; // bisa diperdalam nanti
        }

        /* ===================== TABLES ===================== */

        // Recent Transactions
        $recentTransactions = DB::table('transactions')
            ->whereBetween('created_at', [$start, $end])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // Top Products
        $topProducts = DB::table('transaction_items as ti')
            ->join('products as p', 'p.id', '=', 'ti.product_id')
            ->select(
                'p.name',
                'p.category',
                'p.sku',
                DB::raw('SUM(ti.quantity) as total_sold'),
                DB::raw('SUM(ti.subtotal) as total_revenue')
            )
            ->groupBy('p.id', 'p.name', 'p.category', 'p.sku')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Low Stock
        $lowStock = DB::table('products')
            ->whereColumn('stock', '<=', 'low_stock_alert')
            ->select('name', 'stock', 'low_stock_alert', 'category')
            ->orderBy('stock')
            ->limit(5)
            ->get();

        /* ===================== RESPONSE ===================== */

        return response()->json([
            'success' => true,
            'stats' => [
                'revenue' => (float) $revenue,
                'purchase_cost' => (float) $purchaseCost,
                'profit' => (float) $profit,
                'transactions' => $transactionsCount,
            ],
            'charts' => [
                'labels' => $labels,
                'revenue' => $revenueData,
                'profit' => $profitData,
                'purchase_cost' => $purchaseCostData,
            ],
            'tables' => [
                'recent_transactions' => $recentTransactions,
                'top_products' => $topProducts,
                'low_stock' => $lowStock,
            ],
        ]);
    }

    private function getDateRange(string $period): array
    {
        $now = Carbon::now();

        return match ($period) {
            'today' => [
                $now->copy()->startOfDay(),
                $now->copy()->endOfDay()
            ],
            'week' => [
                $now->copy()->startOfWeek(),
                $now->copy()->endOfWeek()
            ],
            'month' => [
                $now->copy()->startOfMonth(),
                $now->copy()->endOfMonth()
            ],
            'year' => [
                $now->copy()->startOfYear(),
                $now->copy()->endOfYear()
            ],
            default => [
                $now->copy()->subDays(6)->startOfDay(),
                $now->copy()->endOfDay()
            ],
        };
    }

    public function categories()
    {
        // 1. Ambil kategori + pagination
        $categories = Category::paginate(10);

        // 2. Total kategori
        $total_categories = Category::count();

        // 3. Total produk (sementara 0 dulu kalau Product belum ada)
        $total_products = 0;

        // 4. Uncategorized (sementara 0)
        $uncategorized_count = 0;

        return view('admin.library.categories.categories', compact(
            'categories',
            'total_products',
            'uncategorized_count'
        ));
    }

    public function items()
    {
        return view('admin.items');
    }

    public function purchase()
    {
        $purchase_orders = collect(); // default aman

        return view('admin.inventory.purchase.index', compact('purchase_orders'));
    }

    public function report()
    {
        return view('admin.report');
    }

    public function summary()
    {
        return view('admin.inventory.summary.summary');
    }
}
