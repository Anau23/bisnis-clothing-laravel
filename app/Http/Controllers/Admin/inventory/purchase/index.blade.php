<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;

class index extends Controller
{
    public function index()
    {
        return view('admin.inventory.purchase.index');
    }
}
