<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\CashDrawer;
use App\Models\CashDrawerLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    public function index()
    {
        return view('cashier.shift', [
            'drawers' => CashDrawer::where('cashier_id', Auth::id())
                ->orderByDesc('opened_at')->limit(10)->get(),
            'active' => CashDrawer::where('cashier_id', Auth::id())
                ->where('status','open')->first()
        ]);
    }

    public function open(Request $request)
    {
        $request->validate([
            'opening_balance' => 'required|numeric'
        ]);

        $drawer = CashDrawer::create([
            'drawer_number' => 'SHIFT-'.Auth::id().'-'.now()->format('YmdHis'),
            'cashier_id' => Auth::id(),
            'opening_balance' => $request->opening_balance,
            'status' => 'open',
            'opened_at' => Carbon::now()
        ]);

        CashDrawerLog::create([
            'cash_drawer_id' => $drawer->id,
            'transaction_type' => 'opening',
            'amount' => $request->opening_balance,
            'user_id' => Auth::id(),
            'created_at' => Carbon::now()
        ]);

        return back()->with('success','Shift berhasil dibuka');
    }

    public function close(Request $request)
    {
        $drawer = CashDrawer::where('cashier_id', Auth::id())
            ->where('status','open')->firstOrFail();

        $drawer->actual_cash = $request->actual_cash;
        $drawer->expected_cash = $drawer->opening_balance + $drawer->cash_in - $drawer->cash_out;
        $drawer->difference = $drawer->actual_cash - $drawer->expected_cash;
        $drawer->closing_balance = $drawer->actual_cash;
        $drawer->closed_at = Carbon::now();
        $drawer->status = 'completed';
        $drawer->duration_minutes = Carbon::parse($drawer->opened_at)->diffInMinutes(now());
        $drawer->save();

        CashDrawerLog::create([
            'cash_drawer_id' => $drawer->id,
            'transaction_type' => 'closing',
            'amount' => $drawer->actual_cash,
            'user_id' => Auth::id(),
            'created_at' => Carbon::now()
        ]);

        return back()->with('success','Shift berhasil ditutup');
    }
}
