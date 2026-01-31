<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();

        $supplier_stats = [
            'total' => $suppliers->count(),
            'active' => $suppliers->where('status', 'Active')->count(),
            'inactive' => $suppliers->where('status', '!=', 'Active')->count(),
        ];

        return view('admin.inventory.supplier.index', compact(
            'suppliers',
            'supplier_stats'
        ));
    }

}
