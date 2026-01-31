<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\CashDrawer;
use Illuminate\Support\Facades\Auth;

class PosController extends Controller
{
    public function index()
    {
        $drawer = CashDrawer::where('cashier_id', Auth::id())
            ->where('status','open')->first();

        if (!$drawer) {
            return redirect('/cashier/dashboard')
                ->with('danger','Anda harus membuka shift terlebih dahulu');
        }

        return view('cashier.pos', [
            'products' => Product::with('variants')->where('status','active')->get(),
            'categories' => Category::orderBy('name')->get(),
            'cash_drawer' => $drawer
        ]);
    }
}
