<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function create()
    {
        return view('admin.library.itemlibrary.createitem', [
            'categories' => \App\Models\Category::all()
        ]);
    }

    public function store(Request $request)
    {
        dd($request->all()); // ⛔ STOP DI SINI DULU
    }
}
