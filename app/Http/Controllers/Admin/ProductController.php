<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products', [
            'products' => Product::with('variants','category')->orderBy('name')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric'
        ]);

        Product::create($request->only([
            'name','description','category_id','price','brand',
            'status','track_inventory','stock','low_stock_alert'
        ]));

        return back()->with('success', 'Produk berhasil ditambahkan');
    }

    public function update(Request $request, int $id)
    {
        $product = Product::findOrFail($id);

        $product->update($request->only([
            'name','description','price','brand',
            'status','stock','low_stock_alert'
        ]));

        return back()->with('success', 'Produk berhasil diperbarui');
    }
}
