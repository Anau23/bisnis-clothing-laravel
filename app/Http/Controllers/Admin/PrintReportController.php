<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class PrintReportController extends Controller
{
    /**
     * Print Analytics Report
     */
    public function analytics(Request $request)
    {
        // ===============================
        // PERIODE LAPORAN
        // ===============================
        $startDate = $request->get('start_date')
            ? Carbon::parse($request->start_date)->startOfDay()
            : Carbon::now()->startOfMonth();

        $endDate = $request->get('end_date')
            ? Carbon::parse($request->end_date)->endOfDay()
            : Carbon::now()->endOfDay();

        // ===============================
        // TRANSAKSI PENJUALAN
        // ===============================
        $sales = DB::table('sales')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->get();

        $totalSales        = $sales->sum('total_amount');
        $totalTransactions = $sales->count();
        $totalDiscount     = $sales->sum('discount_amount');
        $totalTax          = $sales->sum('tax_amount');

        $averageTransaction = $totalTransactions > 0
            ? $totalSales / $totalTransactions
            : 0;

        // ===============================
        // DATA HARIAN
        // ===============================
        $dailyData = DB::table('sales')
            ->selectRaw('DATE(created_at) as date')
            ->selectRaw('COUNT(*) as transactions')
            ->selectRaw('SUM(total_amount) as sales')
            ->selectRaw('SUM(discount_amount) as discount')
            ->selectRaw('SUM(tax_amount) as tax')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($row) {
                return [
                    'date'         => Carbon::parse($row->date)->format('d-m-Y'),
                    'transactions' => (int) $row->transactions,
                    'sales'        => (float) $row->sales,
                    'discount'     => (float) $row->discount,
                    'tax'          => (float) $row->tax,
                ];
            });

        // ===============================
        // PRODUK TERLARIS
        // ===============================
        $topProducts = DB::table('sale_items')
            ->join('products', 'products.id', '=', 'sale_items.product_id')
            ->select(
                'products.name',
                DB::raw('SUM(sale_items.quantity) as quantity_sold'),
                DB::raw('SUM(sale_items.subtotal) as total_sales')
            )
            ->whereBetween('sale_items.created_at', [$startDate, $endDate])
            ->groupBy('products.name')
            ->orderByDesc('total_sales')
            ->limit(10)
            ->get()
            ->map(function ($row) {
                return [
                    'name'          => $row->name,
                    'quantity_sold' => (int) $row->quantity_sold,
                    'total_sales'   => (float) $row->total_sales,
                ];
            });

        // ===============================
        // METODE PEMBAYARAN
        // ===============================
        $paymentMethods = DB::table('sales')
            ->select(
                'payment_method',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total_amount) as total')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('payment_method')
            ->get()
            ->map(function ($row) {
                return [
                    'payment_method' => $row->payment_method,
                    'count'          => (int) $row->count,
                    'total'          => (float) $row->total,
                ];
            });

        // ===============================
        // PERFORMA KASIR
        // ===============================
        $cashierPerformance = DB::table('sales')
            ->join('users', 'users.id', '=', 'sales.cashier_id')
            ->select(
                'users.username',
                DB::raw('COUNT(*) as transactions'),
                DB::raw('SUM(sales.total_amount) as sales')
            )
            ->whereBetween('sales.created_at', [$startDate, $endDate])
            ->where('sales.status', 'completed')
            ->groupBy('users.username')
            ->get()
            ->map(function ($row) {
                return [
                    'username'     => $row->username,
                    'transactions' => (int) $row->transactions,
                    'sales'        => (float) $row->sales,
                ];
            });

        // ===============================
        // PURCHASE (OPTIONAL)
        // ===============================
        $purchaseTotal = DB::table('purchases')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_amount');

        // ===============================
        // DATA REPORT FINAL
        // ===============================
        $report = [
            'store_name'          => config('app.name', 'BISNIS CLOTHING'),
            'store_address'       => 'Jl. Contoh No.123',
            'store_phone'         => '021-123456',
            'start_date'          => $startDate->format('d-m-Y'),
            'end_date'            => $endDate->format('d-m-Y'),
            'generated_at'        => Carbon::now()->format('d-m-Y H:i'),
            'generated_by'        => Auth::user()->username ?? 'System',

            'total_sales'         => $totalSales,
            'total_transactions'  => $totalTransactions,
            'average_transaction' => $averageTransaction,
            'total_discount'      => $totalDiscount,
            'total_tax'           => $totalTax,
            'purchase_total'      => $purchaseTotal,

            'daily_data'          => $dailyData,
            'top_products'        => $topProducts,
            'payment_methods'     => $paymentMethods,
            'cashier_performance' => $cashierPerformance,
        ];

        // ===============================
        // RETURN VIEW PRINT
        // ===============================
        return view('admin.print.report', compact('report'));
    }

    public function analyticsPdf(Request $request)
    {
        // Ambil data report yang SAMA
        $reportView = $this->analytics($request);

        $reportData = $reportView->getData()['report'];

        $pdf = Pdf::loadView('admin.print.report', [
            'report' => $reportData
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('laporan-analytics.pdf');
    }

}
