<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;

class ApiController extends Controller
{
    public function products()
    {
        return response()->json(
            Product::with('variants','category')
                ->where('status','active')
                ->orderBy('name')
                ->get()
        );
    }

    public function variants(int $id)
    {
        return response()->json(
            ProductVariant::where('product_id',$id)->get()
        );
    }

    public function stock(int $id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
            'stock' => $product->available_stock,
            'product_name' => $product->name
        ]);
    }

    public function scanBarcode()
    {
        $code = request('code');

        if (!$code) {
            return response()->json(['success'=>false],400);
        }

        if ($variant = ProductVariant::where('barcode',$code)->first()) {
            return response()->json([
                'success'=>true,
                'type'=>'variant',
                'variant'=>$variant,
                'product'=>$variant->product
            ]);
        }

        if ($product = Product::where('barcode',$code)->first()) {
            return response()->json([
                'success'=>true,
                'type'=>'product',
                'product'=>$product
            ]);
        }

        return response()->json(['success'=>false],404);
    }
}
