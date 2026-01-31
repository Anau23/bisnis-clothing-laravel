<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

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
        return view('admin.inventory.purchase.index');
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
