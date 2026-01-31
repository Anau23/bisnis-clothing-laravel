<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        return view('admin.purchase_orders', [
            'orders' => PurchaseOrder::with('items')->orderByDesc('created_at')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'po_number' => 'required|unique:purchase_orders,po_number',
            'outlet' => 'required|string'
        ]);

        PurchaseOrder::create([
            'po_number' => $request->po_number,
            'outlet' => $request->outlet,
            'supplier' => $request->supplier,
            'note' => $request->note,
            'created_by' => Auth::id(),
            'created_at' => now()
        ]);

        return back()->with('success', 'Purchase Order dibuat');
    }

    public function approve(int $id)
    {
        $po = PurchaseOrder::with('items')->findOrFail($id);

        [$success, $message] = $po->approve(Auth::id());

        return back()->with($success ? 'success' : 'danger', $message);
    }
}
